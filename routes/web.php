<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    if (request()->has('ref')) {
        session(['referred_by' => request()->query('ref')]);
    }
    return view('frontend.index');
})->name('home');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Blocked account page (accessible without full auth so blocked user sees the message)
Route::get('/blocked', function () {
    return view('customer.blocked');
})->name('blocked');

Route::post('/blocked/check-in', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $user->is_blocked = false;
        $user->save();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
})->middleware('auth')->name('blocked.checkin');

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/play', function () {
    return view('customer.game');
})->middleware('auth')->name('play');
Route::get('/gems-mines', function () {
    return view('customer.gems-mines');
})->middleware('auth')->name('gems-mines');

Route::get('/big-bass-splash', function () {
    return view('customer.big-bass-splash');
})->middleware('auth')->name('big-bass-splash');

Route::get('/bonbon-bonanza', function () {
    return view('customer.bonbon-bonanza');
})->middleware('auth')->name('bonbon-bonanza');

Route::get('/lucky-joker-100', function () {
    return view('customer.lucky-joker-100');
})->middleware('auth')->name('lucky-joker-100');

Route::get('/the-emirate', function () {
    return view('customer.the-emirate');
})->middleware('auth')->name('the-emirate');

Route::get('/royal-emirates', function () {
    return view('customer.royal-emirates');
})->middleware('auth')->name('royal-emirates');

Route::get('/elves-kingdom', function () {
    return view('customer.elves-kingdom');
})->middleware('auth')->name('elves-kingdom');

Route::get('/treasure-climb', function () {
    return view('customer.treasure-climb');
})->middleware('auth')->name('treasure-climb');

Route::get('/western', function () {
    return view('customer.western');
})->middleware('auth')->name('western');

Route::get('/temple-of-fortune', function () {
    return view('customer.temple-of-fortune');
})->middleware('auth')->name('temple-of-fortune');

Route::get('/heads-or-tails', function () {
    return view('customer.heads-or-tails');
})->middleware('auth')->name('heads-or-tails');

Route::get('/heads-or-tails/fixed', function () {
    return view('customer.heads-or-tails-game');
})->middleware('auth')->name('heads-or-tails.fixed');

Route::get('/heads-or-tails/doubling', function () {
    return view('customer.heads-or-tails-doubling');
})->middleware('auth')->name('heads-or-tails.doubling');




Route::post('/dashboard/deposit', [DashboardController::class, 'deposit'])->middleware('auth')->name('dashboard.deposit');
Route::post('/dashboard/withdraw', [DashboardController::class, 'withdraw'])->middleware('auth')->name('dashboard.withdraw');
Route::post('/dashboard/transfer', [DashboardController::class, 'transfer'])->middleware('auth')->name('dashboard.transfer');
Route::post('/dashboard/update-profile', [DashboardController::class, 'updateProfile'])->middleware('auth')->name('dashboard.update-profile');
Route::post('/dashboard/update-balance', [DashboardController::class, 'updateBalance'])->middleware('auth')->name('dashboard.update-balance');
Route::post('/dashboard/update-theme', [DashboardController::class, 'updateTheme'])->middleware('auth')->name('dashboard.update-theme');
Route::get('/game/active-settings', [DashboardController::class, 'getActiveSettings'])->middleware('auth')->name('game.active-settings');
Route::get('/support/messages', [DashboardController::class, 'getSupportMessages'])->middleware('auth')->name('support.messages');
Route::post('/support/messages', [DashboardController::class, 'sendSupportMessage'])->middleware('auth')->name('support.messages.send');

// DB backed history logs and gateways listing
Route::get('/dashboard/transactions', [DashboardController::class, 'getTransactions'])->middleware('auth')->name('dashboard.transactions');
Route::get('/dashboard/referrals', [DashboardController::class, 'getReferrals'])->middleware('auth')->name('dashboard.referrals');
Route::get('/dashboard/gateways', [DashboardController::class, 'getGateways'])->middleware('auth')->name('dashboard.gateways');

// =============================================
// ADMIN Routes (Protected by auth + is_admin)
// =============================================
use App\Http\Controllers\AdminController;

Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->middleware(['auth', 'is_admin'])->name('admin.logout');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'getUsers'])->name('users');
    Route::get('/stats', [AdminController::class, 'getStats'])->name('stats');
    Route::get('/chats', [AdminController::class, 'getChatsList'])->name('chats.list');
    Route::get('/chats/{userId}', [AdminController::class, 'getUserChat'])->name('chats.user');
    Route::post('/chats/send', [AdminController::class, 'sendAdminMessage'])->name('chats.send');
    Route::post('/users/{id}/balance', [AdminController::class, 'updateUserBalance'])->name('users.balance');
    Route::post('/users/{id}/toggle-block', [AdminController::class, 'toggleBlockUser'])->name('users.toggle-block');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Crash Game Points CRUD
    Route::get('/crash-points', [AdminController::class, 'getCrashPoints'])->name('crash-points.index');
    Route::post('/crash-points', [AdminController::class, 'createCrashPoint'])->name('crash-points.create');
    Route::put('/crash-points/{id}', [AdminController::class, 'updateCrashPoint'])->name('crash-points.update');
    Route::delete('/crash-points/{id}', [AdminController::class, 'deleteCrashPoint'])->name('crash-points.delete');

    // Force Crash (admin triggers instant game crash)
    Route::post('/force-crash', [AdminController::class, 'forceCrash'])->name('force-crash');

    // Platform settings config
    Route::get('/settings', [AdminController::class, 'getSettings'])->name('settings.get');
    Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');

    // Payment Gateways CRUD
    Route::get('/gateways', [AdminController::class, 'getGateways'])->name('gateways.index');
    Route::post('/gateways', [AdminController::class, 'saveGateway'])->name('gateways.save');
    Route::delete('/gateways/{id}', [AdminController::class, 'deleteGateway'])->name('gateways.delete');

    // Withdrawal Requests management
    Route::get('/withdrawals', [AdminController::class, 'getWithdrawals'])->name('withdrawals.index');
    Route::post('/withdrawals/{id}/{action}', [AdminController::class, 'processWithdrawal'])->name('withdrawals.process');

    // Deposit Requests management
    Route::get('/deposits', [AdminController::class, 'getDeposits'])->name('deposits.index');
    Route::post('/deposits/{id}/process', [AdminController::class, 'processDeposit'])->name('deposits.process');

    // Live Game Status monitor
    Route::get('/game-status', [AdminController::class, 'getGameStatus'])->name('game-status');
});

// Game engine: fetch next crash point (auth required - players only)
Route::get('/game/next-crash-point', [AdminController::class, 'getNextCrashPoint'])->middleware('auth')->name('game.next-crash-point');

// Game client: check if admin force-crashed (auth required)
Route::get('/game/check-force-crash', [AdminController::class, 'checkForceCrash'])->middleware('auth')->name('game.check-force-crash');
Route::get('/game/check-status', [AdminController::class, 'checkStatus'])->middleware('auth')->name('game.check-status');

// Real-time Game Bets sync
Route::post('/game/bet/place', [App\Http\Controllers\DashboardController::class, 'placeBet'])->middleware('auth')->name('game.bet.place');
Route::post('/game/bet/cashout', [App\Http\Controllers\DashboardController::class, 'cashoutBet'])->middleware('auth')->name('game.bet.cashout');

