<?php

namespace App\Services;

use App\Models\AbyssSetting;
use App\Models\AbyssRound;
use App\Models\AbyssBet;
use App\Models\AbyssTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class AbyssGameService {

    public function getActiveOrCreateRound(): AbyssRound {
        $settings = AbyssSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Abyss of Glory',
            'min_bet' => 0.40,
            'max_bet' => 10000.00,
            'demo_spin_limit' => 3,
            'demo_initial_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'payout_multiplier' => 1.95,
            'bot_status' => true,
            'bot_trigger_count' => 5,
            'bot_min_bet' => 50.00,
            'bot_max_bet' => 2000.00,
            'round_duration_seconds' => 25
        ]);

        $round = AbyssRound::where('status', 'betting')
            ->where('ends_at', '>', Carbon::now())
            ->first();

        if (!$round) {
            $round = AbyssRound::create([
                'round_id' => 'GLORY-' . strtoupper(uniqid()),
                'status' => 'betting',
                'ends_at' => Carbon::now()->addSeconds($settings->round_duration_seconds)
            ]);

            $this->injectBotsIfRequired($round, $settings);
        }

        return $round;
    }

    // স্মার্ট বট সিস্টেম
    public function injectBotsIfRequired(AbyssRound $round, AbyssSetting $settings): void {
        if (!$settings->bot_status) return;

        $realPlayersCount = AbyssBet::where('round_id', $round->id)
            ->where('is_bot', false)
            ->where('is_demo', false)
            ->distinct('user_id')
            ->count('user_id');

        if ($realPlayersCount < $settings->bot_trigger_count) {
            $botPool = ['NeptuneStrike', 'AnubisVanguard', 'PharaohLord', 'SeaTitan', 'RaChampion', 'DesertStorm', 'ApexPoseidon', 'OsirisWarrior'];
            $botCount = rand(5, 9);

            for ($i = 0; $i < $botCount; $i++) {
                $side = rand(0, 1) ? 'poseidon' : 'anubis';
                $fakeBet = rand((int)$settings->bot_min_bet, (int)$settings->bot_max_bet);

                AbyssBet::create([
                    'round_id' => $round->id,
                    'is_bot' => true,
                    'bot_name' => $botPool[array_rand($botPool)],
                    'selected_side' => $side,
                    'bet_amount' => $fakeBet,
                    'status' => 'pending'
                ]);

                if ($side === 'poseidon') {
                    $round->increment('bot_bets_poseidon', $fakeBet);
                } else {
                    $round->increment('bot_bets_anubis', $fakeBet);
                }
            }
        }
    }

    // প্লেয়ারের বেট প্রসেসিং ও অ্যাটোমিক ওয়ালেট লক
    public function processBet(?User $user, array $data): array {
        $settings = AbyssSetting::firstOrCreate(['id' => 1]);
        $round = $this->getActiveOrCreateRound();

        if ($round->status !== 'betting') {
            throw new Exception('বেটিংয়ের সময় শেষ হয়ে গেছে!');
        }

        $isDemo = (bool)($data['is_demo'] ?? false);
        $amount = (float)($data['amount'] ?? 0.40);
        $side   = $data['side'] ?? 'poseidon';

        if ($amount < $settings->min_bet || $amount > $settings->max_bet) {
            throw new Exception("বেট অবশ্যই ৳ {$settings->min_bet} থেকে ৳ {$settings->max_bet} এর মধ্যে হতে হবে!");
        }

        // ডেমো মোড লিমিট চেক
        if ($isDemo) {
            $spinsDone = (int)($data['demo_spins_done'] ?? 0);
            if ($spinsDone >= $settings->demo_spin_limit) {
                return [
                    'deposit_required' => true,
                    'message' => 'ডেমো লিমিট শেষ! আসল টাকা জিতে ওয়ালেটে নিতে এখনই ডিপোজিট করুন।'
                ];
            }

            // Record demo bet
            AbyssBet::create([
                'round_id' => $round->id,
                'user_id' => $user ? $user->id : null,
                'is_demo' => true,
                'selected_side' => $side,
                'bet_amount' => $amount,
                'status' => 'pending'
            ]);

            return ['deposit_required' => false, 'new_balance' => null];
        }

        // রিয়েল মোড ওয়ালেট ডিডাকশন (Atomic Lock)
        return DB::transaction(function () use ($user, $amount, $side, $round) {
            if (!$user) {
                throw new Exception('অনুগ্রহ করে লগইন করুন!');
            }

            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if ($lockedUser->balance < $amount) {
                throw new Exception('আপনার ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই!');
            }

            $opening = (float)$lockedUser->balance;
            $lockedUser->decrement('balance', $amount);
            $closing = (float)$lockedUser->fresh()->balance;

            $bet = AbyssBet::create([
                'round_id' => $round->id,
                'user_id' => $lockedUser->id,
                'is_demo' => false,
                'selected_side' => $side,
                'bet_amount' => $amount,
                'status' => 'pending'
            ]);

            AbyssTransaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $amount,
                'balance_before' => $opening,
                'balance_after' => $closing
            ]);

            if ($side === 'poseidon') {
                $round->increment('real_bets_poseidon', $amount);
            } else {
                $round->increment('real_bets_anubis', $amount);
            }

            // Central tracking heartbeat
            try {
                if (class_exists(\App\Services\CasinoCentralTrackingService::class)) {
                    app(\App\Services\CasinoCentralTrackingService::class)->heartbeat('temple_of_fortune', $lockedUser->id, false);
                }
            } catch (\Exception $e) {}

            return ['deposit_required' => false, 'new_balance' => $closing];
        });
    }

    // হাউজ প্রফিট অ্যালগরিদম ও রাউন্ড সেটেলমেন্ট
    public function settleRound(AbyssRound $round): AbyssRound {
        return DB::transaction(function () use ($round) {
            $settings = AbyssSetting::firstOrCreate(['id' => 1]);
            $round->update(['status' => 'processing']);

            $realPoseidon = (float)$round->real_bets_poseidon;
            $realAnubis   = (float)$round->real_bets_anubis;

            $winningSide = 'poseidon';

            // House Profit Mode (কম টাকার দিক বিজয়ী হবে)
            if ($settings->control_mode === 'house_profit') {
                if ($realPoseidon < $realAnubis) {
                    $winningSide = 'poseidon';
                } elseif ($realAnubis < $realPoseidon) {
                    $winningSide = 'anubis';
                } else {
                    $winningSide = (rand(1, 100) <= $settings->win_chance_percentage) ? 'poseidon' : 'anubis';
                }
            } elseif ($settings->control_mode === 'fixed_percentage') {
                $winningSide = (rand(1, 100) <= $settings->win_chance_percentage) ? 'poseidon' : 'anubis';
            } else {
                $winningSide = rand(0, 1) ? 'poseidon' : 'anubis';
            }

            $matrix = $this->generateGrid($winningSide);
            $multiplier = (float)$settings->payout_multiplier;

            $winningBets = AbyssBet::where('round_id', $round->id)
                ->where('selected_side', $winningSide)
                ->get();

            $totalPayoutDistributed = 0.00;

            foreach ($winningBets as $bet) {
                $winAmount = round($bet->bet_amount * $multiplier, 2);
                $bet->update(['win_amount' => $winAmount, 'status' => 'won']);

                if (!$bet->is_bot && !$bet->is_demo && $bet->user_id) {
                    $player = User::where('id', $bet->user_id)->lockForUpdate()->first();
                    if ($player) {
                        $opening = (float)$player->balance;
                        $player->increment('balance', $winAmount);
                        $closing = (float)$player->fresh()->balance;

                        AbyssTransaction::create([
                            'user_id' => $player->id,
                            'bet_id' => $bet->id,
                            'type' => 'credit_win',
                            'amount' => $winAmount,
                            'balance_before' => $opening,
                            'balance_after' => $closing
                        ]);

                        $totalPayoutDistributed += $winAmount;

                        // Central Tracking Audit Record
                        try {
                            if (class_exists(\App\Services\CasinoCentralTrackingService::class)) {
                                app(\App\Services\CasinoCentralTrackingService::class)->recordRealTransaction(
                                    'temple_of_fortune',
                                    $player->id,
                                    (float)$bet->bet_amount,
                                    $winAmount,
                                    (float)$bet->bet_amount - $winAmount
                                );
                            }
                        } catch (\Exception $e) {}
                    }
                }
            }

            AbyssBet::where('round_id', $round->id)
                ->where('selected_side', '!=', $winningSide)
                ->update(['status' => 'lost']);

            $totalRealBets = $realPoseidon + $realAnubis;
            $adminNetProfit = $totalRealBets - $totalPayoutDistributed;

            $round->update([
                'winning_side' => $winningSide,
                'grid_matrix' => $matrix,
                'total_payout' => $totalPayoutDistributed,
                'admin_profit' => $adminNetProfit,
                'status' => 'completed'
            ]);

            return $round;
        });
    }

    private function generateGrid(string $winner): array {
        $poseidonSymbols = ['POSEIDON', 'TRIDENT', 'HORN', 'SWORD', 'WILD_FIRE'];
        $anubisSymbols   = ['ANUBIS', 'TEMPLE', 'SCARAB', 'SWORD', 'WILD_FIRE'];
        $pool = ($winner === 'poseidon') ? $poseidonSymbols : $anubisSymbols;

        $matrix = [];
        for ($r = 0; $r < 3; $r++) {
            for ($c = 0; $c < 5; $c++) {
                $matrix[$r][$c] = $pool[array_rand($pool)];
            }
        }
        return $matrix;
    }
}
