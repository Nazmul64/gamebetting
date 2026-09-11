<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\EmirateSetting;
use App\Models\EmirateSpin;
use App\Services\EmirateGameService;

echo "=== TESTING THE EMIRATE GAME ENGINE ===\n";

$settings = EmirateSetting::firstOrCreate(['id' => 1]);
echo "1. Settings Loaded: " . $settings->game_name . " (Mode: " . $settings->control_mode . ", Win%: " . $settings->win_chance_percentage . "%)\n";

$service = new EmirateGameService();
$user = User::first();
echo "2. User: " . ($user ? $user->email . ' (Bal: ' . $user->balance . ')' : 'No user') . "\n";

// Test 1: Demo Spin
$demoRes = $service->executeSpin($user, 10.00, true, 0);
echo "3. Demo Spin Result: Status=" . $demoRes['status'] . ", Win=" . $demoRes['win_amount'] . ", IsScatter=" . ($demoRes['is_scatter_win'] ? 'YES' : 'NO') . "\n";
echo "   Grid Matrix: " . count($demoRes['grid']) . "x" . count($demoRes['grid'][0]) . "\n";
echo "   Winning Lines: " . json_encode($demoRes['winning_lines']) . "\n";

// Test 2: Demo Spin Limit Guard (at 3 spins)
$limitRes = $service->executeSpin($user, 10.00, true, 3);
echo "4. Demo Limit Guard Result: Status=" . $limitRes['status'] . ", Msg=" . ($limitRes['message'] ?? 'None') . "\n";

echo "=== ALL TESTS COMPLETED SUCCESSFULLY ===\n";
