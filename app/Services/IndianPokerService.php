<?php

namespace App\Services;

use App\Models\IndianPokerSetting;
use App\Models\IndianPokerBet;
use App\Models\IndianPokerTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class IndianPokerService {
    private array $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    private array $suits = ['S', 'H', 'D', 'C'];

    public function getSettings(): IndianPokerSetting {
        return IndianPokerSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Indian Poker',
            'min_bet' => 1.00,
            'max_bet' => 50000.00,
            'demo_default_balance' => 1000.00,
            'pair_multiplier' => 1.00,
            'flush_multiplier' => 5.00,
            'straight_multiplier' => 10.00,
            'three_multiplier' => 50.00,
            'sf_multiplier' => 75.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'admin_profit_percentage' => 70,
        ]);
    }

    public function processBet(?User $user, array $data): array {
        $settings = $this->getSettings();
        $amount = (float)($data['amount'] ?? 10);
        $isDemo = (bool)($data['is_demo'] ?? false);

        if ($amount < (float)$settings->min_bet) {
            throw new Exception('Minimum bet is ' . number_format($settings->min_bet, 2));
        }
        if ($amount > (float)$settings->max_bet) {
            throw new Exception('Maximum bet is ' . number_format($settings->max_bet, 2));
        }

        if ($isDemo) {
            $shouldWin = (rand(1, 100) <= 35);
            $outcome = $this->generateCardsOutcome($shouldWin, $settings);
            $cards = $outcome['cards'];
            $handType = $outcome['hand_type'];
            $multiplier = $outcome['multiplier'];
            $isWin = $outcome['is_win'];
            $winAmount = $isWin ? round($amount * ($multiplier + 1), 2) : 0.00;

            return [
                'success' => true,
                'cards' => $cards,
                'hand_type' => $handType,
                'multiplier' => $multiplier,
                'is_win' => $isWin,
                'win_amount' => $winAmount,
                'is_demo' => true,
                'message' => $isWin ? "{$outcome['hand_name']}! You won " . number_format($winAmount, 2) : 'Better luck next time!'
            ];
        }

        if (!$user) {
            throw new Exception('Please log in to place real bets.');
        }

        return DB::transaction(function () use ($user, $settings, $amount) {
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser || $lockedUser->balance < $amount) {
                throw new Exception('Insufficient wallet balance. Please deposit to continue.');
            }

            $rigService = app(GameOutcomeRiggingService::class);
            $rigService->validatePlayerCanPlay($lockedUser, false);
            $rigAction = $rigService->determineSpinRigAction($lockedUser);

            $shouldWin = false;
            if ($rigAction === 'win') {
                $shouldWin = true;
            } elseif ($rigAction === 'lose') {
                $shouldWin = false;
            } else {
                $winChance = (int)($settings->win_chance_percentage ?? 30);
                if ($settings->control_mode === 'random') {
                    $shouldWin = (rand(1, 100) <= 25);
                } else {
                    $shouldWin = (rand(1, 100) <= $winChance);
                }
            }

            $balanceBefore = (float)$lockedUser->balance;
            $lockedUser->balance -= $amount;
            $lockedUser->save();

            $bet = IndianPokerBet::create([
                'user_id' => $lockedUser->id,
                'bet_amount' => $amount,
                'multiplier' => 0.00,
                'win_amount' => 0.00,
                'admin_profit' => 0.00,
                'card1' => null,
                'card2' => null,
                'card3' => null,
                'hand_type' => null,
                'status' => 'pending',
                'is_demo' => false
            ]);

            IndianPokerTransaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => (float)$lockedUser->balance
            ]);

            $outcome = $this->generateCardsOutcome($shouldWin, $settings);
            $cards = $outcome['cards'];
            $handType = $outcome['hand_type'];
            $multiplier = $outcome['multiplier'];
            $isWin = $outcome['is_win'];
            $winAmount = $isWin ? round($amount * ($multiplier + 1), 2) : 0.00;
            $adminProfit = round($amount - $winAmount, 2);

            if ($isWin && $winAmount > 0) {
                $balanceBeforeWin = (float)$lockedUser->balance;
                $lockedUser->balance += $winAmount;
                $lockedUser->save();

                IndianPokerTransaction::create([
                    'user_id' => $lockedUser->id,
                    'bet_id' => $bet->id,
                    'type' => 'credit_win',
                    'amount' => $winAmount,
                    'balance_before' => $balanceBeforeWin,
                    'balance_after' => (float)$lockedUser->balance
                ]);
            }

            $bet->update([
                'multiplier' => $multiplier,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'card1' => $cards[0],
                'card2' => $cards[1],
                'card3' => $cards[2],
                'hand_type' => $handType,
                'status' => $isWin ? 'won' : 'lost'
            ]);

            return [
                'success' => true,
                'bet_id' => $bet->id,
                'cards' => $cards,
                'hand_type' => $handType,
                'hand_name' => $outcome['hand_name'],
                'multiplier' => $multiplier,
                'win_amount' => $winAmount,
                'is_win' => $isWin,
                'new_balance' => (float)$lockedUser->balance,
                'is_demo' => false,
                'message' => $isWin ? "{$outcome['hand_name']}! You win " . number_format($winAmount, 2) : 'Better luck next time!'
            ];
        });
    }

    private function generateCardsOutcome(bool $shouldWin, IndianPokerSetting $settings): array {
        if ($shouldWin) {
            // Pick winning hand type based on probabilities
            $roll = rand(1, 100);
            if ($roll <= 65) {
                $handType = 'pair';
                $cards = $this->createPairHand();
                $multiplier = (float)$settings->pair_multiplier;
                $handName = 'Pair';
            } elseif ($roll <= 85) {
                $handType = 'flush';
                $cards = $this->createFlushHand();
                $multiplier = (float)$settings->flush_multiplier;
                $handName = 'Flush';
            } elseif ($roll <= 95) {
                $handType = 'straight';
                $cards = $this->createStraightHand();
                $multiplier = (float)$settings->straight_multiplier;
                $handName = 'Straight';
            } elseif ($roll <= 98) {
                $handType = 'three';
                $cards = $this->createThreeOfAKindHand();
                $multiplier = (float)$settings->three_multiplier;
                $handName = '3 of a Kind';
            } else {
                $handType = 'sf';
                $cards = $this->createStraightFlushHand();
                $multiplier = (float)$settings->sf_multiplier;
                $handName = 'Straight Flush';
            }
            return [
                'cards' => $cards,
                'hand_type' => $handType,
                'hand_name' => $handName,
                'multiplier' => $multiplier,
                'is_win' => true
            ];
        }

        // Losing hand (High card only)
        $cards = $this->createLosingHand();
        return [
            'cards' => $cards,
            'hand_type' => null,
            'hand_name' => 'High Card',
            'multiplier' => 0.00,
            'is_win' => false
        ];
    }

    private function createPairHand(): array {
        $rank = $this->ranks[array_rand($this->ranks)];
        $otherRanks = array_values(array_diff($this->ranks, [$rank]));
        $rank3 = $otherRanks[array_rand($otherRanks)];
        
        $suitsShuffled = $this->suits;
        shuffle($suitsShuffled);
        
        $cards = [$rank . $suitsShuffled[0], $rank . $suitsShuffled[1], $rank3 . $suitsShuffled[2]];
        shuffle($cards);
        return $cards;
    }

    private function createFlushHand(): array {
        $suit = $this->suits[array_rand($this->suits)];
        $ranksCopy = $this->ranks;
        shuffle($ranksCopy);
        // Ensure non-straight
        $c1 = $ranksCopy[0];
        $c2 = $ranksCopy[3];
        $c3 = $ranksCopy[7];
        return [$c1 . $suit, $c2 . $suit, $c3 . $suit];
    }

    private function createStraightHand(): array {
        $startIdx = rand(0, count($this->ranks) - 3);
        $suitsShuffled = $this->suits;
        shuffle($suitsShuffled);
        return [
            $this->ranks[$startIdx] . $suitsShuffled[0],
            $this->ranks[$startIdx + 1] . $suitsShuffled[1],
            $this->ranks[$startIdx + 2] . $suitsShuffled[2],
        ];
    }

    private function createThreeOfAKindHand(): array {
        $rank = $this->ranks[array_rand($this->ranks)];
        $suitsShuffled = $this->suits;
        shuffle($suitsShuffled);
        return [$rank . $suitsShuffled[0], $rank . $suitsShuffled[1], $rank . $suitsShuffled[2]];
    }

    private function createStraightFlushHand(): array {
        $suit = $this->suits[array_rand($this->suits)];
        $startIdx = rand(0, count($this->ranks) - 3);
        return [
            $this->ranks[$startIdx] . $suit,
            $this->ranks[$startIdx + 1] . $suit,
            $this->ranks[$startIdx + 2] . $suit,
        ];
    }

    private function createLosingHand(): array {
        $deck = [];
        foreach ($this->suits as $s) {
            foreach ($this->ranks as $r) {
                $deck[] = $r . $s;
            }
        }
        for ($attempts = 0; $attempts < 50; $attempts++) {
            shuffle($deck);
            $cards = array_slice($deck, 0, 3);
            if ($this->evaluateRawHand($cards) === null) {
                return $cards;
            }
        }
        return ['2S', '4H', '8D'];
    }

    private function getRankVal(string $card): int {
        $r = substr($card, 0, -1);
        if ($r === 'A') return 14;
        if ($r === 'K') return 13;
        if ($r === 'Q') return 12;
        if ($r === 'J') return 11;
        return (int)$r;
    }

    private function evaluateRawHand(array $cards): ?string {
        $vals = array_map([$this, 'getRankVal'], $cards);
        sort($vals);
        $suits = array_map(fn($c) => substr($c, -1), $cards);

        $isFlush = ($suits[0] === $suits[1] && $suits[1] === $suits[2]);
        $isStraight = (($vals[1] === $vals[0] + 1 && $vals[2] === $vals[1] + 1) || ($vals[0] === 2 && $vals[1] === 3 && $vals[2] === 14));
        $isThree = ($vals[0] === $vals[1] && $vals[1] === $vals[2]);
        $isPair = ($vals[0] === $vals[1] || $vals[1] === $vals[2] || $vals[0] === $vals[2]);

        if ($isStraight && $isFlush) return 'sf';
        if ($isThree) return 'three';
        if ($isStraight) return 'straight';
        if ($isFlush) return 'flush';
        if ($isPair) return 'pair';
        return null;
    }
}
