<?php

namespace App\Http\Controllers;

use App\Models\OlympusConfig;
use App\Models\OlympusRound;
use App\Models\GameBet;
use App\Models\User;
use App\Services\OlympusEngineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OlympusGameController extends Controller
{
    protected OlympusEngineService $engine;

    public function __construct(OlympusEngineService $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Render the Olympus slot game view with dynamic configuration.
     */
    public function index(Request $request)
    {
        $config = OlympusConfig::getActiveConfig();
        $user = Auth::user();

        // Calculate initial demo balance
        $demoBalance = session('olympus_demo_balance', (float) $config->demo_starting_balance);
        $demoSpinsCount = session('olympus_demo_spins_count', 0);

        if (Auth::check()) {
            app(\App\Services\CasinoCentralTrackingService::class)->heartbeat('olympus_gold', Auth::id(), false);
        }

        return view('customer.gates-of-olympus', compact('config', 'user', 'demoBalance', 'demoSpinsCount'));
    }

    /**
     * Get active game configuration.
     */
    public function getConfig(): JsonResponse
    {
        $config = OlympusConfig::getActiveConfig();
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'config'  => [
                'game_name'                  => $config->game_name,
                'game_status'                => $config->game_status,
                'demo_enabled'               => (bool) $config->demo_enabled,
                'real_enabled'               => (bool) $config->real_enabled,
                'demo_play_limit'            => (int) $config->demo_play_limit,
                'demo_starting_balance'      => (float) $config->demo_starting_balance,
                'login_popup_enabled'        => (bool) $config->login_popup_enabled,
                'min_bet'                    => (float) $config->min_bet,
                'max_bet'                    => (float) $config->max_bet,
                'default_bet'                => (float) $config->default_bet,
                'buy_free_spins_multiplier'  => (float) $config->buy_free_spins_multiplier,
                'double_chance_ante_pct'     => (float) $config->double_chance_ante_pct,
                'rtp_percentage'             => (float) $config->rtp_percentage,
                'volatility'                 => $config->volatility,
                'free_spins_count'           => (int) $config->free_spins_count,
                'max_multiplier'             => (int) $config->max_multiplier,
                'paytable'                   => $config->paytable_json,
                'multipliers'                => $config->multipliers_json,
                'bet_options'                => $config->bet_options_json,
            ],
            'user' => $user ? [
                'id'       => $user->id,
                'name'     => $user->name,
                'balance'  => (float) $user->balance,
                'currency' => $user->currency ?? 'BDT',
            ] : null,
            'demo_spins_count' => session('olympus_demo_spins_count', 0),
            'demo_balance'     => session('olympus_demo_balance', (float) $config->demo_starting_balance),
        ]);
    }

    /**
     * Execute a server-side RNG spin in either Demo or Real Money mode.
     */
    public function spin(Request $request): JsonResponse
    {
        $config = OlympusConfig::getActiveConfig();

        if ($config->game_status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'The game is currently in maintenance mode. Please check back shortly.'
            ], 503);
        }

        $validator = Validator::make($request->all(), [
            'bet_amount'       => 'required|numeric|min:' . $config->min_bet . '|max:' . $config->max_bet,
            'mode'             => 'required|in:demo,real',
            'is_double_chance' => 'nullable|boolean',
            'is_buy_feature'   => 'nullable|boolean',
            'idempotency_key'  => 'nullable|string|max:64',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid parameters: ' . implode(', ', $validator->errors()->all()),
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        $betAmount       = (float) $request->input('bet_amount');
        $mode            = $request->input('mode');
        $isDoubleChance  = (bool) $request->input('is_double_chance', false);
        $isBuyFeature    = (bool) $request->input('is_buy_feature', false);
        $idempotencyKey  = $request->input('idempotency_key');

        // Check for idempotency replay
        if ($idempotencyKey) {
            $existingRound = OlympusRound::where('idempotency_key', $idempotencyKey)->first();
            if ($existingRound) {
                return response()->json([
                    'success'              => true,
                    'round_id'             => $existingRound->round_id,
                    'mode'                 => $existingRound->mode,
                    'is_replay'            => true,
                    'bet_amount'           => $existingRound->bet_amount,
                    'total_deducted'       => $existingRound->total_deducted,
                    'grid'                 => $existingRound->grid_symbols,
                    'winning_shapes'       => $existingRound->winning_shapes,
                    'scatter_count'        => $existingRound->scatter_count,
                    'triggered_free_spins' => $existingRound->triggered_free_spins,
                    'multiplier_symbols'   => $existingRound->multiplier_symbols,
                    'total_multiplier'     => $existingRound->total_multiplier,
                    'base_win'             => $existingRound->base_win,
                    'final_win'            => $existingRound->final_win,
                    'balance'              => $existingRound->balance_after,
                ]);
            }
        }

        // Calculate total wager deducted
        if ($isBuyFeature) {
            $totalDeducted = round($betAmount * $config->buy_free_spins_multiplier, 2);
        } elseif ($isDoubleChance) {
            $totalDeducted = round($betAmount * (1 + ($config->double_chance_ante_pct / 100)), 2);
        } else {
            $totalDeducted = round($betAmount, 2);
        }

        // ==========================================
        // 1. DEMO MODE FLOW
        // ==========================================
        if ($mode === 'demo') {
            if (!$config->demo_enabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'Demo mode is currently disabled by administrator.'
                ], 403);
            }

            $demoLimit = (int) $config->demo_play_limit;
            $demoSpinsCount = (int) session('olympus_demo_spins_count', 0);

            // Check if demo play limit has already been reached
            if ($demoLimit > 0 && $demoSpinsCount >= $demoLimit) {
                return response()->json([
                    'success'          => false,
                    'auth_required'    => true,
                    'limit_reached'    => true,
                    'message'          => 'Your free demo play is complete. Login or create an account to continue.',
                    'demo_spins_count' => $demoSpinsCount,
                    'demo_limit'       => $demoLimit,
                ], 403);
            }

            // Virtual Demo Balance
            $demoBalance = (float) session('olympus_demo_balance', (float) $config->demo_starting_balance);
            if ($demoBalance < $totalDeducted) {
                $demoBalance = (float) $config->demo_starting_balance;
            }

            $balanceBefore = $demoBalance;
            $demoBalance -= $totalDeducted;

            // Generate RNG & Calculate Round
            $grid = $this->engine->generateGrid($config, $isDoubleChance, $isBuyFeature);
            $eval = $this->engine->evaluateRound($grid, $betAmount, $config);

            $finalWin = (float) $eval['final_win'];
            $demoBalance += $finalWin;
            $balanceAfter = $demoBalance;

            // Increment demo spin counter
            $demoSpinsCount++;
            session([
                'olympus_demo_spins_count' => $demoSpinsCount,
                'olympus_demo_balance'     => $demoBalance,
            ]);

            $roundId = 'DEMO-' . strtoupper(Str::random(10));

            // Log demo round for auditing
            OlympusRound::create([
                'round_id'             => $roundId,
                'user_id'              => Auth::id(),
                'session_id'           => session()->getId(),
                'mode'                 => 'demo',
                'bet_amount'           => $betAmount,
                'total_deducted'       => $totalDeducted,
                'is_double_chance'     => $isDoubleChance,
                'is_buy_feature'       => $isBuyFeature,
                'grid_symbols'         => $eval['grid'],
                'winning_shapes'       => $eval['winning_shapes'],
                'scatter_count'        => $eval['scatter_count'],
                'triggered_free_spins' => $eval['triggered_free_spins'],
                'multiplier_symbols'   => $eval['multiplier_symbols'],
                'total_multiplier'     => $eval['total_multiplier'],
                'base_win'             => $eval['base_win'],
                'final_win'            => $finalWin,
                'net_profit'           => $finalWin - $totalDeducted,
                'balance_before'       => $balanceBefore,
                'balance_after'        => $balanceAfter,
                'idempotency_key'      => $idempotencyKey,
                'ip_address'           => $request->ip(),
                'status'               => 'completed',
            ]);

            $isLimitReachedNow = ($demoLimit > 0 && $demoSpinsCount >= $demoLimit);

            return response()->json([
                'success'              => true,
                'round_id'             => $roundId,
                'mode'                 => 'demo',
                'bet_amount'           => $betAmount,
                'total_deducted'       => $totalDeducted,
                'grid'                 => $eval['grid'],
                'winning_shapes'       => $eval['winning_shapes'],
                'winning_cells'        => $eval['winning_cells'],
                'scatter_count'        => $eval['scatter_count'],
                'scatter_cells'        => $eval['scatter_cells'],
                'scatter_win_amount'   => $eval['scatter_win_amount'],
                'triggered_free_spins' => $eval['triggered_free_spins'],
                'free_spins_count'     => $eval['free_spins_count'],
                'multiplier_symbols'   => $eval['multiplier_symbols'],
                'multiplier_cells'     => $eval['multiplier_cells'],
                'total_multiplier'     => $eval['total_multiplier'],
                'base_win'             => $eval['base_win'],
                'final_win'            => $finalWin,
                'balance'              => $balanceAfter,
                'balance_before'       => $balanceBefore,
                'demo_spins_count'     => $demoSpinsCount,
                'demo_limit'           => $demoLimit,
                'limit_reached_now'    => $isLimitReachedNow,
                'currency'             => 'DEMO',
            ]);
        }

        // ==========================================
        // 2. REAL MONEY MODE FLOW
        // ==========================================
        if (!$config->real_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Real money mode is temporarily disabled.'
            ], 403);
        }

        if (!Auth::check()) {
            return response()->json([
                'success'       => false,
                'auth_required' => true,
                'message'       => 'Please login or create an account to play for real money.'
            ], 401);
        }

        $user = Auth::user();

        if ($user->is_blocked) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is blocked. Please contact support.'
            ], 403);
        }

        // Atomic DB transaction to guarantee safety
        $responsePayload = null;

        try {
            DB::transaction(function () use (
                $request,
                $user,
                $config,
                $betAmount,
                $totalDeducted,
                $isDoubleChance,
                $isBuyFeature,
                $idempotencyKey,
                &$responsePayload
            ) {
                // Lock user record for atomic balance update
                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();

                if ((float) $lockedUser->balance < $totalDeducted) {
                    throw new \Exception('INSUFFICIENT_BALANCE');
                }

                $balanceBefore = (float) $lockedUser->balance;
                $lockedUser->balance -= $totalDeducted;

                // Generate RNG & Calculate Round
                $grid = $this->engine->generateGrid($config, $isDoubleChance, $isBuyFeature);
                $eval = $this->engine->evaluateRound($grid, $betAmount, $config);

                $finalWin = (float) $eval['final_win'];
                $lockedUser->balance += $finalWin;
                $balanceAfter = (float) $lockedUser->balance;
                $lockedUser->save();

                $roundId = 'OLY-' . strtoupper(Str::random(12));

                // Save Olympus Round Record
                OlympusRound::create([
                    'round_id'             => $roundId,
                    'user_id'              => $lockedUser->id,
                    'session_id'           => session()->getId(),
                    'mode'                 => 'real',
                    'bet_amount'           => $betAmount,
                    'total_deducted'       => $totalDeducted,
                    'is_double_chance'     => $isDoubleChance,
                    'is_buy_feature'       => $isBuyFeature,
                    'grid_symbols'         => $eval['grid'],
                    'winning_shapes'       => $eval['winning_shapes'],
                    'scatter_count'        => $eval['scatter_count'],
                    'triggered_free_spins' => $eval['triggered_free_spins'],
                    'multiplier_symbols'   => $eval['multiplier_symbols'],
                    'total_multiplier'     => $eval['total_multiplier'],
                    'base_win'             => $eval['base_win'],
                    'final_win'            => $finalWin,
                    'net_profit'           => $finalWin - $totalDeducted,
                    'balance_before'       => $balanceBefore,
                    'balance_after'        => $balanceAfter,
                    'idempotency_key'      => $idempotencyKey,
                    'ip_address'           => $request->ip(),
                    'status'               => 'completed',
                ]);

                // Also record in GameBet for platform dashboard bet history if model exists
                try {
                    if (class_exists(GameBet::class)) {
                        GameBet::create([
                            'user_id'      => $lockedUser->id,
                            'round_id'     => $roundId,
                            'bet_amount'   => $totalDeducted,
                            'cashout_odds' => (float) ($eval['total_multiplier'] ?: 1.0),
                            'crash_point'  => (float) ($eval['total_multiplier'] ?: 1.0),
                            'winnings'     => $finalWin,
                            'result'       => $finalWin > 0 ? 'win' : 'lose',
                        ]);
                    }
                } catch (\Throwable $tb) {
                    // Non-blocking for GameBet legacy table
                }

                $responsePayload = [
                    'success'              => true,
                    'round_id'             => $roundId,
                    'mode'                 => 'real',
                    'bet_amount'           => $betAmount,
                    'total_deducted'       => $totalDeducted,
                    'grid'                 => $eval['grid'],
                    'winning_shapes'       => $eval['winning_shapes'],
                    'winning_cells'        => $eval['winning_cells'],
                    'scatter_count'        => $eval['scatter_count'],
                    'scatter_cells'        => $eval['scatter_cells'],
                    'scatter_win_amount'   => $eval['scatter_win_amount'],
                    'triggered_free_spins' => $eval['triggered_free_spins'],
                    'free_spins_count'     => $eval['free_spins_count'],
                    'multiplier_symbols'   => $eval['multiplier_symbols'],
                    'multiplier_cells'     => $eval['multiplier_cells'],
                    'total_multiplier'     => $eval['total_multiplier'],
                    'base_win'             => $eval['base_win'],
                    'final_win'            => $finalWin,
                    'balance'              => $balanceAfter,
                    'balance_before'       => $balanceBefore,
                    'currency'             => $lockedUser->currency ?? 'BDT',
                ];
            });

            return response()->json($responsePayload);
        } catch (\Exception $e) {
            if ($e->getMessage() === 'INSUFFICIENT_BALANCE') {
                return response()->json([
                    'success'              => false,
                    'insufficient_balance' => true,
                    'current_balance'      => (float) $user->balance,
                    'required_amount'      => $totalDeducted,
                    'message'              => 'Insufficient balance. Please deposit funds or switch to Demo mode.'
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => 'Transaction error: ' . $e->getMessage()
            ], 500);
        }

        // Record real money turnover and payouts in Central Ledger
        try {
            app(\App\Services\CasinoCentralTrackingService::class)->recordRealTransaction(
                'olympus_gold',
                (float)$totalDeducted,
                (float)($responsePayload['final_win'] ?? 0)
            );
        } catch (\Throwable $t) {}

        return response()->json($responsePayload);
    }

    /**
     * Get player round history.
     */
    public function history(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $query = OlympusRound::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        $rounds = $query->orderByDesc('id')
            ->limit(20)
            ->get([
                'round_id',
                'mode',
                'bet_amount',
                'total_deducted',
                'total_multiplier',
                'final_win',
                'created_at',
            ]);

        return response()->json([
            'success' => true,
            'rounds'  => $rounds,
        ]);
    }
}
