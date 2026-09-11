<?php

namespace App\Services;

use App\Models\BonbonSetting;
use App\Models\BonbonSpin;
use App\Models\BonbonTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class BonbonGameService {

    // বনবন বোনানজার সিম্বলসমূহ (Sweet Bonanza Pay-Anywhere)
    private array $highCandies = ['HEART_RED', 'SQUARE_PURPLE', 'PENTAGON_GREEN', 'OVAL_BLUE'];
    private array $lowFruits   = ['APPLE', 'PLUM', 'WATERMELON', 'GRAPES', 'BANANA'];
    private string $scatterSym  = 'LOLLIPOP_SCATTER';

    // পে-এনিহোয়ার পে-আউট টেবিল (৮-৯, ১০-১১, ১২+ ক্যান্ডি)
    private array $payTable = [
        'HEART_RED'       => [8 => 10.0, 10 => 25.0, 12 => 50.0],
        'SQUARE_PURPLE'   => [8 => 2.5,  10 => 10.0, 12 => 25.0],
        'PENTAGON_GREEN'  => [8 => 2.0,  10 => 5.0,  12 => 15.0],
        'OVAL_BLUE'       => [8 => 1.5,  10 => 2.0,  12 => 12.0],
        'APPLE'           => [8 => 1.0,  10 => 1.5,  12 => 10.0],
        'PLUM'            => [8 => 0.8,  10 => 1.2,  12 => 8.0],
        'WATERMELON'      => [8 => 0.5,  10 => 1.0,  12 => 5.0],
        'GRAPES'          => [8 => 0.4,  10 => 0.9,  12 => 4.0],
        'BANANA'          => [8 => 0.25, 10 => 0.75, 12 => 2.0],
    ];

    public function executeSpin(?User $user, float $baseBet, bool $isDemo, int $demoSpinsCount, bool $scatterBoost = false): array {
        $settings = BonbonSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'BonBon Bonanza',
            'min_bet' => 1.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
        ]);

        // ১. বাজি সীমা ভ্যালিডেশন
        if ($baseBet < $settings->min_bet || $baseBet > $settings->max_bet) {
            throw new Exception("বাজির পরিমাণ ৳{$settings->min_bet} থেকে ৳{$settings->max_bet} এর মধ্যে হতে হবে।");
        }

        // ২. ডেমো লিমিট গার্ড (৩ বার খেলার পর ডিপোজিট লক)
        if ($isDemo && $demoSpinsCount >= $settings->demo_spin_limit) {
            return [
                'status' => 'deposit_required',
                'message' => 'আপনার ডেমো লিমিট শেষ! আসল টাকা দিয়ে খেলতে এখনই ডিপোজিট করুন।'
            ];
        }

        // ৩. স্ক্যাটার বুস্ট চালু থাকলে অতিরিক্ত ২৫% বাজি প্রযোজ্য
        $totalCharged = $scatterBoost ? round($baseBet * 1.25, 2) : $baseBet;

        return DB::transaction(function () use ($user, $totalCharged, $baseBet, $isDemo, $scatterBoost, $settings) {
            $balanceBefore = 0.00;
            $balanceAfter = 0.00;
            $lockedUser = null;

            // ৪. রিয়েল মোড ওয়ালেট লক ও ডাবল-স্পেন্ড প্রটেকশন
            if (!$isDemo) {
                if (!$user) {
                    throw new Exception('অনুগ্রহ করে প্রথমে লগইন করুন!');
                }

                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
                if (!$lockedUser || $lockedUser->balance < $totalCharged) {
                    throw new Exception('পর্যাপ্ত ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।');
                }

                $balanceBefore = (float)$lockedUser->balance;
                $lockedUser->decrement('balance', $totalCharged);
            }

            // ৫. এডমিন হাউজ প্রফিট ও আরটিপি ক্যালকুলেশন
            $shouldWin = false;
            if ($settings->control_mode === 'house_profit') {
                $chance = max(10, min(80, (int)$settings->win_chance_percentage));
                $shouldWin = (rand(1, 100) <= $chance);
            } elseif ($settings->control_mode === 'fixed_percentage') {
                $shouldWin = (rand(1, 100) <= $settings->win_chance_percentage);
            } else {
                $shouldWin = (rand(1, 100) <= 38);
            }

            // ৬. ৬ কলাম x ৫ রো গ্রিড জেনারেশন ও পে-এনিহোয়ার ক্লাস্টার ক্যালকুলেশন
            $spinResult = $this->generateGridAndPayout($shouldWin, $baseBet, $scatterBoost);
            $winAmount = (float)$spinResult['win_amount'];
            $adminProfit = $isDemo ? 0.00 : ($totalCharged - $winAmount);

            // ৭. স্পিন হিস্ট্রি ও অডিট লগ তৈরি
            $spin = BonbonSpin::create([
                'user_id' => $user ? $user->id : null,
                'is_demo' => $isDemo,
                'scatter_boost_enabled' => $scatterBoost,
                'bet_amount' => $totalCharged,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'matched_symbols' => $spinResult['matched_symbols'],
                'tumble_count' => $spinResult['tumble_count'],
                'is_win' => $winAmount > 0
            ]);

            // ৮. ওয়ালেট ক্রেডিট ও লেজার ট্রানজেকশন
            if (!$isDemo && $lockedUser) {
                BonbonTransaction::create([
                    'user_id' => $lockedUser->id,
                    'spin_id' => $spin->id,
                    'type' => 'debit_bet',
                    'amount' => $totalCharged,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $lockedUser->fresh()->balance
                ]);

                if ($winAmount > 0) {
                    $beforeCredit = (float)$lockedUser->fresh()->balance;
                    $lockedUser->increment('balance', $winAmount);
                    $balanceAfter = (float)$lockedUser->fresh()->balance;

                    BonbonTransaction::create([
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
                'matched_symbols' => $spinResult['matched_symbols'],
                'tumble_count' => $spinResult['tumble_count'],
                'tumble_steps' => $spinResult['tumble_steps'],
                'new_balance' => $isDemo ? null : $balanceAfter,
                'audio' => [
                    'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                    'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                    'tumble' => $settings->tumble_blast_sound ? asset('storage/' . $settings->tumble_blast_sound) : null,
                ]
            ];
        });
    }

    private function generateGridAndPayout(bool $shouldWin, float $baseBet, bool $scatterBoost): array {
        $grid = [];
        $matchedSymbols = [];
        $winAmount = 0.00;
        $tumbleCount = 0;
        $tumbleSteps = [];

        $allPool = array_merge($this->highCandies, $this->lowFruits);

        if ($shouldWin) {
            // উইন স্পিন: যেকোনো একটি বা দুটি ক্যান্ডি ৮ থেকে ১৪টি ক্লাস্টারে ড্রপ করবে
            $luckyCandy = $this->highCandies[array_rand($this->highCandies)];
            $matchCount = rand(8, 12);
            
            $tier = 8;
            if ($matchCount >= 12) $tier = 12;
            elseif ($matchCount >= 10) $tier = 10;
            
            $mult = $this->payTable[$luckyCandy][$tier] ?? 5.0;
            $winAmount = round($baseBet * $mult, 2);
            $tumbleCount = rand(1, 3);

            $matchedSymbols[] = [
                'symbol' => $luckyCandy,
                'count' => $matchCount,
                'payout' => $winAmount
            ];

            // ৩০টি ঘরের মধ্যে ম্যাচিং ক্যান্ডি বসানো
            $flatGrid = array_fill(0, $matchCount, $luckyCandy);
            
            // স্ক্যাটার বুস্ট অন থাকলে ১-৩টি ললিপপ পড়তে পারে
            $scatterCount = $scatterBoost ? rand(1, 3) : (rand(1, 100) <= 25 ? 1 : 0);
            for ($s = 0; $s < $scatterCount; $s++) {
                if (count($flatGrid) < 30) $flatGrid[] = $this->scatterSym;
            }

            while (count($flatGrid) < 30) {
                $sym = $allPool[array_rand($allPool)];
                // অন্যান্য সিম্বল যেন ৮টি না মিলে যায়
                $currentCount = count(array_filter($flatGrid, fn($x) => $x === $sym));
                if ($currentCount < 6) {
                    $flatGrid[] = $sym;
                }
            }
            shuffle($flatGrid);

            // ৫ রো x ৬ কলাম গ্রিড তৈরি
            $grid = array_chunk($flatGrid, 6);

            // টাম্বলিং ক্যাসকেড রিপ্লেসমেন্ট স্টেপস
            for ($t = 0; $t < $tumbleCount; $t++) {
                $replacement = [];
                for ($i = 0; $i < $matchCount; $i++) {
                    $replacement[] = $allPool[array_rand($allPool)];
                }
                $tumbleSteps[] = [
                    'step' => $t + 1,
                    'cleared_symbol' => $luckyCandy,
                    'new_symbols' => $replacement
                ];
            }
        } else {
            // লস স্পিন: কোনো সিম্বলই ৮টি মিলবে না (সর্বোচ্চ ৪-৬টি থাকবে)
            $flatGrid = [];
            $counts = array_fill_keys($allPool, 0);

            while (count($flatGrid) < 30) {
                $candidate = $allPool[array_rand($allPool)];
                if ($counts[$candidate] < 6) {
                    $flatGrid[] = $candidate;
                    $counts[$candidate]++;
                }
            }
            shuffle($flatGrid);
            $grid = array_chunk($flatGrid, 6);
        }

        return [
            'grid' => $grid,
            'win_amount' => $winAmount,
            'matched_symbols' => $matchedSymbols,
            'tumble_count' => $tumbleCount,
            'tumble_steps' => $tumbleSteps
        ];
    }
}
