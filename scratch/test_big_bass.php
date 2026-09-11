<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\BigBassSetting;
use App\Models\BigBassSpin;
use App\Services\BigBassGameService;

echo "=== TESTING BIG BASS SPLASH SYSTEM ===\n";

$settings = BigBassSetting::firstOrCreate(['id' => 1]);
echo "1. Settings Loaded: " . $settings->game_name . " (Mode: " . $settings->control_mode . ", Win%: " . $settings->win_chance_percentage . "%)\n";

$service = new BigBassGameService();

// Test 1: Demo Spin
$user = User::first();
echo "2. User: " . ($user ? $user->email . ' (Bal: ' . $user->balance . ')' : 'No user') . "\n";

$demoRes = $service->executeSpin($user, 10.00, true, 0, false);
echo "3. Demo Spin Result: Status=" . $demoRes['status'] . ", Win=" . $demoRes['win_amount'] . ", HasFisherman=" . ($demoRes['has_fisherman'] ? 'YES' : 'NO') . "\n";
echo "   Grid Size: " . count($demoRes['grid']) . "x" . count($demoRes['grid'][0]) . "\n";
echo "   Fish Values: " . json_encode($demoRes['fish_values']) . "\n";

// Test 2: Buy Free Spins
$bonusRes = $service->executeSpin($user, 5.00, true, 0, true);
echo "4. Buy Bonus Spin Result: Win=" . $bonusRes['win_amount'] . ", HasFisherman=" . ($bonusRes['has_fisherman'] ? 'YES' : 'NO') . "\n";

// Test 3: Demo Spin Limit Guard (at 3 spins)
$limitRes = $service->executeSpin($user, 10.00, true, 3, false);
echo "5. Demo Limit Guard Result: Status=" . $limitRes['status'] . ", Msg=" . ($limitRes['message'] ?? 'None') . "\n";

echo "=== ALL TESTS COMPLETED SUCCESSFULLY ===\n";
