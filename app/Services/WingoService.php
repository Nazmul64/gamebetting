<?php

namespace App\Services;

use App\Models\WingoSetting;
use App\Models\WingoPeriod;
use App\Models\WingoBet;
use App\Models\WingoTransaction;
use App\Models\User;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class WingoService {

    // নির্দিষ্ট টাইম ফ্রেমের বর্তমান রাউন্ড বের করা বা নতুন রাউন্ড শুরু করা
    public function getOrCreatePeriod(string $timeType = '30s'): WingoPeriod {
        $now = Carbon::now();
        $period = WingoPeriod::where('time_type', $timeType)
            ->where('status', '!=', 'completed')
            ->where('ends_at', '>', $now)
            ->orderBy('id', 'desc')
            ->first();

        if (!$period) {
            $duration = match($timeType) {
                '1m' => 60,
                '3m' => 180,
                '5m' => 300,
                default => 30
            };

            // ইউনিক পিরিয়ড জেনারেশন (স্ক্রিনশটের মতো ২০২৬০৯১২১০০... ফরম্যাট)
            $periodNumber = $now->format('YmdHi') . rand(10000, 99999);

            $period = WingoPeriod::create([
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

    // স্মার্ট বট ইনজেকশন
    public function injectBots(WingoPeriod $period): void {
        $settings = WingoSetting::firstOrCreate(['id' => 1]);
        if (!$settings->bot_status) return;

        $options = ['green', 'red', 'violet', 'big', 'small', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $botNames = ['AmarUser_01', 'DhakaKing', 'Raju_99', 'WinPro', 'LuckyBoss', 'SlotMaster', 'BetKing_BD', 'TirangaPro'];

        $count = rand(3, 7);
        for ($i = 0; $i < $count; $i++) {
            $val = $options[array_rand($options)];
            $type = is_numeric($val) ? 'number' : (in_array($val, ['big', 'small']) ? 'size' : 'color');

            WingoBet::create([
                'period_id' => $period->id,
                'is_bot' => true,
                'bot_name' => $botNames[array_rand($botNames)],
                'bet_type' => $type,
                'selected_value' => (string)$val,
                'unit_amount' => rand(10, 200),
                'multiplier' => 1,
                'total_amount' => rand(10, 200),
                'status' => 'pending'
            ]);
        }
    }

    // বেট প্রসেসিং ও ব্যালেন্স ডেবিট
    public function processBet(?User $user, array $data): array {
        $settings = WingoSetting::firstOrCreate(['id' => 1]);
        $timeType = $data['time_type'] ?? '30s';
        $period = $this->getOrCreatePeriod($timeType);

        // শেষ ৫ সেকেন্ডে বাজি বন্ধ থাকবে
        $now = Carbon::now();
        if ($now->greaterThanOrEqualTo($period->ends_at) || $period->ends_at->diffInSeconds($now, false) > -5) {
            // Alternatively check positive diff
            $remaining = $now->diffInSeconds($period->ends_at, false);
            if ($remaining <= 5) {
                throw new Exception('বেটিং টাইম শেষ হয়ে গেছে! পরবর্তী পিরিয়ডের জন্য অপেক্ষা করুন।');
            }
        }

        $isDemo = filter_var($data['is_demo'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $unitAmount = (float)$data['amount'];
        $multiplier = (int)($data['multiplier'] ?? 1);
        $totalCharged = $unitAmount * $multiplier;

        // চেক ডেমো লিমিটেশন
        if ($isDemo) {
            $demoLimit = $settings->demo_limit ?? 3;
            // Also check global setting if available
            try {
                if (class_exists(Setting::class)) {
                    $demoLimit = (int) Setting::getVal('demo_spins_limit', $demoLimit);
                }
            } catch (\Throwable $e) {}

            $demoBetsCount = (int)($data['demo_bets_count'] ?? 0);
            if ($demoBetsCount >= $demoLimit) {
                return ['deposit_required' => true, 'message' => 'আপনার ডেমো লিমিট শেষ! ডিপোজিট করুন।'];
            }
            return [
                'deposit_required' => false,
                'is_demo' => true,
                'new_balance' => null,
                'message' => 'ডেমো বেট সফলভাবে প্লেস করা হয়েছে!'
            ];
        }

        return DB::transaction(function () use ($user, $totalCharged, $unitAmount, $multiplier, $data, $period) {
            if (!$user) {
                throw new Exception('দয়া করে প্রথমে লগইন করুন!');
            }

            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser || $lockedUser->balance < $totalCharged) {
                throw new Exception('আপনার ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই!');
            }

            app(\App\Services\GameOutcomeRiggingService::class)->validatePlayerCanPlay($lockedUser, false);

            $opening = $lockedUser->balance;
            $lockedUser->decrement('balance', $totalCharged);
            $closing = $lockedUser->fresh()->balance;

            $bet = WingoBet::create([
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

            WingoTransaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $totalCharged,
                'balance_before' => $opening,
                'balance_after' => $closing
            ]);

            $period->increment('total_real_bets', $totalCharged);

            return [
                'deposit_required' => false,
                'is_demo' => false,
                'new_balance' => $closing,
                'message' => 'বেট সফলভাবে গৃহীত হয়েছে!'
            ];
        });
    }

    // হাউজ প্রফিট ইঞ্জিন: ০ থেকে ৯ এর মধ্যে সর্বনিম্ন পে-আউটের নম্বর বিজয়ী করা
    public function settlePeriod(WingoPeriod $period): WingoPeriod {
        return DB::transaction(function () use ($period) {
            $settings = WingoSetting::firstOrCreate(['id' => 1]);
            $period->update(['status' => 'locked']);

            $numberPayouts = [];
            for ($num = 0; $num <= 9; $num++) {
                $numberPayouts[$num] = $this->calculatePotentialPayout($period->id, $num);
            }

            $winningNumber = 0;
            $rigService = app(\App\Services\GameOutcomeRiggingService::class);
            $realBets = WingoBet::where('period_id', $period->id)->where('is_bot', false)->where('is_demo', false)->whereNotNull('user_id')->get();
            $forcedNumber = null;

            foreach ($realBets as $rBet) {
                $rUser = User::find($rBet->user_id);
                if ($rUser) {
                    $mode = $rigService->getUserRigMode($rUser);
                    if ($mode === 'always_win') {
                        // Find a number where this bet wins
                        for ($checkNum = 0; $checkNum <= 9; $checkNum++) {
                            $checkColor = $this->getColorForNumber($checkNum);
                            $checkSize = ($checkNum >= 5) ? 'big' : 'small';
                            if ($this->evaluateBetOutcome($rBet, $checkNum, $checkColor, $checkSize) > 0) {
                                $forcedNumber = $checkNum;
                                break;
                            }
                        }
                        if ($forcedNumber !== null) break;
                    } elseif ($mode === 'always_lose') {
                        // Find a number where this bet loses
                        for ($checkNum = 0; $checkNum <= 9; $checkNum++) {
                            $checkColor = $this->getColorForNumber($checkNum);
                            $checkSize = ($checkNum >= 5) ? 'big' : 'small';
                            if ($this->evaluateBetOutcome($rBet, $checkNum, $checkColor, $checkSize) == 0) {
                                $forcedNumber = $checkNum;
                                break;
                            }
                        }
                        if ($forcedNumber !== null) break;
                    }
                }
            }

            if ($forcedNumber !== null) {
                $winningNumber = $forcedNumber;
            } elseif ($settings->control_mode === 'house_profit') {
                // যে নম্বরে মোট পে-আউট সবচেয়ে কম দিতে হবে
                asort($numberPayouts);
                $winningNumber = array_key_first($numberPayouts);
            } elseif ($settings->control_mode === 'fixed_percentage') {
                $chance = $settings->win_chance_percentage ?? 30;
                if (rand(1, 100) <= $chance) {
                    // Win favorable to players (pick highest payout or random)
                    arsort($numberPayouts);
                    $winningNumber = array_key_first($numberPayouts);
                } else {
                    asort($numberPayouts);
                    $winningNumber = array_key_first($numberPayouts);
                }
            } else {
                $winningNumber = rand(0, 9);
            }

            $color = $this->getColorForNumber($winningNumber);
            $size = ($winningNumber >= 5) ? 'big' : 'small';

            $winningBets = WingoBet::where('period_id', $period->id)->get();
            $totalDistributed = 0.00;

            foreach ($winningBets as $bet) {
                $win = $this->evaluateBetOutcome($bet, $winningNumber, $color, $size);
                if ($win > 0) {
                    $bet->update(['win_amount' => $win, 'status' => 'won']);

                    if (!$bet->is_bot && !$bet->is_demo && $bet->user_id) {
                        $player = User::where('id', $bet->user_id)->lockForUpdate()->first();
                        if ($player) {
                            $opening = $player->balance;
                            $player->increment('balance', $win);
                            $closing = $player->fresh()->balance;

                            WingoTransaction::create([
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

            $adminNetProfit = $period->total_real_bets - $totalDistributed;

            $period->update([
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

        $bets = WingoBet::where('period_id', $periodId)->where('is_bot', false)->where('is_demo', false)->get();
        $payout = 0.00;

        foreach ($bets as $bet) {
            $payout += $this->evaluateBetOutcome($bet, $testNumber, $testColor, $testSize);
        }
        return $payout;
    }

    public function evaluateBetOutcome(WingoBet $bet, int $winNum, string $winColor, string $winSize): float {
        $amount = (float)$bet->total_amount;

        // নম্বর ম্যাচিং (৯ গুণ পেআউট)
        if ($bet->bet_type === 'number' && (int)$bet->selected_value === $winNum) {
            return $amount * 9;
        }

        // বিগ/স্মল ম্যাচিং (২ গুণ পেআউট)
        if ($bet->bet_type === 'size' && strtolower($bet->selected_value) === strtolower($winSize)) {
            return $amount * 2;
        }

        // কালার ম্যাচিং
        if ($bet->bet_type === 'color') {
            $sel = strtolower($bet->selected_value);
            if ($sel === 'violet' && in_array($winNum, [0, 5])) {
                return $amount * 4.5;
            }
            if ($sel === 'green') {
                if (in_array($winNum, [1, 3, 7, 9])) return $amount * 2;
                if ($winNum === 5) return $amount * 1.5;
            }
            if ($sel === 'red') {
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
