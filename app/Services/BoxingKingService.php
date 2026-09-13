<?php

namespace App\Services;

use App\Models\BoxingKingSetting;
use App\Models\BoxingKingSpin;
use App\Models\BoxingKingTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class BoxingKingService {

    // ইমেজ কীওয়ার্ডস (High Tier & Low Tier)
    private array $highTier = ['1', '2', '3', '4']; // Boxer Red, Boxer Blue, Gold Belt, Gloves
    private array $lowTier  = ['5', '6', '7', '8', '9', '10', '11', '12']; // Shorts, A, K, Q, J, Scatter, Wild

    public function executeSpin(?User $user, float $betAmount, bool $isDemo, int $demoSpinsCount): array {
        $settings = BoxingKingSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Boxing King',
            'min_bet' => 3.00,
            'max_bet' => 10000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'win_chance_percentage' => 30,
            'control_mode' => 'house_profit',
        ]);

        // ১. ডেমো লিমিট গার্ড (২ বা ৩ বারের পর ডিপোজিট লক)
        if ($isDemo && $demoSpinsCount >= $settings->demo_spin_limit) {
            return [
                'status' => 'deposit_required',
                'message' => 'আপনার ডেমো খেলার লিমিট শেষ! আসল টাকা জিতে ওয়ালেটে নিতে এখনই ডিপোজিট করুন।'
            ];
        }

        return DB::transaction(function () use ($user, $betAmount, $isDemo, $settings) {
            $balanceBefore = 0.00;
            $balanceAfter = 0.00;
            $lockedUser = null;

            // ২. রিয়েল ইউজার ওয়ালেট লক ও ডেবিট
            $rigService = app(\App\Services\GameOutcomeRiggingService::class);
            if (!$isDemo) {
                if (!$user) throw new Exception('লগইন করুন!');

                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
                if (!$lockedUser || $lockedUser->balance < $betAmount) {
                    throw new Exception('পর্যাপ্ত ব্যালেন্স নেই! ডিপোজিট করুন।');
                }

                $rigService->validatePlayerCanPlay($lockedUser, false);
                $balanceBefore = $lockedUser->balance;
                $lockedUser->decrement('balance', $betAmount);
            }

            // ৩. এডমিন কন্ট্রোল উইন/লস ডিসিশন
            $isWinningSpin = false;
            if (!$isDemo && $lockedUser) {
                $rigAction = $rigService->determineSpinRigAction($lockedUser);
                if ($rigAction === 'win') {
                    $isWinningSpin = true;
                } elseif ($rigAction === 'lose') {
                    $isWinningSpin = false;
                } else {
                    if ($settings->control_mode === 'house_profit' || $settings->control_mode === 'fixed_percentage') {
                        $isWinningSpin = (rand(1, 100) <= $settings->win_chance_percentage);
                    } else {
                        $isWinningSpin = (rand(1, 100) <= 40);
                    }
                }
            } else {
                if ($settings->control_mode === 'house_profit' || $settings->control_mode === 'fixed_percentage') {
                    $isWinningSpin = (rand(1, 100) <= $settings->win_chance_percentage);
                } else {
                    $isWinningSpin = (rand(1, 100) <= 40);
                }
            }

            // ৪. ৫x৩ গ্রিড ও আগুনের উইনিং সেলস জেনারেট
            $spinResult = $this->generateGrid($isWinningSpin, $betAmount);
            $winAmount = $spinResult['win_amount'];
            $adminProfit = $isDemo ? 0.00 : ($betAmount - $winAmount);

            // ৫. স্পিন হিস্টোরি সংরক্ষণ
            $spin = BoxingKingSpin::create([
                'user_id' => $lockedUser ? $lockedUser->id : ($user ? $user->id : null),
                'is_demo' => $isDemo,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_result' => $spinResult['grid'],
                'winning_cells' => $spinResult['winning_cells'],
                'is_win' => $winAmount > 0
            ]);

            // রিয়েল ইউজার জিতলে ওয়ালেটে ক্রেডিট ও লেজার এন্ট্রি
            if (!$isDemo && $lockedUser) {
                // বেট কাটার লেজার
                BoxingKingTransaction::create([
                    'user_id' => $lockedUser->id,
                    'spin_id' => $spin->id,
                    'type' => 'debit_bet',
                    'amount' => $betAmount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $lockedUser->fresh()->balance
                ]);

                if ($winAmount > 0) {
                    $beforeWin = $lockedUser->fresh()->balance;
                    $lockedUser->increment('balance', $winAmount);
                    $balanceAfter = $lockedUser->fresh()->balance;

                    // উইনিং পেআউট লেজার
                    BoxingKingTransaction::create([
                        'user_id' => $lockedUser->id,
                        'spin_id' => $spin->id,
                        'type' => 'credit_win',
                        'amount' => $winAmount,
                        'balance_before' => $beforeWin,
                        'balance_after' => $balanceAfter
                    ]);
                } else {
                    $balanceAfter = $lockedUser->fresh()->balance;
                }
            }

            return [
                'status' => 'success',
                'grid' => $spinResult['grid'],
                'is_win' => $winAmount > 0,
                'win_amount' => $winAmount,
                'multiplier' => $spinResult['multiplier'],
                'winning_cells' => $spinResult['winning_cells'], // আগুন জ্বলার ইনডেক্স
                'new_balance' => $isDemo ? null : $balanceAfter,
                'audio' => [
                    'bg' => $settings->bg_music ? (str_starts_with($settings->bg_music, 'assets/') ? asset($settings->bg_music) : asset('storage/' . $settings->bg_music)) : asset('assets/audio/western/western_bg.wav'),
                    'spin' => $settings->spin_sound ? (str_starts_with($settings->spin_sound, 'assets/') ? asset($settings->spin_sound) : asset('storage/' . $settings->spin_sound)) : asset('assets/audio/western/western_spin.wav'),
                    'win' => $settings->win_sound ? (str_starts_with($settings->win_sound, 'assets/') ? asset($settings->win_sound) : asset('storage/' . $settings->win_sound)) : asset('assets/audio/western/western_win.wav'),
                    'fire' => $settings->fire_burn_sound ? (str_starts_with($settings->fire_burn_sound, 'assets/') ? asset($settings->fire_burn_sound) : asset('storage/' . $settings->fire_burn_sound)) : asset('assets/audio/western/western_win.wav'),
                ]
            ];
        });
    }

    private function generateGrid(bool $isWin, float $betAmount): array {
        $grid = [];
        $winningCells = [];
        $winAmount = 0.00;
        $multiplier = 0.0;

        if ($isWin) {
            $symbol = $this->highTier[array_rand($this->highTier)];
            $targetRow = rand(0, 2); // যেকোনো একটা রো-তে ৩টা, ৪টা বা ৫টা ম্যাচ করবে
            $matchCount = rand(3, 5);
            
            for ($r = 0; $r < 3; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    if ($r === $targetRow && $c < $matchCount) {
                        $grid[$r][$c] = $symbol;
                        $winningCells[] = [$r, $c]; // আগুন এই সেলগুলোতে জ্বলবে
                    } else {
                        $grid[$r][$c] = $this->lowTier[array_rand($this->lowTier)];
                    }
                }
            }
            $mults = [3 => 2.5, 4 => 5.0, 5 => 12.0];
            $multiplier = $mults[$matchCount] ?? 3.0;
            $winAmount = $betAmount * $multiplier;
        } else {
            // প্লেয়ার হারবে (মিক্সড গ্রিড)
            $all = array_merge($this->highTier, $this->lowTier);
            for ($r = 0; $r < 3; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    $grid[$r][$c] = $all[array_rand($all)];
                }
            }
            // নিশ্চিত করা যে প্রথম ৩ কলামে ৩টি একই সিম্বল না থাকে
            for ($r = 0; $r < 3; $r++) {
                if ($grid[$r][0] === $grid[$r][1] && $grid[$r][1] === $grid[$r][2]) {
                    $grid[$r][2] = ($grid[$r][2] === '7') ? '8' : '7';
                }
            }
        }

        return [
            'grid' => $grid,
            'win_amount' => $winAmount,
            'multiplier' => $multiplier,
            'winning_cells' => $winningCells
        ];
    }
}
