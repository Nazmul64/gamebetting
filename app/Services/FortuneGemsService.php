<?php

namespace App\Services;

use App\Models\FortuneGemsSetting;
use App\Models\FortuneGemsSpin;
use App\Models\FortuneGemsTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class FortuneGemsService {

    // ফরচুন জেমস ২ এর সিম্বলসমূহ (High & Low Symbols)
    private array $highSymbols = ['GARUDA_WILD', 'RED_RUBY', 'BLUE_SAPPHIRE', 'GREEN_EMERALD'];
    private array $lowSymbols  = ['A', 'K', 'Q', 'J'];
    private array $specialReelPool = ['1X', '2X', '3X', '5X', '10X', '15X', 'WHEEL'];

    // সিম্বল পেআউট টেবিল (৩টি ম্যাচ করলে মাল্টিপ্লায়ার)
    private array $payoutTable = [
        'GARUDA_WILD'   => 50,
        'RED_RUBY'      => 40,
        'BLUE_SAPPHIRE' => 30,
        'GREEN_EMERALD' => 20,
        'A'             => 15,
        'K'             => 10,
        'Q'             => 8,
        'J'             => 5,
    ];

    public function executeSpin(?User $user, float $betAmount, bool $isDemo, int $demoSpinsCount): array {
        $settings = FortuneGemsSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Fortune Gems 2',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
        ]);

        // ১. বাজি লিমিট ভ্যালিডেশন
        if ($betAmount < $settings->min_bet || $betAmount > $settings->max_bet) {
            throw new Exception("বাজির পরিমাণ ৳{$settings->min_bet} থেকে ৳{$settings->max_bet} এর মধ্যে হতে হবে।");
        }

        // ২. ডেমো গার্ড (৩ বার স্পিনের পর ডিপোজিট পপ-আপ)
        if ($isDemo && $demoSpinsCount >= $settings->demo_spin_limit) {
            return [
                'status' => 'deposit_required',
                'message' => 'আপনার ডেমো লিমিট শেষ! আসল টাকা দিয়ে জিততে এখনই ডিপোজিট করুন।'
            ];
        }

        return DB::transaction(function () use ($user, $betAmount, $isDemo, $settings) {
            $balanceBefore = 0.00;
            $balanceAfter = 0.00;
            $lockedUser = null;

            // ৩. রিয়েল মোড ওয়ালেট চেকিং ও রো-লেভেল ডাবল স্পেন্ড লক
            if (!$isDemo) {
                if (!$user) {
                    throw new Exception('অনুগ্রহ করে প্রথমে লগইন করুন!');
                }

                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
                if (!$lockedUser || $lockedUser->balance < $betAmount) {
                    throw new Exception('পর্যাপ্ত ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।');
                }

                $balanceBefore = (float)$lockedUser->balance;
                $lockedUser->decrement('balance', $betAmount);
            }

            // ৪. এডমিন হাউজ প্রফিট ও আরটিপি ক্যালকুলেশন
            $shouldWin = false;
            $rigService = app(\App\Services\GameOutcomeRiggingService::class);

            if (!$isDemo && $lockedUser) {
                $rigService->validatePlayerCanPlay($lockedUser, false);
                $rigAction = $rigService->determineSpinRigAction($lockedUser);
                if ($rigAction === 'win') {
                    $shouldWin = true;
                } elseif ($rigAction === 'lose') {
                    $shouldWin = false;
                } else {
                    if ($settings->control_mode === 'house_profit') {
                        $chance = max(10, min(80, (int)$settings->win_chance_percentage));
                        $shouldWin = (rand(1, 100) <= $chance);
                    } elseif ($settings->control_mode === 'fixed_percentage') {
                        $shouldWin = (rand(1, 100) <= $settings->win_chance_percentage);
                    } else {
                        $shouldWin = (rand(1, 100) <= 38);
                    }
                }
            } else {
                if ($settings->control_mode === 'house_profit') {
                    $chance = max(10, min(80, (int)$settings->win_chance_percentage));
                    $shouldWin = (rand(1, 100) <= $chance);
                } elseif ($settings->control_mode === 'fixed_percentage') {
                    $shouldWin = (rand(1, 100) <= $settings->win_chance_percentage);
                } else {
                    $shouldWin = (rand(1, 100) <= 38);
                }
            }

            // ৫. ৩x৩ গ্রিড ও ৪র্থ স্পেশাল মাল্টিপ্লায়ার রিল জেনারেশন
            $spinResult = $this->generateGridAndPayout($shouldWin, $betAmount);
            $winAmount = (float)$spinResult['win_amount'];
            $adminProfit = $isDemo ? 0.00 : ($betAmount - $winAmount);

            // ৬. স্পিন লগ ও অডিট ট্র্যাকিং সংরক্ষণ
            $spin = FortuneGemsSpin::create([
                'user_id' => $user ? $user->id : null,
                'is_demo' => $isDemo,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'special_reel_symbol' => $spinResult['special_symbol'],
                'multiplier' => $spinResult['multiplier'],
                'triggered_wheel' => $spinResult['triggered_wheel'],
                'is_win' => $winAmount > 0
            ]);

            // ৭. রিয়েল ওয়ালেট ক্রেডিট ও লেজার ট্রানজেকশন
            if (!$isDemo && $lockedUser) {
                FortuneGemsTransaction::create([
                    'user_id' => $lockedUser->id,
                    'spin_id' => $spin->id,
                    'type' => 'debit_bet',
                    'amount' => $betAmount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $lockedUser->fresh()->balance
                ]);

                if ($winAmount > 0) {
                    $beforeCredit = (float)$lockedUser->fresh()->balance;
                    $lockedUser->increment('balance', $winAmount);
                    $balanceAfter = (float)$lockedUser->fresh()->balance;

                    FortuneGemsTransaction::create([
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
                'special_symbol' => $spinResult['special_symbol'],
                'multiplier' => $spinResult['multiplier'],
                'triggered_wheel' => $spinResult['triggered_wheel'],
                'wheel_multiplier' => $spinResult['wheel_multiplier'],
                'is_win' => $winAmount > 0,
                'win_amount' => $winAmount,
                'win_lines' => $spinResult['win_lines'],
                'new_balance' => $isDemo ? null : $balanceAfter,
                'audio' => [
                    'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                    'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                    'wheel' => $settings->wheel_bonus_sound ? asset('storage/' . $settings->wheel_bonus_sound) : null,
                ]
            ];
        });
    }

    private function generateGridAndPayout(bool $shouldWin, float $betAmount): array {
        $grid = [];
        $winAmount = 0.00;
        $multiplier = 1;
        $triggeredWheel = false;
        $wheelMultiplier = 0;
        $specialSymbol = '1X';
        $winLines = [];

        $allSymbols = array_merge($this->highSymbols, $this->lowSymbols);

        if ($shouldWin) {
            // উইন স্পিন: একটি নির্দিষ্ট পে-লাইন ম্যাচ হবে (সাধারণত মাঝের রো বা ডায়াগোনাল)
            $luckySym = $this->highSymbols[array_rand($this->highSymbols)];

            // ৩টি রো পূরণ
            $grid[0] = [$allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)]];
            // মাঝের রো (রো ১) জয়ী লাইন
            $grid[1] = [$luckySym, $luckySym, $luckySym];
            $grid[2] = [$allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)], $allSymbols[array_rand($allSymbols)]];

            // কাকতালীয়ভাবে উপরে/নিচে অন্য সিম্বল সেম হয়ে গেলে যাতে কনফিউশন না হয়
            if ($grid[0][0] === $grid[0][1] && $grid[0][1] === $grid[0][2]) {
                $grid[0][2] = ($grid[0][2] === 'A') ? 'K' : 'A';
            }
            if ($grid[2][0] === $grid[2][1] && $grid[2][1] === $grid[2][2]) {
                $grid[2][2] = ($grid[2][2] === 'Q') ? 'J' : 'Q';
            }

            $winLines[] = ['row' => 1, 'symbol' => $luckySym];

            // ১০% থেকে ১২% চান্স লাকি হুইল পড়ার
            $triggeredWheel = (rand(1, 100) <= 12);

            if ($triggeredWheel) {
                $specialSymbol = 'WHEEL';
                $wheelMultipliers = [20, 30, 50, 80, 100, 150, 200];
                $wheelMultiplier = $wheelMultipliers[array_rand($wheelMultipliers)];
                $multiplier = $wheelMultiplier;
                $winAmount = $betAmount * $wheelMultiplier;
            } else {
                $multipliersList = [1, 2, 3, 5, 10, 15];
                $multiplier = $multipliersList[array_rand($multipliersList)];
                $specialSymbol = $multiplier . 'X';
                $basePay = $this->payoutTable[$luckySym] ?? 10;
                $winAmount = ($betAmount * ($basePay / 10)) * $multiplier;
            }
        } else {
            // লস স্পিন (মিক্সড ৩x৩ যাতে ৩টি পরপর না মিলে)
            for ($r = 0; $r < 3; $r++) {
                $rowSyms = [];
                for ($c = 0; $c < 3; $c++) {
                    $rowSyms[] = $allSymbols[array_rand($allSymbols)];
                }
                // চেক যদি ৩টাই সেম হয়ে যায়, তবে ৩য় টা পরিবর্তন করে দেয়া
                if ($rowSyms[0] === $rowSyms[1] && $rowSyms[1] === $rowSyms[2]) {
                    $rowSyms[2] = ($rowSyms[2] === 'GARUDA_WILD') ? 'J' : 'GARUDA_WILD';
                }
                $grid[$r] = $rowSyms;
            }
            $specialSymbol = ['1X', '2X', '3X'][array_rand(['1X', '2X', '3X'])];
            $multiplier = 1;
        }

        return [
            'grid' => $grid,
            'special_symbol' => $specialSymbol,
            'multiplier' => $multiplier,
            'triggered_wheel' => $triggeredWheel,
            'wheel_multiplier' => $wheelMultiplier,
            'win_amount' => round($winAmount, 2),
            'win_lines' => $winLines
        ];
    }
}
