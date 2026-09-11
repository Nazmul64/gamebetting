<?php

namespace App\Services;

use App\Models\LuckyJokerSetting;
use App\Models\LuckyJokerSpin;
use App\Models\LuckyJokerTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class LuckyJokerService {

    // লাকি জোকার ১০০ সিম্বলসমূহ
    private array $symbols = [
        'SEVEN', 'HORSESHOE', 'MELON', 'GRAPES', 
        'BELL', 'CHERRY', 'ORANGE', 'PLUM', 'STAR_SCATTER'
    ];

    public function executeSpin(?User $user, float $betAmount, bool $isDemo, int $demoSpinsCount): array {
        $settings = LuckyJokerSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Lucky Joker 100',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
        ]);

        // ডেমো গার্ড (৩-৪ স্পিনের পর ডিপোজিট লক)
        if ($isDemo && $demoSpinsCount >= $settings->demo_spin_limit) {
            return [
                'status' => 'deposit_required',
                'message' => "আপনার {$settings->demo_spin_limit} বার ডেমো লিমিট শেষ! আসল টাকা জিতে ওয়ালেটে নিতে এখনই ডিপোজিট করুন।"
            ];
        }

        return DB::transaction(function () use ($user, $betAmount, $isDemo, $settings) {
            $balanceBefore = 0.00;
            $balanceAfter = 0.00;

            // রিয়েল মোড ওয়ালেট ভ্যালিডেশন
            if (!$isDemo) {
                if (!$user) throw new Exception('দয়া করে প্রথমে লগইন করুন!');

                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
                if (!$lockedUser || $lockedUser->balance < $betAmount) {
                    throw new Exception('ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।');
                }

                $balanceBefore = (float)$lockedUser->balance;
                $lockedUser->decrement('balance', $betAmount);
            }

            // এডমিন উইন ডিসিশন
            $shouldWin = false;
            if ($settings->control_mode === 'house_profit' || $settings->control_mode === 'fixed_percentage') {
                $shouldWin = (rand(1, 100) <= $settings->win_chance_percentage);
            } else {
                $shouldWin = (rand(1, 100) <= 40); // ন্যাচারাল আরটিপি
            }

            // ৫x৪ গ্রিড এবং এক্সপান্ডিং জোকার ওয়াইল্ড লজিক
            $spinResult = $this->generateGridAndCalculate($shouldWin, $betAmount);
            $winAmount = (float)$spinResult['win_amount'];
            $adminProfit = $isDemo ? 0.00 : ($betAmount - $winAmount);

            // ডাটাবেজ অডিট
            $spin = LuckyJokerSpin::create([
                'user_id' => $user ? $user->id : null,
                'is_demo' => $isDemo,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'winning_lines' => $spinResult['winning_lines'],
                'has_expanding_wild' => $spinResult['has_wild']
            ]);

            // রিয়েল ওয়ালেট ক্রেডিট ও লেজার
            if (!$isDemo) {
                LuckyJokerTransaction::create([
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

                    LuckyJokerTransaction::create([
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
                'has_expanding_wild' => $spinResult['has_wild'],
                'wild_columns' => $spinResult['wild_columns'],
                'new_balance' => $isDemo ? null : $balanceAfter,
                'audio' => [
                    'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                    'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                    'wild' => $settings->joker_laugh_sound ? asset('storage/' . $settings->joker_laugh_sound) : null,
                ]
            ];
        });
    }

    private function generateGridAndCalculate(bool $shouldWin, float $betAmount): array {
        $grid = [];
        $winningLines = [];
        $hasWild = false;
        $wildCols = [];
        $winAmount = 0.00;

        if ($shouldWin) {
            $luckySym = $this->symbols[array_rand($this->symbols)];
            // রিল ২ অথবা ৩-এ এক্সপান্ডিং জোকার ফেলা
            $hasWild = (rand(1, 100) <= 60);
            $chosenWildCol = rand(1, 3); // কলাম ২, ৩ বা ৪ (0-ইনডেক্সড: 1, 2, 3)

            for ($r = 0; $r < 4; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    if ($hasWild && $c === $chosenWildCol) {
                        $grid[$r][$c] = 'JOKER_WILD';
                    } elseif ($c < 3) {
                        $grid[$r][$c] = $luckySym;
                    } else {
                        $grid[$r][$c] = $this->symbols[array_rand($this->symbols)];
                    }
                }
            }

            if ($hasWild) $wildCols[] = $chosenWildCol;

            $multiplier = $hasWild ? rand(3, 8) : rand(2, 4);
            $winAmount = $betAmount * $multiplier;
            $winningLines[] = ['symbol' => $luckySym, 'count' => 4, 'line' => rand(1, 100)];
        } else {
            // লস স্পিন (মিক্সড ফ্রুটস)
            for ($r = 0; $r < 4; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    $grid[$r][$c] = $this->symbols[array_rand($this->symbols)];
                }
            }
        }

        return [
            'grid' => $grid,
            'win_amount' => $winAmount,
            'winning_lines' => $winningLines,
            'has_wild' => $hasWild,
            'wild_columns' => $wildCols
        ];
    }
}
