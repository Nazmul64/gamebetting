<?php

namespace App\Services;

use App\Models\RoyalEmiratesSetting;
use App\Models\RoyalEmiratesSpin;
use App\Models\RoyalEmiratesTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class RoyalEmiratesService {

    private array $highSymbols = ['SHEIKH', 'BURJ_AL_ARAB', 'RED_SUPERCAR', 'GOLD_DAGGER'];
    private array $lowSymbols  = ['GOLD_TEAPOT', 'A', 'K', 'Q', 'J'];

    public function executeSpin(?User $user, float $betAmount, bool $isDemo, int $demoSpinsCount): array {
        $settings = RoyalEmiratesSetting::firstOrCreate(['id' => 1]);

        $globalLimit = (int)\App\Models\Setting::getVal('demo_spins_limit', (int)($settings->demo_spin_limit ?? 3));

        // ডেমো স্পিন লিমিট চেক (এডমিন কনফিগারেশন অনুযায়ী)
        if ($isDemo && $demoSpinsCount >= $globalLimit) {
            return [
                'status' => 'deposit_required',
                'message' => 'আপনার ডেমো লিমিট শেষ! আসল টাকা দিয়ে খেলতে এখনই ডিপোজিট করুন।'
            ];
        }

        return DB::transaction(function () use ($user, $betAmount, $isDemo, $settings) {
            $balanceBefore = 0.00;
            $balanceAfter = 0.00;
            $lockedUser = null;

            // রিয়েল মোড ব্যালেন্স লক ও ডিডাকশন
            if (!$isDemo) {
                $rigService = app(\App\Services\GameOutcomeRiggingService::class);
                if (!$user) throw new Exception('অনুগ্রহ করে প্রথমে লগইন করুন!');

                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
                if (!$lockedUser || $lockedUser->balance < $betAmount) {
                    throw new Exception('পর্যাপ্ত ব্যালেন্স নেই! ডিপোজিট করুন।');
                }

                $rigService->validatePlayerCanPlay($lockedUser, false);
                $balanceBefore = (float)$lockedUser->balance;
                $lockedUser->decrement('balance', $betAmount);
            }

            // এডমিন প্রফিট ডিসিশন
            $shouldWin = false;
            if (!$isDemo && $lockedUser) {
                $rigAction = $rigService->determineSpinRigAction($lockedUser);
                if ($rigAction === 'win') {
                    $shouldWin = true;
                } elseif ($rigAction === 'lose') {
                    $shouldWin = false;
                } else {
                    if ($settings->control_mode === 'house_profit' || $settings->control_mode === 'fixed_percentage') {
                        $shouldWin = (rand(1, 100) <= (int)$settings->win_chance_percentage);
                    } else {
                        $shouldWin = (rand(1, 100) <= 35);
                    }
                }
            } else {
                if ($settings->control_mode === 'house_profit' || $settings->control_mode === 'fixed_percentage') {
                    $shouldWin = (rand(1, 100) <= (int)$settings->win_chance_percentage);
                } else {
                    $shouldWin = (rand(1, 100) <= 35);
                }
            }

            // ৫x৩ গ্রিড ও হোল্ড অ্যান্ড স্পিন বোনাস ক্যালকুলেশন
            $spinResult = $this->generateGridAndBonus($shouldWin, $betAmount, $settings);
            $winAmount = (float)$spinResult['win_amount'];
            $adminProfit = $isDemo ? 0.00 : ($betAmount - $winAmount);

            // স্পিন লগ সংরক্ষণ
            $spin = RoyalEmiratesSpin::create([
                'user_id' => $user ? $user->id : null,
                'is_demo' => $isDemo,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'coin_values' => $spinResult['coin_values'],
                'jackpot_won' => $spinResult['jackpot_won'],
                'triggered_hold_spin' => $spinResult['triggered_hold_spin'],
                'is_win' => $winAmount > 0
            ]);

            // ওয়ালেট ক্রেডিট ও লেজার
            if (!$isDemo && $lockedUser) {
                RoyalEmiratesTransaction::create([
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

                    RoyalEmiratesTransaction::create([
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

                // Central Casino Analytics Tracking
                try {
                    $tracker = app(\App\Services\CasinoCentralTrackingService::class);
                    $tracker->recordRealTransaction('royal_emirates', $betAmount, $winAmount);
                    $tracker->heartbeat('royal_emirates', $lockedUser->id, false);
                } catch (\Exception $e) {
                    // Ignore tracking errors
                }
            }

            return [
                'status' => 'success',
                'grid' => $spinResult['grid'],
                'coin_values' => $spinResult['coin_values'],
                'jackpot_won' => $spinResult['jackpot_won'],
                'triggered_hold_spin' => $spinResult['triggered_hold_spin'],
                'win_lines' => $spinResult['win_lines'] ?? [],
                'is_win' => $winAmount > 0,
                'win_amount' => $winAmount,
                'new_balance' => $isDemo ? null : $balanceAfter,
                'audio' => [
                    'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                    'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                    'coin' => $settings->coin_drop_sound ? asset('storage/' . $settings->coin_drop_sound) : null,
                    'bonus' => $settings->hold_spin_trigger_sound ? asset('storage/' . $settings->hold_spin_trigger_sound) : null,
                ]
            ];
        });
    }

    private function generateGridAndBonus(bool $shouldWin, float $betAmount, RoyalEmiratesSetting $settings): array {
        $grid = [];
        $coinValues = [];
        $jackpotWon = null;
        $triggeredHoldSpin = false;
        $winAmount = 0.00;
        $winLines = [];

        $pool = array_merge($this->highSymbols, $this->lowSymbols);

        if ($shouldWin) {
            // ১০% ক্ষেত্রে Hold and Spin বোনাস ট্রিগার (৬ বা ততোধিক গোল্ডেন কয়েন)
            if (rand(1, 100) <= 12) {
                $triggeredHoldSpin = true;
                $coinCount = rand(6, 10);
                $totalBonus = 0.00;

                // গ্রিড তৈরি
                for ($r = 0; $r < 3; $r++) {
                    for ($c = 0; $c < 5; $c++) {
                        $grid[$r][$c] = $pool[array_rand($pool)];
                    }
                }

                // ৬+ ঘরে গোল্ডেন কয়েন ও ক্যাশ ভ্যালু ড্রপ
                $placed = 0;
                $coords = [];
                for ($r = 0; $r < 3; $r++) {
                    for ($c = 0; $c < 5; $c++) {
                        $coords[] = [$r, $c];
                    }
                }
                shuffle($coords);

                foreach (array_slice($coords, 0, $coinCount) as [$r, $c]) {
                    $grid[$r][$c] = 'GOLD_COIN';
                    $multipliers = [2, 3, 5, 8, 10, 15, 25];
                    $multiplier = $multipliers[array_rand($multipliers)];
                    $val = round($betAmount * $multiplier, 2);
                    $coinValues["{$r}_{$c}"] = $val;
                    $totalBonus += $val;
                }

                // জ্যাকপট দেওয়ার সম্ভাবনা
                $jackpotRoll = rand(1, 100);
                if ($coinCount === 15) {
                    $jackpotWon = 'GRAND';
                    $totalBonus += ($betAmount * (float)$settings->grand_multiplier);
                } elseif ($jackpotRoll <= 3) {
                    $jackpotWon = 'MEGA';
                    $totalBonus += ($betAmount * (float)$settings->mega_multiplier);
                } elseif ($jackpotRoll <= 8) {
                    $jackpotWon = 'MINOR';
                    $totalBonus += ($betAmount * (float)$settings->minor_multiplier);
                } elseif ($jackpotRoll <= 18) {
                    $jackpotWon = 'MINI';
                    $totalBonus += ($betAmount * (float)$settings->mini_multiplier);
                }

                $winAmount = $totalBonus;
            } else {
                // সাধারণ পে-লাইন উইন
                $luckySym = $this->highSymbols[array_rand($this->highSymbols)];
                $targetRow = rand(0, 2);
                
                for ($r = 0; $r < 3; $r++) {
                    for ($c = 0; $c < 5; $c++) {
                        $grid[$r][$c] = $pool[array_rand($pool)];
                    }
                }

                $matchCount = rand(3, 5);
                for ($c = 0; $c < $matchCount; $c++) {
                    $grid[$targetRow][$c] = $luckySym;
                }

                // Random 1-2 coins without triggering hold & spin
                if (rand(1, 100) <= 40) {
                    $cr = ($targetRow + 1) % 3;
                    $cc = rand(0, 4);
                    $grid[$cr][$cc] = 'GOLD_COIN';
                    $coinValues["{$cr}_{$cc}"] = round($betAmount * rand(1, 3), 2);
                }

                $baseMultipliers = [
                    'SHEIKH' => [3 => 4, 4 => 10, 5 => 25],
                    'BURJ_AL_ARAB' => [3 => 3, 4 => 8, 5 => 20],
                    'RED_SUPERCAR' => [3 => 2.5, 4 => 6, 5 => 15],
                    'GOLD_DAGGER' => [3 => 2, 4 => 5, 5 => 12],
                ];

                $multiplier = $baseMultipliers[$luckySym][$matchCount] ?? 3;
                $winAmount = round($betAmount * $multiplier, 2);
                $winLines[] = [
                    'row' => $targetRow,
                    'symbol' => $luckySym,
                    'count' => $matchCount,
                    'payout' => $winAmount
                ];
            }
        } else {
            // লস স্পিন (সর্বোচ্চ ১-৪টি কয়েন ড্রপ করতে পারে, বোনাস মিলবে না)
            for ($r = 0; $r < 3; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    $grid[$r][$c] = $pool[array_rand($pool)];
                }
            }

            // Random 0-3 non-triggering coins
            $dropCoins = rand(0, 3);
            if ($dropCoins > 0) {
                $coords = [];
                for ($r = 0; $r < 3; $r++) {
                    for ($c = 0; $c < 5; $c++) {
                        $coords[] = [$r, $c];
                    }
                }
                shuffle($coords);
                foreach (array_slice($coords, 0, $dropCoins) as [$r, $c]) {
                    $grid[$r][$c] = 'GOLD_COIN';
                    $coinValues["{$r}_{$c}"] = round($betAmount * rand(1, 3), 2);
                }
            }
        }

        return [
            'grid' => $grid,
            'coin_values' => $coinValues,
            'jackpot_won' => $jackpotWon,
            'triggered_hold_spin' => $triggeredHoldSpin,
            'win_lines' => $winLines,
            'win_amount' => $winAmount
        ];
    }
}
