<?php

namespace App\Services;

use App\Models\WesternVaultSetting;
use App\Models\WesternVaultRound;
use App\Models\WesternVaultBet;
use App\Models\WesternVaultTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class WesternVaultService {
    
    // বর্তমান একটিভ রাউন্ড পাওয়া বা নতুন রাউন্ড শুরু করা
    public function getCurrentOrCreateRound(): WesternVaultRound {
        $settings = WesternVaultSetting::firstOrCreate([], [
            'game_name' => 'Western Vault',
            'round_duration' => 25
        ]);

        $round = WesternVaultRound::where('status', 'betting')
            ->where('ends_at', '>', Carbon::now())
            ->first();

        if (!$round) {
            $round = WesternVaultRound::create([
                'round_id' => 'WV-' . strtoupper(uniqid()),
                'status' => 'betting',
                'ends_at' => Carbon::now()->addSeconds($settings->round_duration)
            ]);

            $this->injectBotsIfRequired($round, $settings);
        }

        return $round;
    }

    // ১০ জনের কম রিয়েল প্লেয়ার থাকলে বট প্রবেশ করানো
    public function injectBotsIfRequired(WesternVaultRound $round, WesternVaultSetting $settings): void {
        if (!$settings->bot_status) return;

        $realPlayersCount = WesternVaultBet::where('round_id', $round->id)
            ->where('is_bot', false)
            ->where('is_demo', false)
            ->distinct('user_id')
            ->count('user_id');

        if ($realPlayersCount < $settings->bot_trigger_player_count) {
            $botNames = ['Hunter99', 'WildSheriff', 'JackOutlaw', 'GoldRush', 'ShadowBettor', 'BanditX', 'JesseJames', 'BillyKid', 'CalamityJane', 'WyattEarp'];
            $botCount = rand(4, 7);

            for ($i = 0; $i < $botCount; $i++) {
                $side = rand(0, 1) ? 'side_a' : 'side_b';
                $fakeAmount = rand((int)$settings->bot_min_bet, (int)$settings->bot_max_bet);

                WesternVaultBet::create([
                    'round_id' => $round->id,
                    'is_bot' => true,
                    'is_demo' => false,
                    'bot_name' => $botNames[array_rand($botNames)],
                    'selected_side' => $side,
                    'bet_amount' => $fakeAmount,
                    'status' => 'pending'
                ]);

                if ($side === 'side_a') {
                    $round->increment('bot_bets_total_a', $fakeAmount);
                } else {
                    $round->increment('bot_bets_total_b', $fakeAmount);
                }
            }
        }
    }

    // ইউজারের বেট গ্রহণ ও ডাটাবেজ লক মেকানিজম
    public function executeBet(?User $user, array $data): array {
        return DB::transaction(function () use ($user, $data) {
            $round = $this->getCurrentOrCreateRound();

            if ($round->status !== 'betting') {
                throw new Exception('বেটিংয়ের সময় শেষ হয়ে গেছে!');
            }

            $isDemo = (bool)($data['is_demo'] ?? false);
            $amount = (float)$data['amount'];
            $side = $data['side'];

            if (!$isDemo) {
                if (!$user) {
                    throw new Exception('দয়া করে প্রথমে লগইন করুন!');
                }

                // Race-Condition প্রতিরোধে ব্যালেন্স লক
                $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();

                if ($lockedUser->balance < $amount) {
                    throw new Exception('আপনার ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই!');
                }

                $openingBalance = $lockedUser->balance;
                $lockedUser->decrement('balance', $amount);
                $closingBalance = $lockedUser->fresh()->balance;

                $bet = WesternVaultBet::create([
                    'round_id' => $round->id,
                    'user_id' => $lockedUser->id,
                    'is_demo' => false,
                    'selected_side' => $side,
                    'bet_amount' => $amount,
                    'status' => 'pending'
                ]);

                WesternVaultTransaction::create([
                    'user_id' => $lockedUser->id,
                    'bet_id' => $bet->id,
                    'type' => 'bet_placed',
                    'amount' => $amount,
                    'opening_balance' => $openingBalance,
                    'closing_balance' => $closingBalance,
                    'description' => "Placed bet in round {$round->round_id} on {$side}"
                ]);

                if ($side === 'side_a') {
                    $round->increment('real_bets_total_a', $amount);
                } else {
                    $round->increment('real_bets_total_b', $amount);
                }

                return ['bet' => $bet, 'new_balance' => $closingBalance];
            } else {
                // ডেমো মোড
                $bet = WesternVaultBet::create([
                    'round_id' => $round->id,
                    'user_id' => $user ? $user->id : null,
                    'is_demo' => true,
                    'selected_side' => $side,
                    'bet_amount' => $amount,
                    'status' => 'pending'
                ]);

                return ['bet' => $bet, 'new_balance' => null];
            }
        });
    }

    // রাউন্ড ক্যালকুলেশন ও পে-আউট বণ্টন
    public function settleRound(WesternVaultRound $round): WesternVaultRound {
        return DB::transaction(function () use ($round) {
            $settings = WesternVaultSetting::firstOrCreate([], [
                'game_name' => 'Western Vault',
                'round_duration' => 25
            ]);
            $round->update(['status' => 'processing']);

            $realA = (float)$round->real_bets_total_a;
            $realB = (float)$round->real_bets_total_b;

            $winningSide = 'side_a';

            // House Profit অ্যালগরিদম (কম টাকার সাইড জিতবে)
            if ($settings->control_mode === 'house_profit') {
                if ($realA < $realB) {
                    $winningSide = 'side_a';
                } elseif ($realB < $realA) {
                    $winningSide = 'side_b';
                } else {
                    $winningSide = (rand(1, 100) <= $settings->win_chance_percentage) ? 'side_a' : 'side_b';
                }
            } elseif ($settings->control_mode === 'fixed_percentage') {
                $winningSide = (rand(1, 100) <= $settings->win_chance_percentage) ? 'side_a' : 'side_b';
            } else {
                $winningSide = rand(0, 1) ? 'side_a' : 'side_b';
            }

            $matrix = $this->buildGrid($winningSide);
            $winningBets = WesternVaultBet::where('round_id', $round->id)
                ->where('selected_side', $winningSide)
                ->get();

            $totalPaid = 0.00;

            foreach ($winningBets as $bet) {
                $payout = $bet->bet_amount * $bet->payout_multiplier;
                $bet->update([
                    'win_amount' => $payout,
                    'status' => 'won'
                ]);

                // শুধু রিয়েল প্লেয়ারের ওয়ালেটে পেআউট যোগ
                if (!$bet->is_bot && !$bet->is_demo && $bet->user_id) {
                    $player = User::where('id', $bet->user_id)->lockForUpdate()->first();
                    if ($player) {
                        $opening = $player->balance;
                        $player->increment('balance', $payout);
                        $closing = $player->fresh()->balance;

                        WesternVaultTransaction::create([
                            'user_id' => $player->id,
                            'bet_id' => $bet->id,
                            'type' => 'win_payout',
                            'amount' => $payout,
                            'opening_balance' => $opening,
                            'closing_balance' => $closing,
                            'description' => "Payout won in round {$round->round_id}"
                        ]);

                        $totalPaid += $payout;
                    }
                }
            }

            // পরাজিতদের স্ট্যাটাস আপডেট
            WesternVaultBet::where('round_id', $round->id)
                ->where('selected_side', '!=', $winningSide)
                ->update(['status' => 'lost']);

            $totalRealBets = $realA + $realB;
            $netProfit = $totalRealBets - $totalPaid;

            $round->update([
                'winning_side' => $winningSide,
                'grid_matrix' => $matrix,
                'total_payout' => $totalPaid,
                'admin_profit' => $netProfit,
                'status' => 'completed'
            ]);

            return $round;
        });
    }

    private function buildGrid(string $winner): array {
        $poolA = ['VAULT', 'COIN', 'A', 'K', 'Q'];
        $poolB = ['OUTLAW', 'GUN', 'J', '10', 'SKULL'];
        $symbols = ($winner === 'side_a') ? $poolA : $poolB;

        $matrix = [];
        for ($r = 0; $r < 3; $r++) {
            for ($c = 0; $c < 5; $c++) {
                $matrix[$r][$c] = $symbols[array_rand($symbols)];
            }
        }
        return $matrix;
    }
}
