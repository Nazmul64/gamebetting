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
Route::get('/play/{game?}', function ($game = null) {
    $gameParam = strtolower($game ?? request()->query('game', 'helicopterx'));
    $validGames = ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'];
    if (!in_array($gameParam, $validGames)) {
        $gameParam = 'helicopterx';
    }
    return view('customer.game', ['game' => $gameParam]);
})->middleware('auth')->name('play');

Route::get('/games/{game?}', function ($game = null) {
    return redirect()->route('play', ['game' => $game]);
})->where('game', '^(helicopterx|1xaero|aero|crashx|crash)$')->middleware('auth')->name('play.game');

// WinGo Color & Number Prediction Lottery Routes
Route::get('/wingo', [App\Http\Controllers\WinGoController::class, 'index'])->name('wingo.index');
Route::prefix('games/wingo')->group(function () {
    Route::get('/', [App\Http\Controllers\WinGoController::class, 'index'])->name('wingo.games.index');
    Route::get('/state', [App\Http\Controllers\WinGoController::class, 'getState'])->name('wingo.state');
    Route::post('/bet', [App\Http\Controllers\WinGoController::class, 'placeBet'])->name('wingo.bet');
    Route::get('/my-history', [App\Http\Controllers\WinGoController::class, 'getMyHistory'])->name('wingo.myhistory');
});

// K3 Lottery Dice Game Routes
Route::get('/k3', [App\Http\Controllers\K3Controller::class, 'index'])->name('k3.index');
Route::prefix('games/k3')->group(function () {
    Route::get('/', [App\Http\Controllers\K3Controller::class, 'index'])->name('k3.games.index');
    Route::get('/state', [App\Http\Controllers\K3Controller::class, 'getState'])->name('k3.state');
    Route::post('/bet', [App\Http\Controllers\K3Controller::class, 'placeBet'])->name('k3.bet');
    Route::get('/my-history', [App\Http\Controllers\K3Controller::class, 'myHistory'])->name('k3.myhistory');
});

// TrxWinGo TRX Block Hash Based Lottery Routes
Route::get('/trx-wingo', [App\Http\Controllers\TrxWingoController::class, 'index'])->name('trxwingo.index');
Route::get('/trxwingo', [App\Http\Controllers\TrxWingoController::class, 'index'])->name('trxwingo.direct');
Route::prefix('games/trx-wingo')->group(function () {
    Route::get('/', [App\Http\Controllers\TrxWingoController::class, 'index'])->name('trxwingo.games.index');
    Route::get('/state', [App\Http\Controllers\TrxWingoController::class, 'getState'])->name('trxwingo.state');
    Route::post('/bet', [App\Http\Controllers\TrxWingoController::class, 'placeBet'])->name('trxwingo.bet');
    Route::get('/my-history', [App\Http\Controllers\TrxWingoController::class, 'getMyHistory'])->name('trxwingo.myhistory');
});

// Direct aliases for 5 crash games
Route::get('/helicopterx', function() { return redirect()->route('play', ['game' => 'helicopterx']); })->name('game.helicopterx');
Route::get('/1xaero', function() { return redirect()->route('play', ['game' => '1xaero']); })->name('game.1xaero');
Route::get('/aero', function() { return redirect()->route('play', ['game' => 'aero']); })->name('game.aero');
Route::get('/crashx', function() { return redirect()->route('play', ['game' => 'crashx']); })->name('game.crashx');
Route::get('/crash', function() { return redirect()->route('play', ['game' => 'crash']); })->name('game.crash');
Route::get('/gems-mines', function () {
    return view('customer.gems-mines');
})->middleware('auth')->name('gems-mines');

// Big Bass Splash Casino Slot Game Routes
Route::get('/big-bass-splash', [App\Http\Controllers\BigBass\BigBassGameController::class, 'index'])->name('big-bass-splash');
Route::prefix('games/big-bass-splash')->group(function () {
    Route::get('/', [App\Http\Controllers\BigBass\BigBassGameController::class, 'index'])->name('bigbass.index');
    Route::post('/spin', [App\Http\Controllers\BigBass\BigBassGameController::class, 'spin'])->name('bigbass.spin');
});

// BonBon Bonanza Casino Slot Game Routes
Route::get('/bonbon-bonanza', [App\Http\Controllers\BonBon\BonbonGameController::class, 'index'])->name('bonbon-bonanza');
Route::prefix('games/bonbon-bonanza')->group(function () {
    Route::get('/', [App\Http\Controllers\BonBon\BonbonGameController::class, 'index'])->name('bonbon.index');
    Route::post('/spin', [App\Http\Controllers\BonBon\BonbonGameController::class, 'spin'])->name('bonbon.spin');
});

// Lucky Joker 100 Casino Slot Game Routes
Route::get('/lucky-joker-100', [App\Http\Controllers\LuckyJoker\LuckyJokerGameController::class, 'index'])->name('lucky-joker-100');
Route::prefix('games/lucky-joker-100')->group(function () {
    Route::get('/', [App\Http\Controllers\LuckyJoker\LuckyJokerGameController::class, 'index'])->name('joker.index');
    Route::get('/state', [App\Http\Controllers\LuckyJoker\LuckyJokerGameController::class, 'getState'])->name('joker.state');
    Route::post('/spin', [App\Http\Controllers\LuckyJoker\LuckyJokerGameController::class, 'spin'])->name('joker.spin');
});

// Fortune Gems 2 Casino Slot Game Routes
Route::get('/fortune-gems-2', [App\Http\Controllers\FortuneGems\FortuneGemsGameController::class, 'index'])->name('fortune-gems-2');
Route::prefix('games/fortune-gems-2')->group(function () {
    Route::get('/', [App\Http\Controllers\FortuneGems\FortuneGemsGameController::class, 'index'])->name('fortunegems.index');
    Route::post('/spin', [App\Http\Controllers\FortuneGems\FortuneGemsGameController::class, 'spin'])->name('fortunegems.spin');
});

Route::get('/the-emirate', function () {
    return view('customer.the-emirate');
})->middleware('auth')->name('the-emirate');

// Royal Emirates Hold and Spin Game Routes
Route::get('/royal-emirates', [App\Http\Controllers\RoyalEmirates\RoyalEmiratesGameController::class, 'index'])->middleware('auth')->name('royal-emirates');
Route::prefix('games/royal-emirates')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\RoyalEmirates\RoyalEmiratesGameController::class, 'index'])->name('royalemirates.index');
    Route::post('/spin', [App\Http\Controllers\RoyalEmirates\RoyalEmiratesGameController::class, 'spin'])->name('royalemirates.spin');
});

Route::get('/elves-kingdom', function () {
    return view('customer.elves-kingdom');
})->middleware('auth')->name('elves-kingdom');

Route::get('/treasure-climb', function () {
    return view('customer.treasure-climb');
})->middleware('auth')->name('treasure-climb');

Route::get('/western', [App\Http\Controllers\WesternVault\WesternVaultGameController::class, 'index'])->name('western');
Route::get('/western-vault', [App\Http\Controllers\WesternVault\WesternVaultGameController::class, 'index'])->name('western-vault');
Route::prefix('games/western-vault')->group(function () {
    Route::get('/', [App\Http\Controllers\WesternVault\WesternVaultGameController::class, 'index'])->name('western.index');
    Route::get('/state', [App\Http\Controllers\WesternVault\WesternVaultGameController::class, 'getGameState'])->name('western.state');
    Route::post('/bet', [App\Http\Controllers\WesternVault\WesternVaultGameController::class, 'placeBet'])->name('western.bet');
});

Route::get('/temple-of-fortune', [App\Http\Controllers\AbyssOfGlory\AbyssGameController::class, 'index'])->name('temple-of-fortune');
Route::get('/abyss-of-glory', [App\Http\Controllers\AbyssOfGlory\AbyssGameController::class, 'index'])->name('abyss.direct');
Route::prefix('games/temple-of-fortune')->group(function () {
    Route::get('/', [App\Http\Controllers\AbyssOfGlory\AbyssGameController::class, 'index'])->name('abyss.index');
    Route::get('/state', [App\Http\Controllers\AbyssOfGlory\AbyssGameController::class, 'getGameState'])->name('abyss.state');
    Route::post('/bet', [App\Http\Controllers\AbyssOfGlory\AbyssGameController::class, 'placeBet'])->name('abyss.bet');
});

Route::get('/super-ace-deluxe', function () {
    return view('customer.super-ace-deluxe');
})->middleware('auth')->name('super-ace-deluxe');

Route::get('/gates-of-olympus', [App\Http\Controllers\OlympusGameController::class, 'index'])->name('gates-of-olympus');
Route::get('/api/olympus/config', [App\Http\Controllers\OlympusGameController::class, 'getConfig'])->name('olympus.config');
Route::post('/api/olympus/spin', [App\Http\Controllers\OlympusGameController::class, 'spin'])->name('olympus.spin');
Route::get('/api/olympus/history', [App\Http\Controllers\OlympusGameController::class, 'history'])->name('olympus.history');

Route::get('/boxing-king', [App\Http\Controllers\BoxingKing\BoxingKingGameController::class, 'index'])->name('boxing-king');
Route::prefix('games/boxing-king')->group(function () {
    Route::get('/', [App\Http\Controllers\BoxingKing\BoxingKingGameController::class, 'index'])->name('boxing.index');
    Route::post('/spin', [App\Http\Controllers\BoxingKing\BoxingKingGameController::class, 'spin'])->name('boxing.spin');
});

Route::get('/fortune-gems-2', function () {
    return view('customer.fortune-gems-2');
})->middleware('auth')->name('fortune-gems-2');

Route::get('/big-bass-splash', [App\Http\Controllers\BigBass\BigBassGameController::class, 'index'])->name('big-bass-splash');
Route::prefix('games/big-bass-splash')->group(function () {
    Route::get('/', [App\Http\Controllers\BigBass\BigBassGameController::class, 'index'])->name('bigbass.index');
    Route::post('/spin', [App\Http\Controllers\BigBass\BigBassGameController::class, 'spin'])->name('bigbass.spin');
});

// The Emirate Game Routes
Route::get('/the-emirate', [App\Http\Controllers\TheEmirate\EmirateGameController::class, 'index'])->name('the-emirate');
Route::prefix('games/the-emirate')->group(function () {
    Route::get('/', [App\Http\Controllers\TheEmirate\EmirateGameController::class, 'index'])->name('emirate.index');
    Route::post('/spin', [App\Http\Controllers\TheEmirate\EmirateGameController::class, 'spin'])->name('emirate.spin');
});

// Heads or Tails (Mermaid / Octopus Gold Coin) Game Routes
Route::get('/heads-or-tails', [App\Http\Controllers\HeadsOrTails\HeadsTailsGameController::class, 'index'])->name('heads-or-tails');
Route::prefix('games/heads-or-tails')->group(function () {
    Route::get('/', [App\Http\Controllers\HeadsOrTails\HeadsTailsGameController::class, 'index'])->name('headstails.index');
    Route::get('/state', [App\Http\Controllers\HeadsOrTails\HeadsTailsGameController::class, 'getGameState'])->name('headstails.state');
    Route::post('/bet', [App\Http\Controllers\HeadsOrTails\HeadsTailsGameController::class, 'placeBet'])->name('headstails.bet');
    Route::post('/toss', [App\Http\Controllers\HeadsOrTails\HeadsTailsGameController::class, 'instantToss'])->name('headstails.toss');
});
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
    Route::get('/game-matrix', [AdminController::class, 'getGamePerformanceMatrixApi'])->name('game-matrix');
    Route::get('/analytics/games-health', [App\Http\Controllers\Admin\CasinoAnalyticsController::class, 'index'])->name('casino.analytics');
    Route::get('/analytics/games-health/json', [App\Http\Controllers\Admin\CasinoAnalyticsController::class, 'getLiveJson'])->name('casino.analytics.json');
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
    Route::post('/game/force-crash', [AdminController::class, 'forceCrash'])->name('game.force-crash');

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

    // Olympus Slot Game Management
    Route::get('/olympus/settings', [AdminController::class, 'getOlympusSettings'])->name('olympus.settings.get');
    Route::post('/olympus/settings', [AdminController::class, 'saveOlympusSettings'])->name('olympus.settings.save');
    Route::get('/olympus/rounds', [AdminController::class, 'getOlympusRounds'])->name('olympus.rounds');
    Route::get('/olympus/audit-logs', [AdminController::class, 'getOlympusAuditLogs'])->name('olympus.audit-logs');

    // Western Vault Casino Game Management Module
    Route::get('/modules/western-vault', [App\Http\Controllers\WesternVault\WesternVaultAdminController::class, 'index'])->name('western.index');
    Route::post('/modules/western-vault/settings', [App\Http\Controllers\WesternVault\WesternVaultAdminController::class, 'updateSettings'])->name('western.settings');
    Route::post('/modules/western-vault/audio', [App\Http\Controllers\WesternVault\WesternVaultAdminController::class, 'uploadAudio'])->name('western.audio');
    Route::get('/modules/western-vault/transactions', [App\Http\Controllers\WesternVault\WesternVaultAdminController::class, 'ledgerIndex'])->name('western.ledger');

    // Boxing King Casino Game Management Module
    Route::get('/modules/boxing-king', [App\Http\Controllers\BoxingKing\BoxingKingAdminController::class, 'index'])->name('boxing.index');
    Route::post('/modules/boxing-king/settings', [App\Http\Controllers\BoxingKing\BoxingKingAdminController::class, 'updateSettings'])->name('boxing.settings');
    Route::post('/modules/boxing-king/upload-audio', [App\Http\Controllers\BoxingKing\BoxingKingAdminController::class, 'uploadAudio'])->name('boxing.audio');
    Route::get('/modules/boxing-king/spins', [App\Http\Controllers\BoxingKing\BoxingKingAdminController::class, 'recentSpins'])->name('boxing.spins');

    // Abyss of Glory (Temple of Fortune) Casino Game Management Module
    Route::get('/modules/abyss-of-glory', [App\Http\Controllers\AbyssOfGlory\AbyssAdminController::class, 'index'])->name('abyss.index');
    Route::post('/modules/abyss-of-glory/settings', [App\Http\Controllers\AbyssOfGlory\AbyssAdminController::class, 'updateSettings'])->name('abyss.settings');
    Route::post('/modules/abyss-of-glory/upload-audio', [App\Http\Controllers\AbyssOfGlory\AbyssAdminController::class, 'uploadAudio'])->name('abyss.audio');

    // Heads or Tails Casino Game Management Module
    Route::get('/modules/heads-or-tails', [App\Http\Controllers\HeadsOrTails\HeadsTailsAdminController::class, 'index'])->name('headstails.index');
    Route::post('/modules/heads-or-tails/settings', [App\Http\Controllers\HeadsOrTails\HeadsTailsAdminController::class, 'updateSettings'])->name('headstails.settings');
    Route::post('/modules/heads-or-tails/upload-audio', [App\Http\Controllers\HeadsOrTails\HeadsTailsAdminController::class, 'uploadAudio'])->name('headstails.audio');

    // Lucky Joker 100 Casino Game Management Module
    Route::get('/modules/lucky-joker', [App\Http\Controllers\LuckyJoker\LuckyJokerAdminController::class, 'index'])->name('joker.index');
    Route::post('/modules/lucky-joker/settings', [App\Http\Controllers\LuckyJoker\LuckyJokerAdminController::class, 'updateSettings'])->name('joker.settings');
    Route::post('/modules/lucky-joker/upload-audio', [App\Http\Controllers\LuckyJoker\LuckyJokerAdminController::class, 'uploadAudio'])->name('joker.audio');

    // Fortune Gems 2 Casino Game Management Module
    Route::get('/modules/fortune-gems-2', [App\Http\Controllers\FortuneGems\FortuneGemsAdminController::class, 'index'])->name('gems.index');
    Route::post('/modules/fortune-gems-2/settings', [App\Http\Controllers\FortuneGems\FortuneGemsAdminController::class, 'updateSettings'])->name('gems.settings');
    Route::post('/modules/fortune-gems-2/upload-audio', [App\Http\Controllers\FortuneGems\FortuneGemsAdminController::class, 'uploadAudio'])->name('gems.audio');

    // BonBon Bonanza Casino Game Management Module
    Route::get('/modules/bonbon-bonanza', [App\Http\Controllers\BonBon\BonbonAdminController::class, 'index'])->name('bonbon.index');
    Route::post('/modules/bonbon-bonanza/settings', [App\Http\Controllers\BonBon\BonbonAdminController::class, 'updateSettings'])->name('bonbon.settings');
    Route::post('/modules/bonbon-bonanza/upload-audio', [App\Http\Controllers\BonBon\BonbonAdminController::class, 'uploadAudio'])->name('bonbon.audio');

    // Big Bass Splash Casino Game Management Module
    Route::get('/modules/big-bass-splash', [App\Http\Controllers\BigBass\BigBassAdminController::class, 'index'])->name('bigbass.index');
    Route::post('/modules/big-bass-splash/settings', [App\Http\Controllers\BigBass\BigBassAdminController::class, 'updateSettings'])->name('bigbass.settings');
    Route::post('/modules/big-bass-splash/upload-audio', [App\Http\Controllers\BigBass\BigBassAdminController::class, 'uploadAudio'])->name('bigbass.audio');

    // The Emirate Casino Game Management Module
    Route::get('/modules/the-emirate', [App\Http\Controllers\TheEmirate\EmirateAdminController::class, 'index'])->name('emirate.index');
    Route::post('/modules/the-emirate/settings', [App\Http\Controllers\TheEmirate\EmirateAdminController::class, 'updateSettings'])->name('emirate.settings');
    Route::post('/modules/the-emirate/upload-audio', [App\Http\Controllers\TheEmirate\EmirateAdminController::class, 'uploadAudio'])->name('emirate.audio');

    // Royal Emirates Hold and Spin Casino Game Management Module
    Route::get('/modules/royal-emirates', [App\Http\Controllers\RoyalEmirates\RoyalEmiratesAdminController::class, 'index'])->name('royalemirates.index');
    Route::post('/modules/royal-emirates/settings', [App\Http\Controllers\RoyalEmirates\RoyalEmiratesAdminController::class, 'updateSettings'])->name('royalemirates.settings');
    Route::post('/modules/royal-emirates/upload-audio', [App\Http\Controllers\RoyalEmirates\RoyalEmiratesAdminController::class, 'uploadAudio'])->name('royalemirates.audio');

    // WinGo Lottery Game Management Module
    Route::get('/modules/wingo', [App\Http\Controllers\Admin\WingoAdminController::class, 'index'])->name('wingo.index');
    Route::post('/modules/wingo/settings', [App\Http\Controllers\Admin\WingoAdminController::class, 'updateSettings'])->name('wingo.settings');
    Route::post('/modules/wingo/{id}/force-settle', [App\Http\Controllers\Admin\WingoAdminController::class, 'forceSettle'])->name('wingo.settle');

    // K3 Lottery Game Management Module
    Route::get('/modules/k3', [App\Http\Controllers\Admin\K3AdminController::class, 'index'])->name('k3.index');
    Route::post('/modules/k3/settings', [App\Http\Controllers\Admin\K3AdminController::class, 'updateSettings'])->name('k3.settings');
    Route::post('/modules/k3/audio', [App\Http\Controllers\Admin\K3AdminController::class, 'uploadAudio'])->name('k3.audio');
    Route::post('/modules/k3/{id}/force-settle', [App\Http\Controllers\Admin\K3AdminController::class, 'forceSettle'])->name('k3.settle');

    // TrxWinGo Lottery Game Management Module
    Route::get('/modules/trx-wingo', [App\Http\Controllers\Admin\TrxWingoAdminController::class, 'index'])->name('trxwingo.index');
    Route::post('/modules/trx-wingo/settings', [App\Http\Controllers\Admin\TrxWingoAdminController::class, 'updateSettings'])->name('trxwingo.settings');
    Route::post('/modules/trx-wingo/{id}/force-settle', [App\Http\Controllers\Admin\TrxWingoAdminController::class, 'forceSettle'])->name('trxwingo.settle');

    // Site Branding & Global Demo Limit Settings
    Route::get('/settings/branding', [App\Http\Controllers\AdminController::class, 'getBrandingSettings'])->name('settings.branding.get');
    Route::post('/settings/branding', [App\Http\Controllers\AdminController::class, 'updateBrandingSettings'])->name('settings.branding.update');

    // Promotional Slider Banner Management
    Route::get('/sliders', [App\Http\Controllers\Admin\SliderAdminController::class, 'index'])->name('sliders.index');
    Route::post('/sliders/store', [App\Http\Controllers\Admin\SliderAdminController::class, 'store'])->name('sliders.store');
    Route::post('/sliders/{id}/update', [App\Http\Controllers\Admin\SliderAdminController::class, 'update'])->name('sliders.update');
    Route::post('/sliders/{id}/toggle', [App\Http\Controllers\Admin\SliderAdminController::class, 'toggleStatus'])->name('sliders.toggle');
    Route::delete('/sliders/{id}', [App\Http\Controllers\Admin\SliderAdminController::class, 'destroy'])->name('sliders.destroy');
});

// Game engine: fetch next crash point (auth required - players only)
Route::get('/game/next-crash-point', [AdminController::class, 'getNextCrashPoint'])->middleware('auth')->name('game.next-crash-point');

// Game client: check if admin force-crashed (auth required)
Route::get('/game/check-force-crash', [AdminController::class, 'checkForceCrash'])->middleware('auth')->name('game.check-force-crash');
Route::get('/game/check-status', [AdminController::class, 'checkStatus'])->middleware('auth')->name('game.check-status');

// Real-time Game Bets sync
Route::post('/game/bet/place', [App\Http\Controllers\DashboardController::class, 'placeBet'])->middleware('auth')->name('game.bet.place');
Route::post('/game/bet/cashout', [App\Http\Controllers\DashboardController::class, 'cashoutBet'])->middleware('auth')->name('game.bet.cashout');

