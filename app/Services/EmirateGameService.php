<?php

namespace App\Services;

use App\Models\EmirateSetting;
use App\Models\EmirateSpin;
use App\Models\EmirateTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class EmirateGameService {

    // The Emirate symbols
    private array $highSymbols = ['SHEIKH', 'SHEIKHA', 'CAR_SUV', 'DUBAI_CITY'];
    private array $lowSymbols  = ['HOOKAH', 'TEAPOT'];
    private string $scatterSymbol = 'PALM_SCATTER';

    // 5 Classic Paylines (5x3 grid row indexes per column)
    private array $paylines = [
        1 => [1, 1, 1, 1, 1], // Horizontal Middle
        2 => [0, 0, 0, 0, 0], // Horizontal Top
        3 => [2, 2, 2, 2, 2], // Horizontal Bottom
        4 => [0, 1, 2, 1, 0], // V-shape
        5 => [2, 1, 0, 1, 2], // Inverted V-shape
    ];

    public function executeSpin(?User $user, float $betAmount, bool $isDemo, int $demoSpinsCount): array {
        $settings = EmirateSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'The Emirate',
            'min_bet' => 5.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
        ]);

        // ৩-৪ স্পিনের পর ডেমো লক
        if ($isDemo && $demoSpinsCount >= $settings->demo_spin_limit) {
            return [
                'status' => 'deposit_required',
                'message' => 'আপনার ডেমো লিমিট শেষ! আসল টাকা দিয়ে খেলতে এখনই ডিপোজিট করুন।'
            ];
        }

        return DB::transaction(function () use ($user, $betAmount, $isDemo, $settings) {
            $balanceBefore = 0.00;
            $balanceAfter = 0.00;

            // রিয়েল মোড ওয়ালেট ভ্যালিডেশন
            if (!$isDemo) {
                if (!$user) throw new Exception('অনুগ্রহ করে প্রথমে লগইন করুন!');

                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
                if ($lockedUser->balance < $betAmount) {
                    throw new Exception('পর্যাপ্ত ব্যালেন্স নেই! ডিপোজিট করুন।');
                }

                $balanceBefore = (float)$lockedUser->balance;
                $lockedUser->decrement('balance', $betAmount);
            }

            // এডমিন উইন ডিসিশন
            $shouldWin = false;
            if ($settings->control_mode === 'house_profit' || $settings->control_mode === 'fixed_percentage') {
                $shouldWin = (rand(1, 100) <= $settings->win_chance_percentage);
            } else {
                $shouldWin = (rand(1, 100) <= 35);
            }

            // ৫টি পে-লাইন এবং স্ক্যাটার রেজাল্ট তৈরি
            $spinResult = $this->generateGridAndPayout($shouldWin, $betAmount);
            $winAmount = (float)$spinResult['win_amount'];
            $adminProfit = $isDemo ? 0.00 : ($betAmount - $winAmount);

            // স্পিন লগ সংরক্ষণ
            $spin = EmirateSpin::create([
                'user_id' => $user ? $user->id : null,
                'is_demo' => $isDemo,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'winning_lines' => $spinResult['winning_lines'],
                'is_scatter_win' => $spinResult['is_scatter_win'],
                'is_win' => $winAmount > 0
            ]);

            // ওয়ালেট ক্রেডিট ও লেজার
            if (!$isDemo) {
                EmirateTransaction::create([
                    'user_id' => $lockedUser->id,
                    'spin_id' => $spin->id,
                    'type' => 'debit_bet',
                    'amount' => $betAmount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => (float)$lockedUser->fresh()->balance
                ]);

                if ($winAmount > 0) {
                    $beforeCredit = (float)$lockedUser->fresh()->balance;
                    $lockedUser->increment('balance', $winAmount);
                    $balanceAfter = (float)$lockedUser->fresh()->balance;

                    EmirateTransaction::create([
                        'user_id' => $lockedUser->id,
                        'spin_id' => $spin->id,
                        'type' => 'credit_win',
                        'amount' => $winAmount,
                        'balance_before' => $beforeCredit,
                        'balance_after' => $balanceAfter
                    ]);
                } else {
                    $balanceAfter = (float)$lockedUser->fresh()->balance;
                }
            }

            return [
                'status' => 'success',
                'grid' => $spinResult['grid'],
                'is_win' => $winAmount > 0,
                'win_amount' => $winAmount,
                'winning_lines' => $spinResult['winning_lines'],
                'is_scatter_win' => $spinResult['is_scatter_win'],
                'new_balance' => $isDemo ? null : $balanceAfter,
                'audio' => [
                    'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                    'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                    'scatter' => $settings->scatter_sound ? asset('storage/' . $settings->scatter_sound) : null,
                ]
            ];
        });
    }

    private function generateGridAndPayout(bool $shouldWin, float $betAmount): array {
        $grid = [];
        $winningLines = [];
        $isScatterWin = false;
        $winAmount = 0.00;

        $allSymbols = array_merge($this->highSymbols, $this->lowSymbols);

        if ($shouldWin) {
            // ২০% ক্ষেত্রে স্ক্যাটার উইন (৩টি পাম ট্রি)
            if (rand(1, 100) <= 20) {
                $isScatterWin = true;
                $winAmount = $betAmount * 5; // ৫ গুণ পেআউট
                for ($r = 0; $r < 3; $r++) {
                    for ($c = 0; $c < 5; $c++) {
                        $grid[$r][$c] = $allSymbols[array_rand($allSymbols)];
                    }
                }
                // ৩টি র্যান্ডম ঘরে স্ক্যাটার বসানো
                $grid[0][1] = $this->scatterSymbol;
                $grid[1][3] = $this->scatterSymbol;
                $grid[2][0] = $this->scatterSymbol;
            } else {
                // পে-লাইন উইন (মাঝের রো বা রো ১-এ ৩-৪টি একই সিম্বল)
                $luckySym = $this->highSymbols[array_rand($this->highSymbols)];
                $grid[0] = [$allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)]];
                $grid[1] = [$luckySym, $luckySym, $luckySym, $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)]];
                $grid[2] = [$allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)]];

                $multiplier = ($luckySym === 'SHEIKH') ? rand(5, 12) : rand(2, 5);
                $winAmount = $betAmount * $multiplier;
                $winningLines[] = [
                    'line' => 1,
                    'symbol' => $luckySym,
                    'count' => 3,
                    'cells' => [[1, 0], [1, 1], [1, 2]]
                ];
            }
        } else {
            // লস স্পিন (কোনো লাইনে ম্যাচিং নেই)
            for ($r = 0; $r < 3; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    $grid[$r][$c] = $allSymbols[array_rand($allSymbols)];
                }
            }
            // Ensure no accidental line win in row 1
            if ($grid[1][0] === $grid[1][1] && $grid[1][1] === $grid[1][2]) {
                $grid[1][2] = ($grid[1][2] === 'SHEIKH') ? 'HOOKAH' : 'SHEIKH';
            }
        }

        return [
            'grid' => $grid,
            'win_amount' => $winAmount,
            'winning_lines' => $winningLines,
            'is_scatter_win' => $isScatterWin
        ];
    }
}
