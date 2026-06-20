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

        return view('admin.dashboard', compact('totalUsers', 'totalDeposits', 'recentUsers'));
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

    /**
     * Get all crash points ordered by sort_order.
     */
    public function getCrashPoints()
    {
        $points = CrashPoint::orderBy('sort_order')->orderBy('id')->get();
        return response()->json(['success' => true, 'points' => $points]);
    }

    /**
     * Create a new crash point.
     */
    public function createCrashPoint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'point'  => 'required|numeric|min:1.00|max:1000.00',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $maxOrder = CrashPoint::max('sort_order') ?? 0;

        $cp = CrashPoint::create([
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
            'point'  => 'required|numeric|min:1.00|max:1000.00',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $cp->update([
            'point'  => $request->point,
            'status' => $request->status,
        ]);

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
     * Returns the next crash point in sequence and advances the internal index.
     * The sequence cycles through active crash points only.
     * This is called by the game engine at the start of each round.
     */
    public function getNextCrashPoint()
    {
        // Check if there was an advancement within the last 4 seconds to prevent multiple increments in same round
        $lastTimeRecord = DB::table('game_state')->where('key', 'last_advancement_time')->first();
        $lastTime = $lastTimeRecord ? (int) $lastTimeRecord->value : 0;
        
        $currentValRecord = DB::table('game_state')->where('key', 'current_crash_point_value')->first();
        $currentVal = $currentValRecord ? (float) $currentValRecord->value : null;

        $currentRoundIdRecord = DB::table('game_state')->where('key', 'current_round_id')->first();
        $currentRoundId = $currentRoundIdRecord ? $currentRoundIdRecord->value : null;

        $now = time();
        $timeDiff = $now - $lastTime;

        $settings = [
            'active_helicopter_design' => Setting::getVal('active_helicopter_design', '1'),
            'game_countdown_time'      => Setting::getVal('game_countdown_time', '10'),
            'game_bg_music'            => Setting::getVal('game_bg_music', ''),
            'game_countdown_sound'     => Setting::getVal('game_countdown_sound', ''),
        ];

        // Retrieve recent crash history from DB
        $historyRecord = DB::table('game_state')->where('key', 'recent_crash_history')->first();
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
                    ['key' => 'recent_crash_history'],
                    ['value' => json_encode(array_values($history)), 'updated_at' => now(), 'created_at' => now()]
                );
            }
        }

        // Generate new round ID
        $newRoundId = 'RC-' . mt_rand(100000, 999999);

        // Get next crash point
        $activePoints = CrashPoint::where('status', 'active')
                                   ->orderBy('sort_order')
                                   ->orderBy('id')
                                   ->get();

        if ($activePoints->isEmpty()) {
            // NO RANDOM FALLBACK — admin must configure crash points.
            // Return a failure so the game client waits and retries.
            return response()->json([
                'success'        => false,
                'message'        => 'No active crash points configured. Please add crash points in Admin Panel.',
                'no_points'      => true,
                'recent_history' => array_values($history)
            ]);
        }

        $stateRecord = DB::table('game_state')->where('key', 'crash_sequence_index')->first();
        $currentIndex = $stateRecord ? (int) $stateRecord->value : 0;
        if ($currentIndex >= $activePoints->count()) {
            $currentIndex = 0;
        }
        $nextPoint = $activePoints[$currentIndex];
        $nextPointVal = (float)$nextPoint->point;
        $nextIndex = ($currentIndex + 1) % $activePoints->count();

        DB::table('game_state')->updateOrInsert(
            ['key' => 'crash_sequence_index'],
            ['value' => $nextIndex, 'updated_at' => now(), 'created_at' => now()]
        );
        $source = 'admin_sequence';

        // Save updated values in DB
        DB::table('game_state')->updateOrInsert(
            ['key' => 'last_advancement_time'],
            ['value' => $now, 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('game_state')->updateOrInsert(
            ['key' => 'current_crash_point_value'],
            ['value' => $nextPointVal, 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('game_state')->updateOrInsert(
            ['key' => 'current_round_id'],
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
     * ADMIN: Force crash the current game round immediately.
     * Sets a flag in game_state that the game engine polls every second.
     */
    public function forceCrash()
    {
        DB::table('game_state')->updateOrInsert(
            ['key' => 'force_crash'],
            ['value' => '1', 'updated_at' => now(), 'created_at' => now()]
        );

        return response()->json([
            'success' => true,
            'message' => 'Force crash signal sent! Game will crash on next poll.'
        ]);
    }

    /**
     * GAME CLIENT: Check if admin has triggered a force crash.
     * Returns true once, then clears the flag automatically.
     */
    public function checkForceCrash()
    {
        $record = DB::table('game_state')->where('key', 'force_crash')->first();

        if ($record && $record->value === '1') {
            // Clear immediately so it only fires once
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
    public function checkStatus()
    {
        $record = DB::table('game_state')->where('key', 'force_crash')->first();
        $forceCrash = false;

        if ($record && $record->value === '1') {
            // Clear immediately so it only fires once
            DB::table('game_state')->where('key', 'force_crash')->update([
                'value'      => '0',
                'updated_at' => now()
            ]);
            $forceCrash = true;
        }

        $currentVal = DB::table('game_state')->where('key', 'current_crash_point_value')->value('value') ?? 1.00;
        $currentRoundId = DB::table('game_state')->where('key', 'current_round_id')->value('value');

        $realBets = [];
        if ($currentRoundId) {
            $realBets = DB::table('game_bets')
                ->join('users', 'game_bets.user_id', '=', 'users.id')
                ->where('game_bets.round_id', $currentRoundId)
                ->where('game_bets.user_id', '!=', Auth::id()) // exclude current user
                ->select('users.name', 'game_bets.bet_amount', 'game_bets.cashout_odds', 'game_bets.winnings', 'game_bets.result')
                ->get()
                ->map(function($bet) {
                    $rawName = $bet->name;
                    $len = strlen($rawName);
                    // Mask username
                    $masked = $len > 4 ? substr($rawName, 0, 2) . '***' . substr($rawName, -2) : $rawName . '***';
                    
                    // Generate a deterministic nice avatar for the real user based on their name
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
            'force_crash' => $forceCrash,
            'crash_point' => (float)$currentVal,
            'real_bets'   => $realBets
        ]);
    }

    /**
     * ADMIN: Get live status of the running game round for the monitor panel.
     */
    public function getGameStatus()
    {
        $seqIndex = DB::table('game_state')->where('key', 'crash_sequence_index')->value('value') ?? 0;
        $currentVal = DB::table('game_state')->where('key', 'current_crash_point_value')->value('value') ?? 1.00;
        $lastTime = DB::table('game_state')->where('key', 'last_advancement_time')->value('value') ?? 0;
        $roundId = DB::table('game_state')->where('key', 'current_round_id')->value('value') ?? 'N/A';
        $forceCrash = DB::table('game_state')->where('key', 'force_crash')->value('value') ?? '0';

        $countdownDuration = (int)Setting::getVal('game_countdown_time', '10');
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

        // Count real bets placed on this round
        $totalRealBets = 0.00;
        $realBetsCount = 0;
        if ($roundId !== 'N/A') {
            $realBetsCount = DB::table('game_bets')->where('round_id', $roundId)->count();
            $totalRealBets = (float)DB::table('game_bets')->where('round_id', $roundId)->sum('bet_amount');
        }

        return response()->json([
            'success'               => true,
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
        return response()->json([
            'success' => true,
            'settings' => [
                'referral_commission_l1' => Setting::getVal('referral_commission_l1', '10'),
                'referral_commission_l1_status' => Setting::getVal('referral_commission_l1_status', 'active'),
                'referral_commission_l2' => Setting::getVal('referral_commission_l2', '5'),
                'referral_commission_l2_status' => Setting::getVal('referral_commission_l2_status', 'active'),
                'referral_commission_l3' => Setting::getVal('referral_commission_l3', '2'),
                'referral_commission_l3_status' => Setting::getVal('referral_commission_l3_status', 'active'),
                'withdraw_commission' => Setting::getVal('withdraw_commission', '5'),
                'withdraw_commission_status' => Setting::getVal('withdraw_commission_status', 'active'),
                'active_helicopter_design' => Setting::getVal('active_helicopter_design', '1'),
                'game_bg_music' => Setting::getVal('game_bg_music', ''),
                'game_countdown_sound' => Setting::getVal('game_countdown_sound', ''),
                'game_countdown_time' => Setting::getVal('game_countdown_time', '10'),
            ]
        ]);
    }

    /**
     * Save Platform Settings.
     */
    public function saveSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referral_commission_l1' => 'required|numeric|min:0|max:100',
            'referral_commission_l1_status' => 'required|in:active,inactive',
            'referral_commission_l2' => 'required|numeric|min:0|max:100',
            'referral_commission_l2_status' => 'required|in:active,inactive',
            'referral_commission_l3' => 'required|numeric|min:0|max:100',
            'referral_commission_l3_status' => 'required|in:active,inactive',
            'withdraw_commission' => 'required|numeric|min:0|max:100',
            'withdraw_commission_status' => 'required|in:active,inactive',
            'active_helicopter_design' => 'required|integer|min:1|max:10',
            'game_bg_music_file' => 'nullable|file|mimes:mp3,wav,ogg,mpeg,mp4|max:15360', // 15MB max
            'game_countdown_sound_file' => 'nullable|file|mimes:mp3,wav,ogg,mpeg,mp4|max:5120', // 5MB max
            'game_countdown_time' => 'required|integer|min:2|max:60',
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
        Setting::setVal('active_helicopter_design', $request->active_helicopter_design);
        Setting::setVal('game_countdown_time', $request->game_countdown_time);

        if ($request->hasFile('game_bg_music_file')) {
            $file = $request->file('game_bg_music_file');
            $fileName = 'bg_music_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sounds'), $fileName);
            Setting::setVal('game_bg_music', '/uploads/sounds/' . $fileName);
        }

        if ($request->hasFile('game_countdown_sound_file')) {
            $file = $request->file('game_countdown_sound_file');
            $fileName = 'countdown_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sounds'), $fileName);
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
            'active_helicopter_design' => $request->active_helicopter_design,
            'game_countdown_time' => $request->game_countdown_time,
        ]);

        return response()->json(['success' => true, 'message' => 'Platform settings updated successfully.']);
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
}
