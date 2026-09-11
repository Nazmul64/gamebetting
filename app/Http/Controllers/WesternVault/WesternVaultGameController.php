<?php

namespace App\Http\Controllers\WesternVault;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WesternVaultService;
use App\Services\CasinoCentralTrackingService;
use App\Models\WesternVaultSetting;
use Carbon\Carbon;

class WesternVaultGameController extends Controller {
    protected WesternVaultService $service;
    protected CasinoCentralTrackingService $tracker;

    public function __construct(WesternVaultService $service, CasinoCentralTrackingService $tracker) {
        $this->service = $service;
        $this->tracker = $tracker;
    }

    public function index() {
        $settings = WesternVaultSetting::firstOrCreate([], [
            'game_name' => 'Western Vault',
            'round_duration' => 25
        ]);

        if (auth()->check()) {
            $this->tracker->heartbeat('western_vault', auth()->id(), false);
        }

        return view('customer.western', compact('settings'));
    }

    public function getGameState(Request $request) {
        $round = $this->service->getCurrentOrCreateRound();
        $settings = WesternVaultSetting::firstOrCreate([], [
            'game_name' => 'Western Vault',
            'round_duration' => 25
        ]);
        $now = Carbon::now();

        $isDemo = $request->boolean('is_demo', false);
        if (auth()->check()) {
            $this->tracker->heartbeat('western_vault', auth()->id(), $isDemo);
        }

        if ($now->greaterThanOrEqualTo($round->ends_at) && $round->status === 'betting') {
            $round = $this->service->settleRound($round);
        }

        $user = auth()->user();

        return response()->json([
            'round_id' => $round->round_id,
            'status' => $round->status,
            'time_left' => max(0, $now->diffInSeconds($round->ends_at, false)),
            'total_bets_a' => (float)($round->real_bets_total_a + $round->bot_bets_total_a),
            'total_bets_b' => (float)($round->real_bets_total_b + $round->bot_bets_total_b),
            'winning_side' => $round->winning_side,
            'grid_matrix' => $round->grid_matrix,
            'user_balance' => $user ? (float)$user->balance : null,
            'audio' => [
                'bg' => $settings->bg_music ? (str_starts_with($settings->bg_music, 'assets/') ? asset($settings->bg_music) : asset('storage/' . $settings->bg_music)) : asset('assets/audio/western/western_bg.wav'),
                'spin' => $settings->spin_sound ? (str_starts_with($settings->spin_sound, 'assets/') ? asset($settings->spin_sound) : asset('storage/' . $settings->spin_sound)) : asset('assets/audio/western/western_spin.wav'),
                'win' => $settings->win_sound ? (str_starts_with($settings->win_sound, 'assets/') ? asset($settings->win_sound) : asset('storage/' . $settings->win_sound)) : asset('assets/audio/western/western_win.wav'),
            ]
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'side' => 'required|in:side_a,side_b',
            'amount' => 'required|numeric|min:1',
            'is_demo' => 'required|boolean'
        ]);

        $isDemo = $request->boolean('is_demo');

        try {
            $result = $this->service->executeBet(auth()->user(), $request->all());

            if (!$isDemo) {
                $this->tracker->recordRealTransaction(
                    'western_vault',
                    (float)$request->amount,
                    (float)($result['win_amount'] ?? 0)
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'বেট গৃহীত হয়েছে!',
                'new_balance' => $result['new_balance']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
