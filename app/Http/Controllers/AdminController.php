<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CrashPoint;
use App\Models\Setting;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Show the admin login page.
     * Redirect to admin dashboard if already logged in as admin.
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        // Attempt login with email + password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Check if the user is actually admin
            if (!Auth::user()->is_admin) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'errors'  => ['Access denied. This account does not have admin privileges.']
                ], 403);
            }

            $request->session()->regenerate();

            return response()->json([
                'success'  => true,
                'message'  => 'Admin login successful.',
                'redirect' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'errors'  => ['Invalid email or password.']
        ], 422);
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Compute multi-game comparative analytics for all active casino game engines.
     */
    public function getGamePerformanceMatrix()
    {
        $tracker = app(\App\Services\CasinoCentralTrackingService::class);
        $tracker->syncHistoricData();

        $registries = \App\Models\CasinoGameRegistry::all()->keyBy('game_key');

        $gamesConfig = [
            'helicopterx' => [
                'id' => 'helicopterx',
                'name' => 'HelicopterX',
                'category' => 'Multiplayer Crash',
                'icon' => 'fas fa-helicopter',
                'theme' => '#f59e0b',
                'route' => route('play', ['game' => 'helicopterx']),
            ],
            '1xaero' => [
                'id' => '1xaero',
                'name' => '1xAero',
                'category' => 'Multiplayer Crash',
                'icon' => 'fas fa-jet-fighter',
                'theme' => '#00f2fe',
                'route' => route('play', ['game' => '1xaero']),
            ],
            'aero' => [
                'id' => 'aero',
                'name' => 'Aero',
                'category' => 'Multiplayer Crash',
                'icon' => 'fas fa-plane',
                'theme' => '#ef4444',
                'route' => route('play', ['game' => 'aero']),
            ],
            'crashx' => [
                'id' => 'crashx',
                'name' => 'CrashX',
                'category' => 'Multiplayer Crash',
                'icon' => 'fas fa-rocket',
                'theme' => '#10b981',
                'route' => route('play', ['game' => 'crashx']),
            ],
            'crash' => [
                'id' => 'crash',
                'name' => 'Crash (1xGames)',
                'category' => 'Multiplayer Crash',
                'icon' => 'fas fa-meteor',
                'theme' => '#8b5cf6',
                'route' => route('play', ['game' => 'crash']),
            ],
            'olympus_gold' => [
                'id' => 'olympus',
                'name' => 'Olympus Gold™',
                'category' => 'Cluster Pays Slot',
                'icon' => 'fas fa-bolt',
                'theme' => '#fbbf24',
                'route' => route('gates-of-olympus'),
            ],
            'western_vault' => [
                'id' => 'western-vault',
                'name' => 'Western Vault™',
                'category' => 'PVP Vault Duel',
                'icon' => 'fas fa-vault',
                'theme' => '#f97316',
                'route' => route('western'),
            ],
            'fortune_gems_2' => [
                'id' => 'fortune-gems-2',
                'name' => 'Fortune Gems 2™',
                'category' => 'Cascading Gem Slot (3x3)',
                'icon' => 'fas fa-gem',
                'theme' => '#f59e0b',
                'route' => route('fortune-gems-2'),
            ],
            'boxing_king' => [
                'id' => 'boxing-king',
                'name' => 'Boxing King™',
                'category' => 'Video Slot (5x3)',
                'icon' => 'fas fa-crown',
                'theme' => '#ef4444',
                'route' => route('boxing-king'),
            ],
            'abyss_of_glory' => [
                'id' => 'abyss-of-glory',
                'name' => 'Abyss of Glory™',
                'category' => 'Temple Multiplier Slot',
                'icon' => 'fas fa-landmark',
                'theme' => '#fbbf24',
                'route' => route('temple-of-fortune'),
            ],
            'heads_or_tails' => [
                'id' => 'heads-or-tails',
                'name' => 'Heads or Tails™',
                'category' => 'Mermaid & Octopus Coin Toss',
                'icon' => 'fas fa-coins',
                'theme' => '#eab308',
                'route' => route('heads-or-tails'),
            ],
            'lucky_joker_100' => [
                'id' => 'lucky-joker-100',
                'name' => 'Lucky Joker 100™',
                'category' => 'Classic Fruit & Joker Slot',
                'icon' => 'fas fa-hat-cowboy-side',
                'theme' => '#f43f5e',
                'route' => route('lucky-joker-100'),
            ],
            'bonbon_bonanza' => [
                'id' => 'bonbon-bonanza',
                'name' => 'BonBon Bonanza™',
                'category' => 'Sweet Candy Cascading Slot',
                'icon' => 'fas fa-candy-cane',
                'theme' => '#e879f9',
                'route' => route('bonbon-bonanza'),
            ],
            'big_bass_splash' => [
                'id' => 'big-bass',
                'name' => 'Big Bass Splash™',
                'category' => 'Fishing Multiplier Slot',
                'icon' => 'fas fa-fish',
                'theme' => '#0ea5e9',
                'route' => route('big-bass-splash'),
            ],
            'the_emirate' => [
                'id' => 'the-emirate',
                'name' => 'The Emirate™',
                'category' => 'Royal Arabic Classic Slot',
                'icon' => 'fas fa-gem',
                'theme' => '#f59e0b',
                'route' => route('the-emirate'),
            ],
            'royal_emirates' => [
                'id' => 'royal-emirates',
                'name' => 'Royal Emirates™',
                'category' => 'Hold and Spin Slot (5x3)',
                'icon' => 'fas fa-coins',
                'theme' => '#fbbf24',
                'route' => route('royal-emirates'),
            ],
            'wingo' => [
                'id' => 'wingo',
                'name' => 'WinGo Lottery™',
                'category' => 'Color & Number Prediction (30s/1m/3m/5m)',
                'icon' => 'fas fa-dice',
                'theme' => '#00b977',
                'route' => route('wingo.index'),
            ],
            'k3' => [
                'id' => 'k3',
                'name' => 'K3 Lottery™',
                'category' => '3-Dice Fast Prediction (1m/3m/5m/10m)',
                'icon' => 'fas fa-cubes',
                'theme' => '#10b981',
                'route' => route('k3.index'),
            ],
            'trx_wingo' => [
                'id' => 'trxwingo',
                'name' => 'TrxWinGo Lottery™',
                'category' => 'TRON Public Chain Block Hash (1m/3m/5m)',
                'icon' => 'fas fa-cube',
                'theme' => '#00b977',
                'route' => route('trxwingo.index'),
            ],
        ];

        $matrix = [];
        foreach ($gamesConfig as $gameKey => $cfg) {
            $reg = $registries->get($gameKey);
            $turnover = $reg ? (float)$reg->total_real_bets : 0.0;
            $payout = $reg ? (float)$reg->total_real_payouts : 0.0;
            $profit = $reg ? (float)$reg->net_house_profit : 0.0;
            $activeUsers = $reg ? (int)$reg->active_real_players_count : 0;
            $health = $reg ? $reg->health_status : 'healthy';
            $rtp = $turnover > 0 ? round(($payout / $turnover) * 100, 2) : 96.50;

            $matrix[] = array_merge($cfg, [
                'active_players' => $activeUsers,
                'total_turnover' => $turnover,
                'total_payout'   => $payout,
                'admin_profit'   => $profit,
                'rtp'            => $rtp,
                'health_status'  => $health,
                'status'         => 'ONLINE'
            ]);
        }

        return $matrix;
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers    = User::where('is_admin', false)->count();
        $totalDeposits = User::where('is_admin', false)->sum('balance');
        $recentUsers   = User::where('is_admin', false)
                            ->orderBy('created_at', 'desc')
                            ->limit(20)
                            ->get();
        $gameMatrix    = $this->getGamePerformanceMatrix();

        return view('admin.dashboard', compact('totalUsers', 'totalDeposits', 'recentUsers', 'gameMatrix'));
    }

    /**
     * API to fetch dynamic game matrix JSON
     */
    public function getGamePerformanceMatrixApi()
    {
        return response()->json([
            'success' => true,
            'matrix' => $this->getGamePerformanceMatrix()
        ]);
    }

    /**
     * Get all users as JSON for admin dashboard data tables.
     */
    public function getUsers()
    {
        $users = User::where('is_admin', false)
                     ->orderBy('created_at', 'desc')
                     ->get(['id', 'name', 'email', 'mobile', 'country', 'currency', 'balance', 'is_blocked', 'created_at']);

        return response()->json(['success' => true, 'users' => $users]);
    }

    /**
     * Update a user's balance (admin override).
     */
    public function updateUserBalance(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'balance' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        $user = User::where('id', $id)->where('is_admin', false)->first();

        if (!$user) {
            return response()->json(['success' => false, 'errors' => ['User not found.']], 404);
        }

        $user->balance = $request->balance;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Balance updated successfully for ' . $user->name . '.',
            'balance' => number_format($user->balance, 2, '.', '')
        ]);
    }

    /**
     * Toggle ban/unban a user account by resetting balance or blocking access.
     * For simplicity, we toggle balance to 0 as a "freeze" action.
     */
    public function deleteUser(Request $request, $id)
    {
        $user = User::where('id', $id)->where('is_admin', false)->first();

        if (!$user) {
            return response()->json(['success' => false, 'errors' => ['User not found.']], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User account removed from system.'
        ]);
    }

    /**
     * Toggle block/unblock a user account.
     */
    public function toggleBlockUser(Request $request, $id)
    {
        $user = User::where('id', $id)->where('is_admin', false)->first();

        if (!$user) {
            return response()->json(['success' => false, 'errors' => ['User not found.']], 404);
        }

        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $action = $user->is_blocked ? 'blocked' : 'unblocked';

        return response()->json([
            'success'    => true,
            'is_blocked' => $user->is_blocked,
            'message'    => 'User ' . $user->name . ' has been ' . $action . ' successfully.'
        ]);
    }

    /**
     * Get platform summary stats.
     */
    public function getStats()
    {
        $totalUsers     = User::where('is_admin', false)->count();
        $totalBalance   = User::where('is_admin', false)->sum('balance');
        $newUsersToday  = User::where('is_admin', false)
                              ->whereDate('created_at', today())
                              ->count();
        $activeCountries = User::where('is_admin', false)
                               ->distinct('country')
                               ->count('country');

        return response()->json([
            'success'          => true,
            'total_users'      => $totalUsers,
            'total_balance'    => number_format($totalBalance, 2, '.', ''),
            'new_today'        => $newUsersToday,
            'active_countries' => $activeCountries,
        ]);
    }

    // =============================================
    // CRASH GAME POINTS MANAGEMENT
    // =============================================

    // =============================================
    // CRASH GAME POINTS MANAGEMENT (MULTI-GAME)
    // =============================================

    /**
     * Get all crash points, optionally filtered by game_key.
     */
    public function getCrashPoints(Request $request)
    {
        $gameKey = $request->query('game_key');
        $query = CrashPoint::orderBy('sort_order')->orderBy('id');
        if ($gameKey && in_array($gameKey, ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'])) {
            $query->where('game_key', $gameKey);
        }
        $points = $query->get();
        return response()->json(['success' => true, 'points' => $points, 'game_key' => $gameKey]);
    }

    /**
     * Create a new crash point for a specific game.
     */
    public function createCrashPoint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_key' => 'nullable|string|in:helicopterx,1xaero,aero,crashx,crash',
            'point'    => 'required|numeric|min:1.00|max:1000.00',
            'status'   => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $gameKey = $request->input('game_key', 'helicopterx');
        $maxOrder = CrashPoint::where('game_key', $gameKey)->max('sort_order') ?? 0;

        $cp = CrashPoint::create([
            'game_key'   => $gameKey,
            'point'      => $request->point,
            'status'     => $request->status,
            'sort_order' => $maxOrder + 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Crash point added.', 'point' => $cp]);
    }

    /**
     * Update an existing crash point.
     */
    public function updateCrashPoint(Request $request, $id)
    {
        $cp = CrashPoint::find($id);
        if (!$cp) {
            return response()->json(['success' => false, 'errors' => ['Crash point not found.']], 404);
        }

        $validator = Validator::make($request->all(), [
            'game_key' => 'nullable|string|in:helicopterx,1xaero,aero,crashx,crash',
            'point'    => 'required|numeric|min:1.00|max:1000.00',
            'status'   => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $updateData = [
            'point'  => $request->point,
            'status' => $request->status,
        ];
        if ($request->has('game_key')) {
            $updateData['game_key'] = $request->game_key;
        }

        $cp->update($updateData);

        return response()->json(['success' => true, 'message' => 'Crash point updated.', 'point' => $cp]);
    }

    /**
     * Delete a crash point.
     */
    public function deleteCrashPoint($id)
    {
        $cp = CrashPoint::find($id);
        if (!$cp) {
            return response()->json(['success' => false, 'errors' => ['Crash point not found.']], 404);
        }

        $cp->delete();

        return response()->json(['success' => true, 'message' => 'Crash point deleted.']);
    }

    /**
     * PUBLIC endpoint (auth required for logged-in players).
     * Returns the next crash point in sequence for the given game and advances its index.
     */
    public function getNextCrashPoint(Request $request)
    {
        $game = strtolower($request->query('game', 'helicopterx'));
        $validGames = ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'];
        if (!in_array($game, $validGames)) {
            $game = 'helicopterx';
        }

        $lastTimeKey = 'last_advancement_time_' . $game;
        $currentValKey = 'current_crash_point_value_' . $game;
        $currentRoundKey = 'current_round_id_' . $game;
        $historyKey = 'recent_crash_history_' . $game;
        $seqIndexKey = 'crash_sequence_index_' . $game;

        $lastTimeRecord = DB::table('game_state')->where('key', $lastTimeKey)->first();
        $lastTime = $lastTimeRecord ? (int) $lastTimeRecord->value : 0;
        
        $currentValRecord = DB::table('game_state')->where('key', $currentValKey)->first();
        $currentVal = $currentValRecord ? (float) $currentValRecord->value : null;

        $currentRoundIdRecord = DB::table('game_state')->where('key', $currentRoundKey)->first();
        $currentRoundId = $currentRoundIdRecord ? $currentRoundIdRecord->value : null;

        $now = time();
        $timeDiff = $now - $lastTime;

        $defaultDesigns = [
            'helicopterx' => '2',
            '1xaero'      => '1',
            'aero'        => '7',
            'crashx'      => '6',
            'crash'       => '5',
        ];

        $settings = [
            'game'                     => $game,
            'active_helicopter_design' => Setting::getVal("active_helicopter_design_{$game}", Setting::getVal('active_helicopter_design', $defaultDesigns[$game] ?? '1')),
            'game_countdown_time'      => Setting::getVal("game_countdown_time_{$game}", Setting::getVal('game_countdown_time', '10')),
            'game_bg_music'            => Setting::getVal("game_bg_music_{$game}", Setting::getVal('game_bg_music', '')),
            'game_countdown_sound'     => Setting::getVal("game_countdown_sound_{$game}", Setting::getVal('game_countdown_sound', '')),
        ];

        // Retrieve recent crash history from DB for this game
        $historyRecord = DB::table('game_state')->where('key', $historyKey)->first();
        $history = $historyRecord ? json_decode($historyRecord->value, true) : [1.85, 12.04, 1.03, 2.50, 1.25, 4.33, 1.12, 18.50, 1.54, 3.22, 1.01, 1.08, 2.15, 1.44, 9.50];
        if (!is_array($history)) {
            $history = [1.85, 12.04, 1.03, 2.50, 1.25, 4.33, 1.12, 18.50, 1.54, 3.22, 1.01, 1.08, 2.15, 1.44, 9.50];
        }

        if ($lastTimeRecord && $currentValRecord && $currentRoundId && $timeDiff < 4 && !is_null($currentVal)) {
            // Within 4 seconds, reuse the current round's values
            return response()->json(array_merge([
                'success'        => true,
                'crash_point'    => $currentVal,
                'round_id'       => $currentRoundId,
                'source'         => 'admin_sequence_cached',
                'recent_history' => array_values($history)
            ], $settings));
        }

        // Clean up previous round's pending bets
        if ($currentRoundId) {
            \App\Models\GameBet::where('round_id', $currentRoundId)
                ->where('result', 'pending')
                ->update([
                    'crash_point' => $currentVal ?? 1.00,
                    'result'      => 'lose',
                    'winnings'    => 0.00
                ]);
        }

        // Save completed round's crash point to history
        if (!is_null($currentVal)) {
            $lastLogged = end($history);
            if ($lastLogged !== (float)$currentVal) {
                $history[] = (float)$currentVal;
                if (count($history) > 20) {
                    $history = array_slice($history, -20);
                }
                DB::table('game_state')->updateOrInsert(
                    ['key' => $historyKey],
                    ['value' => json_encode(array_values($history)), 'updated_at' => now(), 'created_at' => now()]
                );
            }
        }

        // Generate new round ID
        $prefixMap = [
            'helicopterx' => 'HX-',
            '1xaero'      => 'AX-',
            'aero'        => 'AE-',
            'crashx'      => 'CX-',
            'crash'       => 'RC-',
        ];
        $prefix = $prefixMap[$game] ?? 'RC-';
        $newRoundId = $prefix . mt_rand(100000, 999999);

        // Get next crash point for this game
        $activePoints = CrashPoint::where('game_key', $game)
                                   ->where('status', 'active')
                                   ->orderBy('sort_order')
                                   ->orderBy('id')
                                   ->get();

        if ($activePoints->isEmpty()) {
            // Fallback to any active points if game-specific ones are not yet configured
            $activePoints = CrashPoint::where('status', 'active')
                                       ->orderBy('sort_order')
                                       ->orderBy('id')
                                       ->get();
        }

        if ($activePoints->isEmpty()) {
            return response()->json([
                'success'        => false,
                'message'        => "No active crash points configured for {$game}. Please add crash points in Admin Panel.",
                'no_points'      => true,
                'recent_history' => array_values($history)
            ]);
        }

        $stateRecord = DB::table('game_state')->where('key', $seqIndexKey)->first();
        $currentIndex = $stateRecord ? (int) $stateRecord->value : 0;
        if ($currentIndex >= $activePoints->count()) {
            $currentIndex = 0;
        }
        $nextPoint = $activePoints[$currentIndex];
        $nextPointVal = (float)$nextPoint->point;
        $nextIndex = ($currentIndex + 1) % $activePoints->count();

        DB::table('game_state')->updateOrInsert(
            ['key' => $seqIndexKey],
            ['value' => $nextIndex, 'updated_at' => now(), 'created_at' => now()]
        );
        $source = 'admin_sequence';

        // Save updated values in DB for this game
        DB::table('game_state')->updateOrInsert(
            ['key' => $lastTimeKey],
            ['value' => $now, 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('game_state')->updateOrInsert(
            ['key' => $currentValKey],
            ['value' => $nextPointVal, 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('game_state')->updateOrInsert(
            ['key' => $currentRoundKey],
            ['value' => $newRoundId, 'updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(array_merge([
            'success'        => true,
            'crash_point'    => $nextPointVal,
            'round_id'       => $newRoundId,
            'source'         => $source,
            'recent_history' => array_values($history)
        ], $settings));
    }

    /**
     * ADMIN: Force crash game round(s) immediately.
     */
    public function forceCrash(Request $request)
    {
        $game = strtolower($request->input('game_key', 'all'));
        $gamesList = ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'];

        if ($game === 'all') {
            foreach ($gamesList as $g) {
                DB::table('game_state')->updateOrInsert(
                    ['key' => 'force_crash_' . $g],
                    ['value' => '1', 'updated_at' => now(), 'created_at' => now()]
                );
            }
            DB::table('game_state')->updateOrInsert(
                ['key' => 'force_crash'],
                ['value' => '1', 'updated_at' => now(), 'created_at' => now()]
            );
            $msg = 'Force crash signal sent to all 5 crash games!';
        } else {
            DB::table('game_state')->updateOrInsert(
                ['key' => 'force_crash_' . $game],
                ['value' => '1', 'updated_at' => now(), 'created_at' => now()]
            );
            $msg = "Force crash signal sent to {$game}!";
        }

        return response()->json([
            'success' => true,
            'message' => $msg
        ]);
    }

    /**
     * GAME CLIENT: Check if admin has triggered a force crash for this game.
     */
    public function checkForceCrash(Request $request)
    {
        $game = strtolower($request->query('game', 'helicopterx'));
        $record = DB::table('game_state')->where('key', 'force_crash_' . $game)->first();
        if (!$record) {
            $record = DB::table('game_state')->where('key', 'force_crash')->first();
        }

        if ($record && $record->value === '1') {
            DB::table('game_state')->where('key', 'force_crash_' . $game)->update([
                'value'      => '0',
                'updated_at' => now()
            ]);
            DB::table('game_state')->where('key', 'force_crash')->update([
                'value'      => '0',
                'updated_at' => now()
            ]);
            return response()->json(['success' => true, 'force_crash' => true]);
        }

        return response()->json(['success' => true, 'force_crash' => false]);
    }

    /**
     * GAME CLIENT: Check force crash and sync crash point.
     */
    public function checkStatus(Request $request)
    {
        $game = strtolower($request->query('game', 'helicopterx'));
        $record = DB::table('game_state')->where('key', 'force_crash_' . $game)->first();
        if (!$record) {
            $record = DB::table('game_state')->where('key', 'force_crash')->first();
        }
        $forceCrash = false;

        if ($record && $record->value === '1') {
            DB::table('game_state')->where('key', 'force_crash_' . $game)->update([
                'value'      => '0',
                'updated_at' => now()
            ]);
            DB::table('game_state')->where('key', 'force_crash')->update([
                'value'      => '0',
                'updated_at' => now()
            ]);
            $forceCrash = true;
        }

        $currentVal = DB::table('game_state')->where('key', 'current_crash_point_value_' . $game)->value('value') 
            ?? DB::table('game_state')->where('key', 'current_crash_point_value')->value('value') 
            ?? 1.00;
            
        $currentRoundId = DB::table('game_state')->where('key', 'current_round_id_' . $game)->value('value')
            ?? DB::table('game_state')->where('key', 'current_round_id')->value('value');

        $realBets = [];
        if ($currentRoundId) {
            $realBets = DB::table('game_bets')
                ->join('users', 'game_bets.user_id', '=', 'users.id')
                ->where('game_bets.round_id', $currentRoundId)
                ->where('game_bets.user_id', '!=', Auth::id())
                ->select('users.name', 'game_bets.bet_amount', 'game_bets.cashout_odds', 'game_bets.winnings', 'game_bets.result')
                ->get()
                ->map(function($bet) {
                    $rawName = $bet->name;
                    $len = strlen($rawName);
                    $masked = $len > 4 ? substr($rawName, 0, 2) . '***' . substr($rawName, -2) : $rawName . '***';
                    $avatarId = (crc32($rawName) % 70) + 1;
                    $gender = (crc32($rawName) % 2 === 0) ? 'men' : 'women';
                    $avatar = "https://randomuser.me/api/portraits/thumb/{$gender}/{$avatarId}.jpg";

                    return [
                        'username'     => $masked,
                        'avatar'       => $avatar,
                        'bet_amount'   => (float)$bet->bet_amount,
                        'cashout_odds' => $bet->cashout_odds ? (float)$bet->cashout_odds : null,
                        'winnings'     => (float)$bet->winnings,
                        'result'       => $bet->result
                    ];
                });
        }

        return response()->json([
            'success'     => true,
            'game'        => $game,
            'force_crash' => $forceCrash,
            'crash_point' => (float)$currentVal,
            'real_bets'   => $realBets
        ]);
    }

    /**
     * ADMIN: Get live status of the running game round for the monitor panel.
     */
    public function getGameStatus(Request $request)
    {
        $game = strtolower($request->query('game', 'helicopterx'));
        $validGames = ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'];
        if (!in_array($game, $validGames)) {
            $game = 'helicopterx';
        }

        $seqIndex = DB::table('game_state')->where('key', 'crash_sequence_index_' . $game)->value('value') ?? 0;
        $currentVal = DB::table('game_state')->where('key', 'current_crash_point_value_' . $game)->value('value') ?? 1.00;
        $lastTime = DB::table('game_state')->where('key', 'last_advancement_time_' . $game)->value('value') ?? 0;
        $roundId = DB::table('game_state')->where('key', 'current_round_id_' . $game)->value('value') ?? 'N/A';
        $forceCrash = DB::table('game_state')->where('key', 'force_crash_' . $game)->value('value') ?? '0';

        $countdownDuration = (int)Setting::getVal("game_countdown_time_{$game}", Setting::getVal('game_countdown_time', '10'));
        $now = time();
        $elapsed = $now - (int)$lastTime;

        $gameState = 'CRASHED';
        $multiplier = (float)$currentVal;

        if ($elapsed < $countdownDuration) {
            $gameState = 'COUNTDOWN';
            $multiplier = 1.00;
        } else {
            $flightTime = $elapsed - $countdownDuration;
            $currentMultiplier = exp(0.06 * $flightTime);
            if ($currentMultiplier < (float)$currentVal) {
                $gameState = 'PLAYING';
                $multiplier = $currentMultiplier;
            }
        }

        $totalRealBets = 0.00;
        $realBetsCount = 0;
        if ($roundId !== 'N/A') {
            $realBetsCount = DB::table('game_bets')->where('round_id', $roundId)->count();
            $totalRealBets = (float)DB::table('game_bets')->where('round_id', $roundId)->sum('bet_amount');
        }

        return response()->json([
            'success'               => true,
            'game'                  => $game,
            'sequence_index'        => (int)$seqIndex,
            'current_crash_value'   => (float)$currentVal,
            'last_start_time'       => (int)$lastTime,
            'current_round_id'      => $roundId,
            'game_state'            => $gameState,
            'current_multiplier'    => round($multiplier, 2),
            'real_bets_count'       => $realBetsCount,
            'total_real_bets'       => $totalRealBets,
            'force_crash_flag'      => $forceCrash === '1'
        ]);
    }

    /**
     * Get Platform Settings.
     */
    public function getSettings()
    {
        $games = ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'];
        $defaultDesigns = [
            'helicopterx' => '2',
            '1xaero'      => '1',
            'aero'        => '7',
            'crashx'      => '6',
            'crash'       => '5',
        ];

        $settings = [
            'referral_commission_l1'        => Setting::getVal('referral_commission_l1', '10'),
            'referral_commission_l1_status' => Setting::getVal('referral_commission_l1_status', 'active'),
            'referral_commission_l2'        => Setting::getVal('referral_commission_l2', '5'),
            'referral_commission_l2_status' => Setting::getVal('referral_commission_l2_status', 'active'),
            'referral_commission_l3'        => Setting::getVal('referral_commission_l3', '2'),
            'referral_commission_l3_status' => Setting::getVal('referral_commission_l3_status', 'active'),
            'withdraw_commission'           => Setting::getVal('withdraw_commission', '5'),
            'withdraw_commission_status'    => Setting::getVal('withdraw_commission_status', 'active'),
            // Global legacy fallbacks
            'active_helicopter_design'      => Setting::getVal('active_helicopter_design', '1'),
            'game_bg_music'                 => Setting::getVal('game_bg_music', ''),
            'game_countdown_sound'          => Setting::getVal('game_countdown_sound', ''),
            'game_countdown_time'           => Setting::getVal('game_countdown_time', '10'),
        ];

        // Add settings for all 5 crash games
        foreach ($games as $g) {
            $settings["active_helicopter_design_{$g}"] = Setting::getVal("active_helicopter_design_{$g}", $defaultDesigns[$g] ?? '1');
            $settings["game_countdown_time_{$g}"]      = Setting::getVal("game_countdown_time_{$g}", '10');
            $settings["game_bg_music_{$g}"]            = Setting::getVal("game_bg_music_{$g}", '');
            $settings["game_countdown_sound_{$g}"]     = Setting::getVal("game_countdown_sound_{$g}", '');
        }

        return response()->json([
            'success'  => true,
            'settings' => $settings
        ]);
    }

    /**
     * Save Platform Settings for Referral Commissions and all 5 Crash Games.
     */
    public function saveSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referral_commission_l1'        => 'required|numeric|min:0|max:100',
            'referral_commission_l1_status' => 'required|in:active,inactive',
            'referral_commission_l2'        => 'required|numeric|min:0|max:100',
            'referral_commission_l2_status' => 'required|in:active,inactive',
            'referral_commission_l3'        => 'required|numeric|min:0|max:100',
            'referral_commission_l3_status' => 'required|in:active,inactive',
            'withdraw_commission'           => 'required|numeric|min:0|max:100',
            'withdraw_commission_status'    => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        Setting::setVal('referral_commission_l1', $request->referral_commission_l1);
        Setting::setVal('referral_commission_l1_status', $request->referral_commission_l1_status);
        Setting::setVal('referral_commission_l2', $request->referral_commission_l2);
        Setting::setVal('referral_commission_l2_status', $request->referral_commission_l2_status);
        Setting::setVal('referral_commission_l3', $request->referral_commission_l3);
        Setting::setVal('referral_commission_l3_status', $request->referral_commission_l3_status);
        Setting::setVal('withdraw_commission', $request->withdraw_commission);
        Setting::setVal('withdraw_commission_status', $request->withdraw_commission_status);

        $games = ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'];

        // Ensure upload directory exists
        $uploadDir = public_path('uploads/sounds');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($games as $g) {
            // Save flight design
            if ($request->has("active_helicopter_design_{$g}")) {
                Setting::setVal("active_helicopter_design_{$g}", $request->input("active_helicopter_design_{$g}"));
            }
            // Save countdown time
            if ($request->has("game_countdown_time_{$g}")) {
                Setting::setVal("game_countdown_time_{$g}", $request->input("game_countdown_time_{$g}"));
            }
            // Upload BG music file
            if ($request->hasFile("game_bg_music_file_{$g}")) {
                $file = $request->file("game_bg_music_file_{$g}");
                $fileName = "bg_music_{$g}_" . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $fileName);
                Setting::setVal("game_bg_music_{$g}", '/uploads/sounds/' . $fileName);
            }
            // Upload countdown sound file
            if ($request->hasFile("game_countdown_sound_file_{$g}")) {
                $file = $request->file("game_countdown_sound_file_{$g}");
                $fileName = "countdown_{$g}_" . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $fileName);
                Setting::setVal("game_countdown_sound_{$g}", '/uploads/sounds/' . $fileName);
            }
        }

        // Also update legacy values if provided
        if ($request->has('active_helicopter_design')) {
            Setting::setVal('active_helicopter_design', $request->active_helicopter_design);
        }
        if ($request->has('game_countdown_time')) {
            Setting::setVal('game_countdown_time', $request->game_countdown_time);
        }
        if ($request->hasFile('game_bg_music_file')) {
            $file = $request->file('game_bg_music_file');
            $fileName = 'bg_music_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            Setting::setVal('game_bg_music', '/uploads/sounds/' . $fileName);
        }
        if ($request->hasFile('game_countdown_sound_file')) {
            $file = $request->file('game_countdown_sound_file');
            $fileName = 'countdown_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            Setting::setVal('game_countdown_sound', '/uploads/sounds/' . $fileName);
        }

        // Log setting changes for security audit
        $this->logAdminAction('update_settings', [
            'referral_commissions' => [
                'l1' => $request->referral_commission_l1 . '% (' . $request->referral_commission_l1_status . ')',
                'l2' => $request->referral_commission_l2 . '% (' . $request->referral_commission_l2_status . ')',
                'l3' => $request->referral_commission_l3 . '% (' . $request->referral_commission_l3_status . ')',
            ],
            'withdraw_commission' => $request->withdraw_commission . '% (' . $request->withdraw_commission_status . ')',
        ]);

        return response()->json(['success' => true, 'message' => 'Platform settings for all 5 Crash Games updated successfully.']);
    }

    /**
     * Get Payment Gateways.
     */
    public function getGateways()
    {
        $gateways = PaymentGateway::orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'gateways' => $gateways]);
    }

    /**
     * Save/Update Payment Gateway.
     */
    public function saveGateway(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:manual,auto',
            'methods' => 'required|in:deposit,withdraw,both',
            'status' => 'required|in:active,inactive',
            'settings' => 'nullable|string', 
            'deposit_fields' => 'nullable|string', 
            'logo' => 'nullable|image|max:2048', 
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $id = $request->input('id');
        $gateway = $id ? PaymentGateway::find($id) : new PaymentGateway();

        if ($id && !$gateway) {
            return response()->json(['success' => false, 'errors' => ['Gateway not found.']], 404);
        }

        $gateway->name = $request->name;
        $gateway->type = $request->type;
        $gateway->methods = $request->methods;
        $gateway->status = $request->status;

        $settingsArr = json_decode($request->settings, true) ?: [];
        $fieldsArr = json_decode($request->deposit_fields, true) ?: [];
        $gateway->settings = $settingsArr;
        $gateway->deposit_fields = $fieldsArr;

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move(public_path('uploads/gateways'), $logoName);
            $gateway->logo = '/uploads/gateways/' . $logoName;
        }

        $gateway->save();

        return response()->json([
            'success' => true,
            'message' => $id ? 'Payment gateway updated successfully.' : 'Payment gateway created successfully.',
            'gateway' => $gateway
        ]);
    }

    /**
     * Delete Payment Gateway.
     */
    public function deleteGateway($id)
    {
        $gateway = PaymentGateway::find($id);
        if (!$gateway) {
            return response()->json(['success' => false, 'errors' => ['Gateway not found.']], 404);
        }
        $gateway->delete();
        return response()->json(['success' => true, 'message' => 'Payment gateway deleted successfully.']);
    }

    /**
     * Get all withdrawal requests for admin management.
     */
    public function getWithdrawals()
    {
        $withdrawals = Transaction::with('user:id,name,email,mobile,currency')
                                  ->where('type', 'Withdraw')
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return response()->json([
            'success' => true,
            'withdrawals' => $withdrawals->map(function ($t) {
                return [
                    'id' => $t->id,
                    'user_id' => $t->user_id,
                    'user_name' => $t->user ? $t->user->name : 'N/A',
                    'user_email' => $t->user ? $t->user->email : 'N/A',
                    'user_currency' => $t->user ? $t->user->currency : 'BDT',
                    'gateway' => $t->gateway,
                    'amount' => (float)$t->amount,
                    'fee' => (float)$t->fee,
                    'net_payable' => isset($t->metadata['net_payable']) ? (float)$t->metadata['net_payable'] : (float)($t->amount - $t->fee),
                    'account_number' => isset($t->metadata['account_number']) ? $t->metadata['account_number'] : 'N/A',
                    'status' => $t->status,
                    'created_at' => $t->created_at->format('d M Y, h:i A'),
                ];
            })
        ]);
    }

    /**
     * Approve or reject a withdrawal request.
     */
    public function processWithdrawal(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approve,reject',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $transaction = Transaction::where('id', $id)->where('type', 'Withdraw')->first();
        if (!$transaction) {
            return response()->json(['success' => false, 'errors' => ['Withdrawal transaction not found.']], 404);
        }

        if ($transaction->status !== 'Pending') {
            return response()->json(['success' => false, 'errors' => ['This transaction has already been processed.']], 422);
        }

        $user = User::find($transaction->user_id);
        if (!$user) {
            return response()->json(['success' => false, 'errors' => ['User associated with withdrawal not found.']], 404);
        }

        if ($request->action === 'approve') {
            // Check if user has sufficient balance at approval time
            if ($user->balance < $transaction->amount) {
                return response()->json([
                    'success' => false,
                    'errors' => ['Insufficient user balance. Cannot approve this withdrawal.']
                ], 422);
            }

            // Deduct balance upon approval
            $user->balance -= $transaction->amount;
            $user->save();

            $transaction->status = 'Completed';
            $transaction->save();
            return response()->json(['success' => true, 'message' => 'Withdrawal approved successfully. Balance deducted.']);
        } else {
            // Reject: update status to Failed. No balance deduction occurred on submit, so no refund is needed.
            $transaction->status = 'Failed';
            $transaction->save();

            return response()->json(['success' => true, 'message' => 'Withdrawal request rejected successfully.']);
        }
    }

    /**
     * Get all deposit requests for admin management.
     */
    public function getDeposits()
    {
        $deposits = Transaction::with('user:id,name,email,mobile,currency')
                               ->where('type', 'Deposit')
                               ->orderBy('created_at', 'desc')
                               ->get();

        return response()->json([
            'success' => true,
            'deposits' => $deposits->map(function ($t) {
                return [
                    'id' => $t->id,
                    'user_id' => $t->user_id,
                    'user_name' => $t->user ? $t->user->name : 'N/A',
                    'user_email' => $t->user ? $t->user->email : 'N/A',
                    'user_currency' => $t->user ? $t->user->currency : 'BDT',
                    'gateway' => $t->gateway,
                    'amount' => (float)$t->amount,
                    'status' => $t->status,
                    'sender_number' => isset($t->metadata['sender_number']) ? $t->metadata['sender_number'] : 'N/A',
                    'transaction_id' => isset($t->metadata['transaction_id']) ? $t->metadata['transaction_id'] : 'N/A',
                    'screenshot' => isset($t->metadata['screenshot']) ? $t->metadata['screenshot'] : null,
                    'rejection_reason' => isset($t->metadata['rejection_reason']) ? $t->metadata['rejection_reason'] : null,
                    'created_at' => $t->created_at->format('d M Y, h:i A'),
                ];
            })
        ]);
    }

    /**
     * Process deposit request: approve or reject.
     */
    public function processDeposit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $transaction = Transaction::where('id', $id)->where('type', 'Deposit')->first();
        if (!$transaction) {
            return response()->json(['success' => false, 'errors' => ['Deposit transaction not found.']], 404);
        }

        if ($transaction->status !== 'Pending') {
            return response()->json(['success' => false, 'errors' => ['This transaction has already been processed.']], 422);
        }

        $user = User::find($transaction->user_id);
        if (!$user) {
            return response()->json(['success' => false, 'errors' => ['User associated with deposit not found.']], 404);
        }

        if ($request->action === 'approve') {
            DB::beginTransaction();
            try {
                // Increase user balance
                $user->balance += $transaction->amount;
                $user->save();

                // 3-Generation referral commission payouts (only when approved!)
                $L1_status = Setting::getVal('referral_commission_l1_status', 'active');
                $L2_status = Setting::getVal('referral_commission_l2_status', 'active');
                $L3_status = Setting::getVal('referral_commission_l3_status', 'active');

                $L1_pct = (float)Setting::getVal('referral_commission_l1', '10');
                $L2_pct = (float)Setting::getVal('referral_commission_l2', '5');
                $L3_pct = (float)Setting::getVal('referral_commission_l3', '2');

                $parent1 = $user->referred_by ? User::find($user->referred_by) : null;
                if ($parent1) {
                    if ($L1_status === 'active') {
                        $comm1 = round($transaction->amount * ($L1_pct / 100), 2);
                        if ($comm1 > 0) {
                            $parent1->balance += $comm1;
                            $parent1->save();
                            Transaction::create([
                                'user_id' => $parent1->id,
                                'type' => 'Referral Commission L1',
                                'gateway' => $user->name,
                                'amount' => $comm1,
                                'status' => 'Completed',
                                'metadata' => ['from_user' => $user->name, 'from_user_id' => $user->id, 'deposit_transaction_id' => $transaction->id]
                            ]);
                        }
                    }

                    $parent2 = $parent1->referred_by ? User::find($parent1->referred_by) : null;
                    if ($parent2) {
                        if ($L2_status === 'active') {
                            $comm2 = round($transaction->amount * ($L2_pct / 100), 2);
                            if ($comm2 > 0) {
                                $parent2->balance += $comm2;
                                $parent2->save();
                                Transaction::create([
                                    'user_id' => $parent2->id,
                                    'type' => 'Referral Commission L2',
                                    'gateway' => $user->name,
                                    'amount' => $comm2,
                                    'status' => 'Completed',
                                    'metadata' => ['from_user' => $user->name, 'from_user_id' => $user->id, 'deposit_transaction_id' => $transaction->id]
                                ]);
                            }
                        }

                        $parent3 = $parent2->referred_by ? User::find($parent2->referred_by) : null;
                        if ($parent3) {
                            if ($L3_status === 'active') {
                                $comm3 = round($transaction->amount * ($L3_pct / 100), 2);
                                if ($comm3 > 0) {
                                    $parent3->balance += $comm3;
                                    $parent3->save();
                                    Transaction::create([
                                        'user_id' => $parent3->id,
                                        'type' => 'Referral Commission L3',
                                        'gateway' => $user->name,
                                        'amount' => $comm3,
                                        'status' => 'Completed',
                                        'metadata' => ['from_user' => $user->name, 'from_user_id' => $user->id, 'deposit_transaction_id' => $transaction->id]
                                    ]);
                                }
                            }
                        }
                    }
                }

                $transaction->status = 'Completed';
                $transaction->save();

                DB::commit();

                // Audit Log
                $this->logAdminAction('approve_deposit', [
                    'transaction_id' => $transaction->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'amount' => $transaction->amount,
                ]);

                return response()->json(['success' => true, 'message' => 'Deposit approved successfully. Balance and commissions updated.']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'errors' => ['Failed to approve deposit: ' . $e->getMessage()]], 500);
            }
        } else {
            // Reject: update status to Failed and save rejection reason
            $metadata = $transaction->metadata ?: [];
            $metadata['rejection_reason'] = $request->rejection_reason;
            $transaction->metadata = $metadata;
            $transaction->status = 'Failed';
            $transaction->save();

            // Audit Log
            $this->logAdminAction('reject_deposit', [
                'transaction_id' => $transaction->id,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'amount' => $transaction->amount,
                'reason' => $request->rejection_reason,
            ]);

            return response()->json(['success' => true, 'message' => 'Deposit request rejected successfully.']);
        }
    }

    /**
     * Helper to log admin actions for auditing security.
     */
    protected function logAdminAction($action, $details = [])
    {
        $dir = storage_path('app/logs');
        if (!file_exists($dir)) {
            @mkdir($dir, 0755, true);
        }
        $logPath = $dir . '/admin_actions.log';
        $logData = [
            'timestamp' => now()->toIso8601String(),
            'admin_id' => Auth::id(),
            'admin_email' => Auth::user() ? Auth::user()->email : 'N/A',
            'action' => $action,
            'details' => $details,
            'ip' => request()->ip(),
        ];
        @file_put_contents($logPath, json_encode($logData) . PHP_EOL, FILE_APPEND);
    }

    /**
     * Get list of unique users who have support messages.
     */
    public function getChatsList()
    {
        $chats = DB::table('support_messages')
            ->join('users', 'support_messages.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.mobile',
                DB::raw('MAX(support_messages.created_at) as last_message_time'),
                DB::raw('(SELECT message FROM support_messages sm2 WHERE sm2.user_id = users.id ORDER BY sm2.created_at DESC LIMIT 1) as last_message'),
                DB::raw('SUM(CASE WHEN support_messages.sender = "user" AND support_messages.is_read = 0 THEN 1 ELSE 0 END) as unread_count')
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.mobile')
            ->orderBy('last_message_time', 'desc')
            ->get();

        return response()->json(['success' => true, 'chats' => $chats]);
    }

    /**
     * Get chat history with a specific user.
     */
    public function getUserChat($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'errors' => ['User not found.']], 404);
        }

        $messages = \App\Models\SupportMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark user messages as read when admin opens the chat
        \App\Models\SupportMessage::where('user_id', $userId)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
            ],
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender' => $msg->sender,
                    'message' => $msg->message,
                    'time' => $msg->created_at->diffForHumans(),
                    'datetime' => $msg->created_at->format('d M Y, h:i A'),
                ];
            })
        ]);
    }

    /**
     * Send support message from admin to a customer.
     */
    public function sendAdminMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $msg = \App\Models\SupportMessage::create([
            'user_id' => $request->user_id,
            'sender' => 'admin',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin response sent.',
            'data' => [
                'id' => $msg->id,
                'sender' => $msg->sender,
                'message' => $msg->message,
                'time' => 'Just now',
                'datetime' => $msg->created_at->format('d M Y, h:i A'),
            ]
        ]);
    }

    /**
     * Get active Olympus slot configuration.
     */
    public function getOlympusSettings(): \Illuminate\Http\JsonResponse
    {
        $config = \App\Models\OlympusConfig::getActiveConfig();
        return response()->json([
            'success' => true,
            'config'  => $config,
        ]);
    }

    /**
     * Save Olympus slot configuration and write audit logs.
     */
    public function saveOlympusSettings(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'game_status'                      => 'required|in:active,maintenance',
            'demo_enabled'                     => 'required|boolean',
            'real_enabled'                     => 'required|boolean',
            'demo_play_limit'                 => 'required|integer|min:0|max:100',
            'demo_starting_balance'           => 'required|numeric|min:10',
            'login_popup_enabled'             => 'required|boolean',
            'min_bet'                         => 'required|numeric|min:0.1',
            'max_bet'                         => 'required|numeric|min:1',
            'default_bet'                     => 'required|numeric|min:0.1',
            'buy_free_spins_multiplier'       => 'required|numeric|min:1',
            'double_chance_ante_pct'          => 'required|numeric|min:0',
            'rtp_percentage'                  => 'required|numeric|min:50|max:100',
            'volatility'                      => 'required|in:low,medium,high',
            'required_scatters_for_free_spins'=> 'required|integer|min:3|max:6',
            'free_spins_count'                => 'required|integer|min:1|max:50',
            'max_multiplier'                  => 'required|integer|min:10|max:5000',
            'paytable_json'                   => 'nullable|array',
            'multipliers_json'                => 'nullable|array',
            'bet_options_json'                => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        $config = \App\Models\OlympusConfig::getActiveConfig();
        $adminId = Auth::id();
        $ip = $request->ip();

        $data = $request->only([
            'game_status',
            'demo_enabled',
            'real_enabled',
            'demo_play_limit',
            'demo_starting_balance',
            'login_popup_enabled',
            'min_bet',
            'max_bet',
            'default_bet',
            'buy_free_spins_multiplier',
            'double_chance_ante_pct',
            'rtp_percentage',
            'volatility',
            'required_scatters_for_free_spins',
            'free_spins_count',
            'max_multiplier',
        ]);

        if ($request->has('paytable_json')) {
            $data['paytable_json'] = $request->paytable_json;
        }
        if ($request->has('multipliers_json')) {
            $data['multipliers_json'] = $request->multipliers_json;
        }
        if ($request->has('bet_options_json')) {
            $data['bet_options_json'] = $request->bet_options_json;
        }

        // Track and log changes in AuditLog
        foreach ($data as $key => $newValue) {
            $oldValue = $config->{$key};
            $oldSerialized = is_array($oldValue) ? json_encode($oldValue) : (string) $oldValue;
            $newSerialized = is_array($newValue) ? json_encode($newValue) : (string) $newValue;

            if ($oldSerialized !== $newSerialized) {
                \App\Models\OlympusAuditLog::create([
                    'admin_id'    => $adminId,
                    'setting_key' => $key,
                    'old_value'   => $oldSerialized,
                    'new_value'   => $newSerialized,
                    'ip_address'  => $ip,
                ]);
            }
        }

        $config->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Olympus Slot Game configuration updated successfully.',
            'config'  => $config->fresh(),
        ]);
    }

    /**
     * Get paginated Olympus player rounds for admin review.
     */
    public function getOlympusRounds(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = \App\Models\OlympusRound::with('user:id,name,email');

        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $rounds = $query->orderByDesc('id')->paginate(20);

        return response()->json([
            'success' => true,
            'rounds'  => $rounds,
        ]);
    }

    /**
     * Get Olympus admin audit logs.
     */
    public function getOlympusAuditLogs(Request $request): \Illuminate\Http\JsonResponse
    {
        $logs = \App\Models\OlympusAuditLog::with('admin:id,name,email')
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'logs'    => $logs,
        ]);
    }

    /**
     * Update Site Branding, Custom Logo, and Global Demo Spins Limit.
     */
    public function updateBrandingSettings(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'site_name' => 'nullable|string|max:100',
            'demo_spins_limit' => 'nullable|integer|min:1|max:100',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            'remove_logo' => 'nullable|boolean',
        ]);

        if ($request->filled('site_name')) {
            Setting::setVal('site_name', trim($request->site_name));
        }

        if ($request->filled('demo_spins_limit')) {
            Setting::setVal('demo_spins_limit', (int)$request->demo_spins_limit);
        }

        if ($request->boolean('remove_logo')) {
            $oldLogo = Setting::getVal('site_logo');
            if ($oldLogo && file_exists(public_path($oldLogo))) {
                @unlink(public_path($oldLogo));
            }
            Setting::setVal('site_logo', null);
        } elseif ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = 'site_logo_' . time() . '.' . $file->getClientOriginalExtension();
            $destDir = public_path('assets/image/uploads');
            if (!\Illuminate\Support\Facades\File::isDirectory($destDir)) {
                \Illuminate\Support\Facades\File::makeDirectory($destDir, 0755, true, true);
            }
            $file->move($destDir, $filename);
            Setting::setVal('site_logo', 'assets/image/uploads/' . $filename);
        }

        return response()->json([
            'success' => true,
            'message' => 'Site branding and Demo limit settings saved successfully!',
            'site_name' => Setting::getVal('site_name', '1XBET'),
            'site_logo' => Setting::getVal('site_logo') ? asset(Setting::getVal('site_logo')) : null,
            'demo_spins_limit' => (int)Setting::getVal('demo_spins_limit', 3),
        ]);
    }

    /**
     * Get Site Branding and Demo Settings.
     */
    public function getBrandingSettings(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'site_name' => Setting::getVal('site_name', '1XBET'),
            'site_logo' => Setting::getVal('site_logo') ? asset(Setting::getVal('site_logo')) : null,
            'demo_spins_limit' => (int)Setting::getVal('demo_spins_limit', 3),
        ]);
    }
}

