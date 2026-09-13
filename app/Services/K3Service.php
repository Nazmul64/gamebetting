<?php

namespace App\Services;

use App\Models\K3Setting;
use App\Models\K3Period;
use App\Models\K3Bet;
use App\Models\K3Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class K3Service {

    public function getOrCreatePeriod(string $timeType = '1m'): K3Period {
        $this->ensureInitialHistory($timeType);

        $now = Carbon::now();
        $period = K3Period::where('time_type', $timeType)
            ->where('status', '!=', 'completed')
            ->where('ends_at', '>', $now)
            ->latest('id')
            ->first();

        if (!$period) {
            $duration = match($timeType) {
                '3m' => 180,
                '5m' => 300,
                '10m' => 600,
                default => 60
            };

            // Format period number: YmdHi + random 5 digits
            $periodNumber = $now->format('YmdHi') . rand(10000, 99999);

            $period = K3Period::create([
                'period_number' => $periodNumber,
                'time_type' => $timeType,
                'status' => 'betting',
                'starts_at' => $now,
                'ends_at' => $now->copy()->addSeconds($duration)
            ]);

            $this->injectBots($period);
        }

        return $period;
    }

    public function ensureInitialHistory(string $timeType): void {
        $count = K3Period::where('time_type', $timeType)->where('status', 'completed')->count();
        if ($count < 15) {
            $now = Carbon::now();
            $duration = match($timeType) {
                '3m' => 180,
                '5m' => 300,
                '10m' => 600,
                default => 60
            };

            for ($i = 20; $i >= 1; $i--) {
                $pastTime = $now->copy()->subSeconds($i * $duration);
                $d1 = rand(1, 6);
                $d2 = rand(1, 6);
                $d3 = rand(1, 6);
                $sum = $d1 + $d2 + $d3;
                $size = ($sum >= 11) ? 'big' : 'small';
                $parity = ($sum % 2 !== 0) ? 'odd' : 'even';
                
                $pattern = 'different';
                if ($d1 === $d2 && $d2 === $d3) {
                    $pattern = '3_same';
                } elseif ($d1 === $d2 || $d2 === $d3 || $d1 === $d3) {
                    $pattern = '2_same';
                }

                K3Period::create([
                    'period_number' => $pastTime->format('YmdHi') . rand(10000, 99999),
                    'time_type' => $timeType,
                    'status' => 'completed',
                    'dice_1' => $d1,
                    'dice_2' => $d2,
                    'dice_3' => $d3,
                    'total_sum' => $sum,
                    'size' => $size,
                    'parity' => $parity,
                    'pattern' => $pattern,
                    'starts_at' => $pastTime->copy()->subSeconds($duration),
                    'ends_at' => $pastTime,
                    'created_at' => $pastTime,
                    'updated_at' => $pastTime
                ]);
            }
        }
    }

    public function injectBots(K3Period $period): void {
        $settings = K3Setting::firstOrCreate(['id' => 1]);
        if (!$settings->bot_status) return;

        $options = ['big', 'small', 'odd', 'even', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '2_same', '3_same', 'different'];
        $botNames = ['Player_K3', 'LuckyDice', 'ChokkaMaster', 'Rifat_77', 'AmarClub_VIP', 'Tiger_99', 'Royal_King', 'Dhaka_Boss', 'Star_Player'];

        $count = rand(3, max(4, $settings->bot_trigger_count ?? 6));
        for ($i = 0; $i < $count; $i++) {
            $val = $options[array_rand($options)];
            $type = 'total';
            if (in_array($val, ['big', 'small'])) {
                $type = 'size';
            } elseif (in_array($val, ['odd', 'even'])) {
                $type = 'parity';
            } elseif (in_array($val, ['2_same', '3_same', 'different'])) {
                $type = $val;
            }

            $betAmount = rand(10, 200);

            K3Bet::create([
                'period_id' => $period->id,
                'is_bot' => true,
                'bot_name' => $botNames[array_rand($botNames)],
                'bet_type' => $type,
                'selected_value' => $val,
                'unit_amount' => $betAmount,
                'multiplier' => 1,
                'total_amount' => $betAmount,
                'status' => 'pending'
            ]);
        }
    }

    public function processBet(?User $user, array $data): array {
        $settings = K3Setting::firstOrCreate(['id' => 1]);
        $timeType = $data['time_type'] ?? '1m';
        $period = $this->getOrCreatePeriod($timeType);

        if (Carbon::now()->diffInSeconds($period->ends_at, false) <= 5) {
            throw new Exception('বেটিং টাইম শেষ হয়ে গেছে! পরবর্তী রাউন্ডের জন্য অপেক্ষা করুন।');
        }

        $isDemo = (bool)($data['is_demo'] ?? false);
        $unitAmount = (float)($data['amount'] ?? 1);
        $multiplier = (int)($data['multiplier'] ?? 1);
        $singleBetCharged = $unitAmount * $multiplier;

        $betsList = [];
        if (!empty($data['bets']) && is_array($data['bets'])) {
            foreach ($data['bets'] as $b) {
                if (!empty($b['bet_type']) && isset($b['selected_value'])) {
                    $betsList[] = [
                        'bet_type' => $b['bet_type'],
                        'selected_value' => (string)$b['selected_value']
                    ];
                }
            }
        }
        if (empty($betsList)) {
            $betsList[] = [
                'bet_type' => $data['bet_type'] ?? 'total',
                'selected_value' => (string)($data['selected_value'] ?? '3')
            ];
        }

        $totalBetsCount = count($betsList);
        $totalCharged = $singleBetCharged * $totalBetsCount;

        if ($singleBetCharged < ($settings->min_bet ?? 1)) {
            throw new Exception('সর্বনিম্ন বাজি ৳ ' . ($settings->min_bet ?? 1));
        }
        if ($totalCharged > ($settings->max_bet ?? 50000)) {
            throw new Exception('সর্বোচ্চ বাজি ৳ ' . ($settings->max_bet ?? 50000));
        }

        if ($isDemo) {
            $demoCount = (int)($data['demo_bets_count'] ?? 0);
            if ($demoCount >= ($settings->demo_limit ?? 3)) {
                return ['deposit_required' => true, 'message' => 'আপনার ডেমো লিমিট শেষ! ডিপোজিট করুন।'];
            }
            return ['deposit_required' => false, 'new_balance' => null, 'demo_count' => $demoCount + 1];
        }

        return DB::transaction(function () use ($user, $totalCharged, $singleBetCharged, $unitAmount, $multiplier, $betsList, $period) {
            if (!$user) {
                throw new Exception('অনুগ্রহ করে প্রথমে লগইন করুন!');
            }

            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if ($lockedUser->balance < $totalCharged) {
                throw new Exception('ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই!');
            }

            $opening = $lockedUser->balance;
            $lockedUser->decrement('balance', $totalCharged);
            $closing = $lockedUser->fresh()->balance;

            foreach ($betsList as $b) {
                $bet = K3Bet::create([
                    'period_id' => $period->id,
                    'user_id' => $lockedUser->id,
                    'is_demo' => false,
                    'bet_type' => $b['bet_type'],
                    'selected_value' => $b['selected_value'],
                    'unit_amount' => $unitAmount,
                    'multiplier' => $multiplier,
                    'total_amount' => $singleBetCharged,
                    'status' => 'pending'
                ]);

                K3Transaction::create([
                    'user_id' => $lockedUser->id,
                    'bet_id' => $bet->id,
                    'type' => 'debit_bet',
                    'amount' => $singleBetCharged,
                    'balance_before' => $opening,
                    'balance_after' => $closing
                ]);
            }

            $period->increment('total_real_bets', $totalCharged);

            return ['deposit_required' => false, 'new_balance' => $closing];
        });
    }

    // হাউজ প্রফিট ইঞ্জিন: ৩টি ডাইসের কম্বিনেশনের মধ্যে সর্বনিম্ন পেআউটের কম্বিনেশন বিজয়ী করা
    public function settlePeriod(K3Period $period, ?array $manualDice = null): K3Period {
        return DB::transaction(function () use ($period, $manualDice) {
            $settings = K3Setting::firstOrCreate(['id' => 1]);
            $period->update(['status' => 'locked']);

            // ৩টি ডাইসের কম্বিনেশন তৈরি (1-1-1 থেকে 6-6-6 পর্যন্ত মোট ২১৬টি কম্বিনেশন)
            $possibleCombos = [];
            for ($d1 = 1; $d1 <= 6; $d1++) {
                for ($d2 = 1; $d2 <= 6; $d2++) {
                    for ($d3 = 1; $d3 <= 6; $d3++) {
                        $possibleCombos[] = [$d1, $d2, $d3];
                    }
                }
            }

            if ($manualDice && count($manualDice) === 3) {
                $bestDice = [(int)$manualDice[0], (int)$manualDice[1], (int)$manualDice[2]];
            } else {
                $bestDice = [rand(1, 6), rand(1, 6), rand(1, 6)];

                if ($settings->control_mode === 'house_profit') {
                    $minPayout = PHP_INT_MAX;
                    $bestCandidates = [];
                    shuffle($possibleCombos);

                    foreach ($possibleCombos as $dice) {
                        $payout = $this->calculatePotentialPayout($period->id, $dice[0], $dice[1], $dice[2]);
                        if ($payout < $minPayout) {
                            $minPayout = $payout;
                            $bestCandidates = [$dice];
                        } elseif ($payout == $minPayout) {
                            $bestCandidates[] = $dice;
                        }
                    }

                    if (!empty($bestCandidates)) {
                        $bestDice = $bestCandidates[array_rand($bestCandidates)];
                    }
                } elseif ($settings->control_mode === 'random') {
                    $bestDice = [rand(1, 6), rand(1, 6), rand(1, 6)];
                }
            }

            $d1 = (int)$bestDice[0];
            $d2 = (int)$bestDice[1];
            $d3 = (int)$bestDice[2];
            $total = $d1 + $d2 + $d3;
            $size = ($total >= 11) ? 'big' : 'small';
            $parity = ($total % 2 !== 0) ? 'odd' : 'even';

            $pattern = 'different';
            if ($d1 === $d2 && $d2 === $d3) {
                $pattern = '3_same';
            } elseif ($d1 === $d2 || $d2 === $d3 || $d1 === $d3) {
                $pattern = '2_same';
            }

            $winningBets = K3Bet::where('period_id', $period->id)->get();
            $totalDistributed = 0.00;

            foreach ($winningBets as $bet) {
                $win = $this->evaluateBetOutcome($bet, $d1, $d2, $d3, $total, $size, $parity);
                if ($win > 0) {
                    $bet->update(['win_amount' => $win, 'status' => 'won']);

                    if (!$bet->is_bot && !$bet->is_demo && $bet->user_id) {
                        $player = User::where('id', $bet->user_id)->lockForUpdate()->first();
                        if ($player) {
                            $opening = $player->balance;
                            $player->increment('balance', $win);
                            $closing = $player->fresh()->balance;

                            K3Transaction::create([
                                'user_id' => $player->id,
                                'bet_id' => $bet->id,
                                'type' => 'credit_win',
                                'amount' => $win,
                                'balance_before' => $opening,
                                'balance_after' => $closing
                            ]);
                        }

                        $totalDistributed += $win;
                    }
                } else {
                    $bet->update(['status' => 'lost']);
                }
            }

            $adminNetProfit = $period->total_real_bets - $totalDistributed;

            $period->update([
                'dice_1' => $d1,
                'dice_2' => $d2,
                'dice_3' => $d3,
                'total_sum' => $total,
                'size' => $size,
                'parity' => $parity,
                'pattern' => $pattern,
                'total_payout' => $totalDistributed,
                'admin_profit' => $adminNetProfit,
                'status' => 'completed'
            ]);

            return $period;
        });
    }

    private function calculatePotentialPayout(int $periodId, int $d1, int $d2, int $d3): float {
        $total = $d1 + $d2 + $d3;
        $size = ($total >= 11) ? 'big' : 'small';
        $parity = ($total % 2 !== 0) ? 'odd' : 'even';

        $bets = K3Bet::where('period_id', $periodId)->where('is_bot', false)->where('is_demo', false)->get();
        $payout = 0.00;

        foreach ($bets as $bet) {
            $payout += $this->evaluateBetOutcome($bet, $d1, $d2, $d3, $total, $size, $parity);
        }
        return $payout;
    }

    public function evaluateBetOutcome(K3Bet $bet, int $d1, int $d2, int $d3, int $total, string $size, string $parity): float {
        $amount = $bet->total_amount;
        $val = strtolower(trim((string)$bet->selected_value));

        // সাইজ বাজি (Big / Small) - 2X
        if ($bet->bet_type === 'size' && $val === $size) {
            return $amount * 2.0;
        }

        // প্যারিটি বাজি (Odd / Even) - 2X
        if ($bet->bet_type === 'parity' && $val === $parity) {
            return $amount * 2.0;
        }

        // যোগফল বাজি (Total Sum Multipliers)
        if ($bet->bet_type === 'total' && (int)$val === $total) {
            $rates = [
                3 => 207.36, 18 => 207.36,
                4 => 69.12,  17 => 69.12,
                5 => 34.56,  16 => 34.56,
                6 => 20.74,  15 => 20.74,
                7 => 13.83,  14 => 13.83,
                8 => 9.88,   13 => 9.88,
                9 => 8.30,   12 => 8.30,
                10 => 7.68,  11 => 7.68
            ];
            return $amount * ($rates[$total] ?? 2.0);
        }

        // 2 Same
        if ($bet->bet_type === '2_same') {
            $hasPair = ($d1 === $d2 || $d2 === $d3 || $d1 === $d3);
            if ($val === '2_same' || $val === 'any') {
                if ($hasPair) return $amount * 13.83;
            } elseif (str_starts_with($val, 'pair_')) {
                $pairDigit = (int)substr($val, 5, 1);
                $matchCount = ($d1 === $pairDigit ? 1 : 0) + ($d2 === $pairDigit ? 1 : 0) + ($d3 === $pairDigit ? 1 : 0);
                if ($matchCount >= 2) return $amount * 69.12;
            } elseif (strlen($val) === 2 && $val[0] === $val[1]) {
                // specific pair like "11", "22", etc. (odds: 13.83)
                $pairDigit = (int)$val[0];
                $matchCount = ($d1 === $pairDigit ? 1 : 0) + ($d2 === $pairDigit ? 1 : 0) + ($d3 === $pairDigit ? 1 : 0);
                if ($matchCount >= 2) return $amount * 13.83;
            } elseif ($hasPair) {
                return $amount * 13.83;
            }
        }

        // 3 Same
        if ($bet->bet_type === '3_same') {
            $isTriple = ($d1 === $d2 && $d2 === $d3);
            if ($val === '3_same' || $val === 'any') {
                // Any 3 of same number - 34.56X
                if ($isTriple) return $amount * 34.56;
            } elseif (strlen($val) === 3 && $val[0] === $val[1] && $val[1] === $val[2]) {
                // Specific triple e.g. "111", "666" - 207.36X
                $tripleDigit = (int)$val[0];
                if ($isTriple && $d1 === $tripleDigit) return $amount * 207.36;
            } elseif ($isTriple) {
                return $amount * 34.56;
            }
        }

        // Different
        if ($bet->bet_type === 'different') {
            $diceSorted = [$d1, $d2, $d3];
            sort($diceSorted);
            $isContinuous = ($diceSorted[1] === $diceSorted[0] + 1 && $diceSorted[2] === $diceSorted[1] + 1);
            $allDistinct = ($d1 !== $d2 && $d2 !== $d3 && $d1 !== $d3);

            if ($val === 'continuous') {
                if ($isContinuous) return $amount * 8.64;
            } elseif (str_starts_with($val, 'diff3_')) {
                $num = (int)substr($val, 6);
                if ($allDistinct && in_array($num, [$d1, $d2, $d3])) return $amount * 34.56;
            } elseif (str_starts_with($val, 'diff2_')) {
                $num = (int)substr($val, 6);
                if (in_array($num, [$d1, $d2, $d3])) return $amount * 6.91;
            } elseif (str_starts_with($val, 'single_')) {
                $num = (int)substr($val, 7);
                if (in_array($num, [$d1, $d2, $d3])) return $amount * 69.12;
            } elseif ($allDistinct) {
                return $amount * 3.84;
            }
        }

        return 0.00;
    }
}
