<?php

namespace App\Services;

use App\Models\UnderAndOver7Setting;
use App\Models\UnderAndOver7Bet;
use App\Models\UnderAndOver7Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class UnderAndOver7Service {

    public function getSettings(): UnderAndOver7Setting {
        return UnderAndOver7Setting::firstOrCreate(['id' => 1], [
            'game_name' => 'Under and Over 7',
            'min_bet' => 1.00,
            'max_bet' => 50000.00,
            'over_multiplier' => 2.30,
            'equal_multiplier' => 5.80,
            'under_multiplier' => 2.30,
            'demo_default_balance' => 100.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 45,
        ]);
    }

    public function processBet(?User $user, array $data): array {
        $settings = $this->getSettings();
        $choice = strtolower(trim($data['choice'] ?? ''));
        $amount = (float)($data['amount'] ?? 1);
        $isDemo = (bool)($data['is_demo'] ?? false);

        if (!in_array($choice, ['under', 'equal', 'over'])) {
            throw new Exception('Invalid choice. Choose Under, Equal (7), or Over.');
        }

        if ($amount < (float)$settings->min_bet) {
            throw new Exception('Minimum bet is ' . number_format($settings->min_bet, 2));
        }

        if ($amount > (float)$settings->max_bet) {
            throw new Exception('Maximum bet is ' . number_format($settings->max_bet, 2));
        }

        $multiplier = ($choice === 'equal') ? (float)$settings->equal_multiplier : (($choice === 'over') ? (float)$settings->over_multiplier : (float)$settings->under_multiplier);

        if ($isDemo) {
            // Demo mode logic
            $diceResult = $this->generateDiceOutcome($choice, $settings, true);
            $die1 = $diceResult['die1'];
            $die2 = $diceResult['die2'];
            $sum = $die1 + $die2;
            $isWin = $this->checkWin($choice, $sum);
            $winAmount = $isWin ? round($amount * $multiplier, 2) : 0.00;

            return [
                'success' => true,
                'die1' => $die1,
                'die2' => $die2,
                'sum' => $sum,
                'choice' => $choice,
                'is_win' => $isWin,
                'multiplier' => $multiplier,
                'win_amount' => $winAmount,
                'is_demo' => true,
                'message' => $isWin ? 'Congratulations! You won!' : 'Better luck next time!'
            ];
        }

        // Real money bet
        if (!$user) {
            throw new Exception('Please log in to place real bets.');
        }

        return DB::transaction(function () use ($user, $settings, $choice, $amount, $multiplier) {
            // Lock user record
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();

            if ($lockedUser->balance < $amount) {
                throw new Exception('Insufficient wallet balance. Please deposit to continue.');
            }

            $balanceBefore = (float)$lockedUser->balance;
            $lockedUser->balance -= $amount;
            $lockedUser->save();

            // Create initial bet record
            $bet = UnderAndOver7Bet::create([
                'user_id' => $lockedUser->id,
                'bet_choice' => $choice,
                'bet_amount' => $amount,
                'multiplier' => $multiplier,
                'die1' => 1,
                'die2' => 1,
                'sum' => 2,
                'win_amount' => 0.00,
                'status' => 'pending',
                'is_demo' => false
            ]);

            // Debit transaction
            UnderAndOver7Transaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => (float)$lockedUser->balance
            ]);

            // Determine outcome
            $diceResult = $this->generateDiceOutcome($choice, $settings, false);
            $die1 = $diceResult['die1'];
            $die2 = $diceResult['die2'];
            $sum = $die1 + $die2;
            $isWin = $this->checkWin($choice, $sum);
            $winAmount = $isWin ? round($amount * $multiplier, 2) : 0.00;

            if ($isWin && $winAmount > 0) {
                $balanceBeforeWin = (float)$lockedUser->balance;
                $lockedUser->balance += $winAmount;
                $lockedUser->save();

                UnderAndOver7Transaction::create([
                    'user_id' => $lockedUser->id,
                    'bet_id' => $bet->id,
                    'type' => 'credit_win',
                    'amount' => $winAmount,
                    'balance_before' => $balanceBeforeWin,
                    'balance_after' => (float)$lockedUser->balance
                ]);
            }

            $bet->update([
                'die1' => $die1,
                'die2' => $die2,
                'sum' => $sum,
                'win_amount' => $winAmount,
                'status' => $isWin ? 'won' : 'lost'
            ]);

            return [
                'success' => true,
                'bet_id' => $bet->id,
                'die1' => $die1,
                'die2' => $die2,
                'sum' => $sum,
                'choice' => $choice,
                'is_win' => $isWin,
                'multiplier' => $multiplier,
                'win_amount' => $winAmount,
                'new_balance' => (float)$lockedUser->balance,
                'is_demo' => false,
                'message' => $isWin ? 'Congratulations! You won!' : 'Better luck next time!'
            ];
        });
    }

    private function checkWin(string $choice, int $sum): bool {
        if ($choice === 'over') {
            return $sum > 7;
        } elseif ($choice === 'equal') {
            return $sum === 7;
        } elseif ($choice === 'under') {
            return $sum < 7;
        }
        return false;
    }

    private function generateDiceOutcome(string $choice, UnderAndOver7Setting $settings, bool $isDemo): array {
        $mode = $settings->control_mode ?? 'house_profit';
        $winRate = (int)($settings->win_chance_percentage ?? 45);

        if ($isDemo) {
            // In demo mode, give slightly higher excitement (50% win chance)
            $shouldWin = (rand(1, 100) <= 52);
        } else {
            if ($mode === 'random') {
                $die1 = rand(1, 6);
                $die2 = rand(1, 6);
                return ['die1' => $die1, 'die2' => $die2];
            }
            $shouldWin = (rand(1, 100) <= $winRate);
        }

        // Generate matching combination based on shouldWin
        if ($shouldWin) {
            return $this->getWinningDice($choice);
        } else {
            return $this->getLosingDice($choice);
        }
    }

    private function getWinningDice(string $choice): array {
        if ($choice === 'over') {
            // Sum must be 8..12
            $winningPairs = [];
            for ($d1 = 1; $d1 <= 6; $d1++) {
                for ($d2 = 1; $d2 <= 6; $d2++) {
                    if ($d1 + $d2 > 7) {
                        $winningPairs[] = ['die1' => $d1, 'die2' => $d2];
                    }
                }
            }
            return $winningPairs[array_rand($winningPairs)];
        } elseif ($choice === 'equal') {
            // Sum must be exactly 7
            $winningPairs = [
                ['die1' => 1, 'die2' => 6],
                ['die1' => 2, 'die2' => 5],
                ['die1' => 3, 'die2' => 4],
                ['die1' => 4, 'die2' => 3],
                ['die1' => 5, 'die2' => 2],
                ['die1' => 6, 'die2' => 1],
            ];
            return $winningPairs[array_rand($winningPairs)];
        } else {
            // Under: Sum must be 2..6
            $winningPairs = [];
            for ($d1 = 1; $d1 <= 6; $d1++) {
                for ($d2 = 1; $d2 <= 6; $d2++) {
                    if ($d1 + $d2 < 7) {
                        $winningPairs[] = ['die1' => $d1, 'die2' => $d2];
                    }
                }
            }
            return $winningPairs[array_rand($winningPairs)];
        }
    }

    private function getLosingDice(string $choice): array {
        if ($choice === 'over') {
            // Sum must be <= 7
            $losingPairs = [];
            for ($d1 = 1; $d1 <= 6; $d1++) {
                for ($d2 = 1; $d2 <= 6; $d2++) {
                    if ($d1 + $d2 <= 7) {
                        $losingPairs[] = ['die1' => $d1, 'die2' => $d2];
                    }
                }
            }
            return $losingPairs[array_rand($losingPairs)];
        } elseif ($choice === 'equal') {
            // Sum must NOT be 7
            $losingPairs = [];
            for ($d1 = 1; $d1 <= 6; $d1++) {
                for ($d2 = 1; $d2 <= 6; $d2++) {
                    if ($d1 + $d2 !== 7) {
                        $losingPairs[] = ['die1' => $d1, 'die2' => $d2];
                    }
                }
            }
            return $losingPairs[array_rand($losingPairs)];
        } else {
            // Under: Sum must be >= 7
            $losingPairs = [];
            for ($d1 = 1; $d1 <= 6; $d1++) {
                for ($d2 = 1; $d2 <= 6; $d2++) {
                    if ($d1 + $d2 >= 7) {
                        $losingPairs[] = ['die1' => $d1, 'die2' => $d2];
                    }
                }
            }
            return $losingPairs[array_rand($losingPairs)];
        }
    }
}
