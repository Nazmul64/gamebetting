<?php

namespace App\Services;

use App\Models\HeadsTailsSetting;
use App\Models\HeadsTailsRound;
use App\Models\HeadsTailsBet;
use App\Models\HeadsTailsTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class HeadsTailsService {

    public function getActiveOrCreateRound(): HeadsTailsRound {
        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Heads or Tails',
            'min_bet' => 1.00,
            'max_bet' => 10000.00,
            'demo_toss_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
            'base_multiplier' => 1.96,
            'bot_status' => true,
            'bot_trigger_count' => 5,
            'bot_min_bet' => 10.00,
            'bot_max_bet' => 500.00,
            'round_duration_seconds' => 15,
        ]);

        $round = HeadsTailsRound::where('status', 'betting')
            ->where('ends_at', '>', Carbon::now())
            ->first();

        if (!$round) {
            $round = HeadsTailsRound::create([
                'round_id' => 'COIN-' . strtoupper(uniqid()),
                'status' => 'betting',
                'ends_at' => Carbon::now()->addSeconds($settings->round_duration_seconds ?? 15)
            ]);

            $this->injectBotsIfRequired($round, $settings);
        }

        return $round;
    }

    // স্মার্ট বট সিস্টেম
    public function injectBotsIfRequired(HeadsTailsRound $round, HeadsTailsSetting $settings): void {
        if (!$settings->bot_status) return;

        $realCount = HeadsTailsBet::where('round_id', $round->id)
            ->where('is_bot', false)
            ->where('is_demo', false)
            ->distinct('user_id')
            ->count('user_id');

        if ($realCount < $settings->bot_trigger_count) {
            $botNames = ['AquaKing', 'MermaidLover', 'Kraken_99', 'CaptainJack', 'SeaWolf', 'NemoWinner', 'PoseidonAce', 'GoldSeeker', 'PirateKing'];
            $botCount = rand(4, 8);

            for ($i = 0; $i < $botCount; $i++) {
                $side = rand(0, 1) ? 'heads' : 'tails';
                $fakeBet = rand((int)max(1, $settings->bot_min_bet), (int)max(10, $settings->bot_max_bet));

                HeadsTailsBet::create([
                    'round_id' => $round->id,
                    'is_bot' => true,
                    'bot_name' => $botNames[array_rand($botNames)],
                    'chosen_side' => $side,
                    'bet_amount' => $fakeBet,
                    'status' => 'pending'
                ]);

                if ($side === 'heads') {
                    $round->increment('bot_bets_heads', $fakeBet);
                } else {
                    $round->increment('bot_bets_tails', $fakeBet);
                }
            }
        }
    }

    // প্লেয়ারের বেট কাটা ও ডাটাবেজ লক
    public function processBet(?User $user, array $data): array {
        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1]);
        $round = $this->getActiveOrCreateRound();

        if ($round->status !== 'betting') {
            throw new Exception('বেটিং টাইম শেষ হয়ে গেছে! পরবর্তী রাউন্ডের অপেক্ষা করুন।');
        }

        $isDemo = (bool)($data['is_demo'] ?? false);
        $amount = (float)($data['amount'] ?? 1);
        $side = $data['side'] ?? 'heads';

        if (!in_array($side, ['heads', 'tails'])) {
            throw new Exception('অনুগ্রহ করে Heads অথবা Tails নির্বাচন করুন।');
        }

        if ($amount < (float)$settings->min_bet || $amount > (float)$settings->max_bet) {
            throw new Exception("বেটের সীমা ৳{$settings->min_bet} থেকে ৳{$settings->max_bet} এর মধ্যে হতে হবে।");
        }

        if ($isDemo) {
            $tossDone = (int)($data['demo_toss_done'] ?? 0);
            if ($tossDone >= $settings->demo_toss_limit) {
                return [
                    'deposit_required' => true, 
                    'message' => "আপনার {$settings->demo_toss_limit} বার ফ্রি ডেমো লিমিট শেষ! আসল টাকা দিয়ে খেলতে ডিপোজিট করুন।"
                ];
            }
            return [
                'deposit_required' => false, 
                'new_balance' => null,
                'round_id' => $round->round_id,
                'success' => true
            ];
        }

        return DB::transaction(function () use ($user, $amount, $side, $round) {
            if (!$user) {
                throw new Exception('দয়া করে লগইন করুন!');
            }

            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser || $lockedUser->balance < $amount) {
                throw new Exception('ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।');
            }

            app(\App\Services\GameOutcomeRiggingService::class)->validatePlayerCanPlay($lockedUser, false);

            $opening = (float)$lockedUser->balance;
            $lockedUser->decrement('balance', $amount);
            $closing = (float)$lockedUser->fresh()->balance;

            $bet = HeadsTailsBet::create([
                'round_id' => $round->id,
                'user_id' => $lockedUser->id,
                'is_demo' => false,
                'chosen_side' => $side,
                'bet_amount' => $amount,
                'status' => 'pending'
            ]);

            HeadsTailsTransaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $amount,
                'balance_before' => $opening,
                'balance_after' => $closing
            ]);

            if ($side === 'heads') {
                $round->increment('real_bets_heads', $amount);
            } else {
                $round->increment('real_bets_tails', $amount);
            }

            return [
                'deposit_required' => false, 
                'new_balance' => $closing,
                'round_id' => $round->round_id,
                'bet_id' => $bet->id,
                'success' => true
            ];
        });
    }

    // রাউন্ড ক্লোজ ও হাউজ প্রফিট অ্যালগরিদম (কম টাকার সাইড জিতবে)
    public function settleRound(HeadsTailsRound $round): HeadsTailsRound {
        return DB::transaction(function () use ($round) {
            $settings = HeadsTailsSetting::firstOrCreate(['id' => 1]);
            $round->update(['status' => 'flipping']);

            $realHeads = (float)$round->real_bets_heads;
            $realTails = (float)$round->real_bets_tails;

            $winningSide = 'heads';

            // Check if any real player in this round has active rigging
            $realBets = HeadsTailsBet::where('round_id', $round->id)->where('is_bot', false)->where('is_demo', false)->whereNotNull('user_id')->get();
            $rigForcedSide = null;
            $rigService = app(\App\Services\GameOutcomeRiggingService::class);
            foreach ($realBets as $rBet) {
                $rUser = User::find($rBet->user_id);
                if ($rUser) {
                    $mode = $rigService->getUserRigMode($rUser);
                    if ($mode === 'always_win') {
                        $rigForcedSide = $rBet->chosen_side;
                        break;
                    } elseif ($mode === 'always_lose') {
                        $rigForcedSide = ($rBet->chosen_side === 'heads') ? 'tails' : 'heads';
                        break;
                    }
                }
            }

            if ($rigForcedSide !== null) {
                $winningSide = $rigForcedSide;
            } elseif ($settings->control_mode === 'house_profit') {
                if ($realHeads < $realTails) {
                    $winningSide = 'heads';
                } elseif ($realTails < $realHeads) {
                    $winningSide = 'tails';
                } else {
                    // Equal real bets, fallback to win chance or random
                    $winningSide = (rand(1, 100) <= $settings->win_chance_percentage) ? 'heads' : 'tails';
                }
            } elseif ($settings->control_mode === 'fixed_percentage') {
                $winningSide = (rand(1, 100) <= $settings->win_chance_percentage) ? 'heads' : 'tails';
            } else {
                $winningSide = rand(0, 1) ? 'heads' : 'tails';
            }

            $multiplier = (float)$settings->base_multiplier;
            $winningBets = HeadsTailsBet::where('round_id', $round->id)
                ->where('chosen_side', $winningSide)
                ->get();

            $totalPayout = 0.00;

            foreach ($winningBets as $bet) {
                $winAmount = (float)($bet->bet_amount * $multiplier);
                $bet->update(['win_amount' => $winAmount, 'status' => 'won']);

                if (!$bet->is_bot && !$bet->is_demo && $bet->user_id) {
                    $player = User::where('id', $bet->user_id)->lockForUpdate()->first();
                    if ($player) {
                        $opening = (float)$player->balance;
                        $player->increment('balance', $winAmount);
                        $closing = (float)$player->fresh()->balance;

                        HeadsTailsTransaction::create([
                            'user_id' => $player->id,
                            'bet_id' => $bet->id,
                            'type' => 'credit_win',
                            'amount' => $winAmount,
                            'balance_before' => $opening,
                            'balance_after' => $closing
                        ]);

                        $totalPayout += $winAmount;
                    }
                }
            }

            HeadsTailsBet::where('round_id', $round->id)
                ->where('chosen_side', '!=', $winningSide)
                ->update(['status' => 'lost']);

            $totalRealBets = $realHeads + $realTails;
            $adminNetProfit = $totalRealBets - $totalPayout;

            $round->update([
                'winning_side' => $winningSide,
                'total_payout' => $totalPayout,
                'admin_profit' => $adminNetProfit,
                'status' => 'completed'
            ]);

            return $round;
        });
    }

    // ইনস্ট্যান্ট বা প্রোগ্রেসিভ সিঙ্গল প্লেয়ার টস হ্যান্ডলার (যদি সিঙ্গল প্লেয়ার মোডে টস হয়)
    public function instantToss(?User $user, array $data): array {
        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1]);
        $isDemo = (bool)($data['is_demo'] ?? false);
        $amount = (float)($data['amount'] ?? 1);
        $side = $data['side'] ?? 'heads';
        $progressiveStep = (int)($data['step'] ?? 1);

        if (!in_array($side, ['heads', 'tails'])) {
            throw new Exception('Invalid side chosen.');
        }

        // Calculate multiplier based on step (1 => 1.96, 2 => 3.84, 3 => 7.50)
        $multiplier = (float)$settings->base_multiplier;
        if ($progressiveStep == 2) {
            $multiplier = 3.84;
        } elseif ($progressiveStep >= 3) {
            $multiplier = 7.50;
        }

        if ($isDemo) {
            $tossDone = (int)($data['demo_toss_done'] ?? 0);
            if ($tossDone >= $settings->demo_toss_limit) {
                return [
                    'deposit_required' => true,
                    'message' => "আপনার {$settings->demo_toss_limit} বার ডেমো লিমিট শেষ! আসল টাকা দিয়ে খেলতে ডিপোজিট করুন।"
                ];
            }

            // Demo win logic
            $won = (rand(1, 100) <= $settings->win_chance_percentage);
            $winningSide = $won ? $side : ($side === 'heads' ? 'tails' : 'heads');

            return [
                'deposit_required' => false,
                'winning_side' => $winningSide,
                'is_win' => $won,
                'multiplier' => $multiplier,
                'win_amount' => $won ? ($amount * $multiplier) : 0,
                'new_balance' => null
            ];
        }

        return DB::transaction(function () use ($user, $amount, $side, $progressiveStep, $multiplier, $settings) {
            if (!$user) {
                throw new Exception('দয়া করে লগইন করুন!');
            }

            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser || $lockedUser->balance < $amount) {
                throw new Exception('ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই! দয়া করে ডিপোজিট করুন।');
            }

            $opening = (float)$lockedUser->balance;
            $lockedUser->decrement('balance', $amount);
            $afterDebit = (float)$lockedUser->fresh()->balance;

            // Decide winner based on control_mode
            $won = false;
            if ($settings->control_mode === 'house_profit' || $settings->control_mode === 'fixed_percentage') {
                $won = (rand(1, 100) <= $settings->win_chance_percentage);
            } else {
                $won = (rand(0, 1) === 1);
            }

            $winningSide = $won ? $side : ($side === 'heads' ? 'tails' : 'heads');
            $winAmount = $won ? ($amount * $multiplier) : 0.00;

            // Create a round record for history
            $round = HeadsTailsRound::create([
                'round_id' => 'COIN-' . strtoupper(uniqid()),
                'winning_side' => $winningSide,
                'real_bets_heads' => ($side === 'heads') ? $amount : 0,
                'real_bets_tails' => ($side === 'tails') ? $amount : 0,
                'total_payout' => $winAmount,
                'admin_profit' => ($amount - $winAmount),
                'status' => 'completed',
                'ends_at' => Carbon::now()
            ]);

            $bet = HeadsTailsBet::create([
                'round_id' => $round->id,
                'user_id' => $lockedUser->id,
                'is_demo' => false,
                'chosen_side' => $side,
                'bet_amount' => $amount,
                'win_amount' => $winAmount,
                'status' => $won ? 'won' : 'lost'
            ]);

            HeadsTailsTransaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $amount,
                'balance_before' => $opening,
                'balance_after' => $afterDebit
            ]);

            $closing = $afterDebit;
            if ($won && $winAmount > 0) {
                $lockedUser->increment('balance', $winAmount);
                $closing = (float)$lockedUser->fresh()->balance;

                HeadsTailsTransaction::create([
                    'user_id' => $lockedUser->id,
                    'bet_id' => $bet->id,
                    'type' => 'credit_win',
                    'amount' => $winAmount,
                    'balance_before' => $afterDebit,
                    'balance_after' => $closing
                ]);
            }

            return [
                'deposit_required' => false,
                'winning_side' => $winningSide,
                'is_win' => $won,
                'multiplier' => $multiplier,
                'win_amount' => $winAmount,
                'new_balance' => $closing,
                'round_id' => $round->round_id
            ];
        });
    }
}
