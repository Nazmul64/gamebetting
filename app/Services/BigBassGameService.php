<?php

namespace App\Services;

use App\Models\BigBassSetting;
use App\Models\BigBassSpin;
use App\Models\BigBassTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class BigBassGameService {

    // Big Bass Splash Symbols
    private array $highSymbols = ['TRUCK', 'FISHING_ROD', 'DRAGONFLY', 'TACKLE_BOX'];
    private array $lowCards    = ['A', 'K', 'Q', 'J', '10'];
    private array $fishMultipliers = [2, 5, 10, 15, 20, 25, 50];

    // 10 Fixed Paylines Definitions [row, col]
    private array $paylines = [
        [[1,0], [1,1], [1,2], [1,3], [1,4]], // 1. Middle horizontal
        [[0,0], [0,1], [0,2], [0,3], [0,4]], // 2. Top horizontal
        [[2,0], [2,1], [2,2], [2,3], [2,4]], // 3. Bottom horizontal
        [[0,0], [1,1], [2,2], [1,3], [0,4]], // 4. V-shape
        [[2,0], [1,1], [0,2], [1,3], [2,4]], // 5. Inverted V-shape
        [[0,0], [0,1], [1,2], [2,3], [2,4]], // 6. Descending step
        [[2,0], [2,1], [1,2], [0,3], [0,4]], // 7. Ascending step
        [[1,0], [2,1], [2,2], [2,3], [1,4]], // 8. Shallow bottom U
        [[1,0], [0,1], [0,2], [0,3], [1,4]], // 9. Shallow top arch
        [[0,0], [1,1], [1,2], [1,3], [0,4]], // 10. Top dip
    ];

    public function executeSpin(?User $user, float $baseBet, bool $isDemo, int $demoSpinsCount, bool $isBuyBonus = false): array {
        $settings = BigBassSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Big Bass Splash',
            'min_bet' => 2.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 32,
        ]);

        // ১. বাজি সীমা ভ্যালিডেশন
        if ($baseBet < $settings->min_bet || $baseBet > $settings->max_bet) {
            throw new Exception("বাজির পরিমাণ ৳{$settings->min_bet} থেকে ৳{$settings->max_bet} এর মধ্যে হতে হবে।");
        }

        // ২. ৩-৪ স্পিনের পর ডেমো লক
        if ($isDemo && $demoSpinsCount >= $settings->demo_spin_limit) {
            return [
                'status' => 'deposit_required',
                'message' => 'আপনার ডেমো লিমিট শেষ! আসল টাকা দিয়ে খেলতে এখনই ডিপোজিট করুন।'
            ];
        }

        // ৩. বোনাস কিনলে ১০০ গুণ চার্জ হবে
        $chargeAmount = $isBuyBonus ? round($baseBet * 100, 2) : $baseBet;

        return DB::transaction(function () use ($user, $chargeAmount, $baseBet, $isDemo, $isBuyBonus, $settings) {
            $balanceBefore = 0.00;
            $balanceAfter = 0.00;
            $lockedUser = null;

            // ৪. রিয়েল মোড ওয়ালেট লক ও ডিডাকশন
            $rigService = app(\App\Services\GameOutcomeRiggingService::class);
            if (!$isDemo) {
                if (!$user) {
                    throw new Exception('অনুগ্রহ করে প্রথমে লগইন করুন!');
                }

                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
                if (!$lockedUser || $lockedUser->balance < $chargeAmount) {
                    throw new Exception('পর্যাপ্ত ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।');
                }

                $rigService->validatePlayerCanPlay($lockedUser, false);
                $balanceBefore = (float)$lockedUser->balance;
                $lockedUser->decrement('balance', $chargeAmount);
            }

            // ৫. এডমিন হাউজ প্রফিট ও আরটিপি সিদ্ধান্ত
            $shouldWin = false;
            if (!$isDemo && $lockedUser) {
                $rigAction = $rigService->determineSpinRigAction($lockedUser);
                if ($rigAction === 'win') {
                    $shouldWin = true;
                } elseif ($rigAction === 'lose') {
                    $shouldWin = false;
                } else {
                    if ($isBuyBonus) {
                        $shouldWin = true;
                    } elseif ($settings->control_mode === 'house_profit') {
                        $chance = max(10, min(80, (int)$settings->win_chance_percentage));
                        $shouldWin = (rand(1, 100) <= $chance);
                    } elseif ($settings->control_mode === 'fixed_percentage') {
                        $shouldWin = (rand(1, 100) <= $settings->win_chance_percentage);
                    } else {
                        $shouldWin = (rand(1, 100) <= 35);
                    }
                }
            } else {
                if ($isBuyBonus) {
                    $shouldWin = true;
                } elseif ($settings->control_mode === 'house_profit') {
                    $chance = max(10, min(80, (int)$settings->win_chance_percentage));
                    $shouldWin = (rand(1, 100) <= $chance);
                } elseif ($settings->control_mode === 'fixed_percentage') {
                    $shouldWin = (rand(1, 100) <= $settings->win_chance_percentage);
                } else {
                    $shouldWin = (rand(1, 100) <= 35);
                }
            }

            // ৬. ৫x৩ গ্রিড, ফিশ মানি এবং ফিশারম্যান হুক কালেক্ট জেনারেশন
            $spinResult = $this->generateGridAndFishCash($shouldWin, $baseBet, $isBuyBonus);
            $winAmount = (float)$spinResult['win_amount'];
            $adminProfit = $isDemo ? 0.00 : ($chargeAmount - $winAmount);

            // ৭. স্পিন হিস্ট্রি ও অডিট লগ তৈরি
            $spin = BigBassSpin::create([
                'user_id' => $user ? $user->id : null,
                'is_demo' => $isDemo,
                'is_buy_bonus' => $isBuyBonus,
                'bet_amount' => $chargeAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'fish_money_values' => $spinResult['fish_values'],
                'has_fisherman' => $spinResult['has_fisherman'],
                'is_win' => $winAmount > 0
            ]);

            // ৮. ওয়ালেট ক্রেডিট ও লেজার ট্রানজেকশন
            if (!$isDemo && $lockedUser) {
                BigBassTransaction::create([
                    'user_id' => $lockedUser->id,
                    'spin_id' => $spin->id,
                    'type' => 'debit_bet',
                    'amount' => $chargeAmount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $lockedUser->fresh()->balance
                ]);

                if ($winAmount > 0) {
                    $beforeCredit = (float)$lockedUser->fresh()->balance;
                    $lockedUser->increment('balance', $winAmount);
                    $balanceAfter = (float)$lockedUser->fresh()->balance;

                    BigBassTransaction::create([
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
                'fish_values' => $spinResult['fish_values'],
                'has_fisherman' => $spinResult['has_fisherman'],
                'winning_paylines' => $spinResult['winning_paylines'],
                'is_win' => $winAmount > 0,
                'win_amount' => $winAmount,
                'new_balance' => $isDemo ? null : $balanceAfter,
                'audio' => [
                    'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                    'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                    'splash' => $settings->reel_splash_sound ? asset('storage/' . $settings->reel_splash_sound) : null,
                    'hook' => $settings->fisherman_hook_sound ? asset('storage/' . $settings->fisherman_hook_sound) : null,
                ]
            ];
        });
    }

    private function generateGridAndFishCash(bool $shouldWin, float $baseBet, bool $isBonus): array {
        $grid = array_fill(0, 3, array_fill(0, 5, ''));
        $fishValues = [];
        $winAmount = 0.00;
        $hasFisherman = false;
        $winningPaylines = [];

        $pool = array_merge($this->highSymbols, $this->lowCards);

        if ($shouldWin) {
            // উইন স্পিন: জেলে (Fisherman) পড়বে এবং মাছের ক্যাশ বড়শি দিয়ে তুলে নেবে
            $hasFisherman = true;
            $fishermanRow = rand(0, 2);
            $fishermanCol = rand(0, 4);

            $totalCollectedFromFish = 0.00;

            for ($r = 0; $r < 3; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    if ($r === $fishermanRow && $c === $fishermanCol) {
                        $grid[$r][$c] = 'FISHERMAN_WILD';
                    } elseif (rand(1, 100) <= 45) { // মাছের সিম্বল ড্রপ
                        $grid[$r][$c] = 'FISH_MONEY';
                        $mult = $this->fishMultipliers[array_rand($this->fishMultipliers)];
                        if ($isBonus) {
                            $mult = [10, 20, 25, 50][array_rand([10, 20, 25, 50])];
                        }
                        $cash = round($baseBet * $mult, 2);
                        $fishValues["{$r}_{$c}"] = $cash;
                        $totalCollectedFromFish += $cash;
                    } else {
                        $grid[$r][$c] = $pool[array_rand($pool)];
                    }
                }
            }

            // যদি বাই বোনাস হয় অথবা কোনো মাছ না পড়ে, ন্যূনতম ৩-৫টি মাছ ড্রপ নিশ্চিত করা
            if ($totalCollectedFromFish <= 0) {
                for ($i = 0; $i < 3; $i++) {
                    $fr = rand(0, 2);
                    $fc = rand(0, 4);
                    if ($grid[$fr][$fc] !== 'FISHERMAN_WILD') {
                        $grid[$fr][$fc] = 'FISH_MONEY';
                        $mult = [2, 5, 10, 20][array_rand([2, 5, 10, 20])];
                        $cash = round($baseBet * $mult, 2);
                        $fishValues["{$fr}_{$fc}"] = $cash;
                        $totalCollectedFromFish += $cash;
                    }
                }
            }

            $winAmount = $totalCollectedFromFish > 0 ? $totalCollectedFromFish : round($baseBet * rand(2, 5), 2);
        } else {
            // লস স্পিন (জেলে থাকবে না অথবা মাছ থাকলেও বড়শি পড়বে না)
            for ($r = 0; $r < 3; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    if (rand(1, 100) <= 25) {
                        $grid[$r][$c] = 'FISH_MONEY';
                        $fishValues["{$r}_{$c}"] = round($baseBet * 2, 2);
                    } else {
                        $grid[$r][$c] = $pool[array_rand($pool)];
                    }
                }
            }
        }

        return [
            'grid' => $grid,
            'fish_values' => $fishValues,
            'has_fisherman' => $hasFisherman,
            'winning_paylines' => $winningPaylines,
            'win_amount' => $winAmount
        ];
    }
}
