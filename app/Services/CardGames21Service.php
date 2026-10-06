<?php

namespace App\Services;

use App\Models\CardGames21Setting;
use App\Models\CardGames21Bet;
use App\Models\CardGames21Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class CardGames21Service {
    private array $ranks = ['6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    private array $suits = ['D', 'S', 'H', 'C'];
    private array $rankValues = [
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 2,
        'Q' => 3,
        'K' => 4,
        'A' => 11
    ];

    public function getSettings(): CardGames21Setting {
        return CardGames21Setting::firstOrCreate(['id' => 1], [
            'game_name' => 'Card Games 21',
            'min_bet' => 1.00,
            'max_bet' => 50000.00,
            'demo_default_balance' => 1000.00,
            'win_multiplier' => 2.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'admin_profit_percentage' => 70,
        ]);
    }

    public function getCardValue(string $card): int {
        $rank = substr($card, 0, -1);
        return $this->rankValues[$rank] ?? 0;
    }

    public function calculateHandScore(array $cards): int {
        if (count($cards) === 2 && substr($cards[0], 0, -1) === 'A' && substr($cards[1], 0, -1) === 'A') {
            return 21; // Two Aces rule = 21
        }
        $score = 0;
        foreach ($cards as $card) {
            $score += $this->getCardValue($card);
        }
        return $score;
    }

    private function generateDeck(): array {
        $deck = [];
        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $deck[] = $rank . $suit;
            }
        }
        shuffle($deck);
        return $deck;
    }

    public function startRound(?User $user, array $data): array {
        $settings = $this->getSettings();
        $amount = (float)($data['amount'] ?? 20);
        $isDemo = (bool)($data['is_demo'] ?? false);

        if ($amount < (float)$settings->min_bet) {
            throw new Exception('Minimum bet is ' . number_format($settings->min_bet, 2));
        }
        if ($amount > (float)$settings->max_bet) {
            throw new Exception('Maximum bet is ' . number_format($settings->max_bet, 2));
        }

        if ($isDemo) {
            $deck = $this->generateDeck();
            $playerCards = [array_pop($deck), array_pop($deck)];
            $dealerCards = [array_pop($deck)];

            $playerScore = $this->calculateHandScore($playerCards);
            $dealerScore = $this->calculateHandScore($dealerCards);

            // Check instant 21 / Golden 21
            $isInstant21 = ($playerScore === 21);
            $status = $isInstant21 ? 'won' : 'pending';
            $winAmount = $isInstant21 ? round($amount * $settings->win_multiplier, 2) : 0.00;

            return [
                'success' => true,
                'bet_id' => 'demo_' . uniqid(),
                'player_cards' => $playerCards,
                'dealer_cards' => $dealerCards,
                'remaining_deck' => $deck,
                'player_score' => $playerScore,
                'dealer_score' => $dealerScore,
                'status' => $status,
                'win_amount' => $winAmount,
                'is_demo' => true,
                'message' => $isInstant21 ? '21! Golden Win!' : 'Hit or Stand?'
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

            $balanceBefore = (float)$lockedUser->balance;
            $lockedUser->balance -= $amount;
            $lockedUser->save();

            $deck = $this->generateDeck();
            $playerCards = [array_pop($deck), array_pop($deck)];
            $dealerCards = [array_pop($deck)];

            $playerScore = $this->calculateHandScore($playerCards);
            $dealerScore = $this->calculateHandScore($dealerCards);

            $isInstant21 = ($playerScore === 21);
            $status = $isInstant21 ? 'won' : 'pending';
            $winAmount = $isInstant21 ? round($amount * $settings->win_multiplier, 2) : 0.00;
            $adminProfit = $isInstant21 ? round($amount - $winAmount, 2) : 0.00;

            $bet = CardGames21Bet::create([
                'user_id' => $lockedUser->id,
                'bet_amount' => $amount,
                'multiplier' => $settings->win_multiplier,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'player_cards' => $playerCards,
                'dealer_cards' => $dealerCards,
                'remaining_deck' => $deck,
                'player_score' => $playerScore,
                'dealer_score' => $dealerScore,
                'status' => $status,
                'result_message' => $isInstant21 ? '21! Golden Win!' : null,
                'is_demo' => false
            ]);

            CardGames21Transaction::create([
                'user_id' => $lockedUser->id,
                'bet_id' => $bet->id,
                'type' => 'debit_bet',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => (float)$lockedUser->balance
            ]);

            if ($isInstant21) {
                $balanceBeforeWin = (float)$lockedUser->balance;
                $lockedUser->balance += $winAmount;
                $lockedUser->save();

                CardGames21Transaction::create([
                    'user_id' => $lockedUser->id,
                    'bet_id' => $bet->id,
                    'type' => 'credit_win',
                    'amount' => $winAmount,
                    'balance_before' => $balanceBeforeWin,
                    'balance_after' => (float)$lockedUser->balance
                ]);
            }

            return [
                'success' => true,
                'bet_id' => $bet->id,
                'player_cards' => $playerCards,
                'dealer_cards' => $dealerCards,
                'player_score' => $playerScore,
                'dealer_score' => $dealerScore,
                'status' => $status,
                'win_amount' => $winAmount,
                'new_balance' => (float)$lockedUser->balance,
                'is_demo' => false,
                'message' => $isInstant21 ? '21! Golden Win!' : 'Hit or Stand?'
            ];
        });
    }

    public function hit(?User $user, array $data): array {
        $isDemo = (bool)($data['is_demo'] ?? false);
        $betId = $data['bet_id'] ?? null;

        if ($isDemo) {
            $playerCards = $data['player_cards'] ?? [];
            $dealerCards = $data['dealer_cards'] ?? [];
            $deck = $data['remaining_deck'] ?? [];
            $amount = (float)($data['amount'] ?? 20);

            if (empty($deck)) {
                $deck = $this->generateDeck();
            }

            $newCard = array_pop($deck);
            $playerCards[] = $newCard;
            $playerScore = $this->calculateHandScore($playerCards);
            $dealerScore = $this->calculateHandScore($dealerCards);

            if ($playerScore > 21) {
                return [
                    'success' => true,
                    'new_card' => $newCard,
                    'player_cards' => $playerCards,
                    'dealer_cards' => $dealerCards,
                    'player_score' => $playerScore,
                    'dealer_score' => $dealerScore,
                    'remaining_deck' => $deck,
                    'status' => 'busted',
                    'win_amount' => 0.00,
                    'is_demo' => true,
                    'message' => 'Bust! Over 21'
                ];
            } elseif ($playerScore === 21) {
                // Auto stand / instant win
                return $this->stand($user, [
                    'bet_id' => $betId,
                    'is_demo' => true,
                    'amount' => $amount,
                    'player_cards' => $playerCards,
                    'dealer_cards' => $dealerCards,
                    'remaining_deck' => $deck
                ]);
            }

            return [
                'success' => true,
                'new_card' => $newCard,
                'player_cards' => $playerCards,
                'dealer_cards' => $dealerCards,
                'player_score' => $playerScore,
                'dealer_score' => $dealerScore,
                'remaining_deck' => $deck,
                'status' => 'pending',
                'win_amount' => 0.00,
                'is_demo' => true,
                'message' => 'Hit or Stand?'
            ];
        }

        if (!$user) {
            throw new Exception('Please log in.');
        }

        return DB::transaction(function () use ($user, $betId) {
            $bet = CardGames21Bet::where('id', $betId)->where('user_id', $user->id)->lockForUpdate()->first();
            if (!$bet || $bet->status !== 'pending') {
                throw new Exception('Invalid game state or round already finished.');
            }

            $deck = $bet->remaining_deck ?: $this->generateDeck();
            $playerCards = $bet->player_cards ?: [];
            $dealerCards = $bet->dealer_cards ?: [];

            $newCard = array_pop($deck);
            $playerCards[] = $newCard;
            $playerScore = $this->calculateHandScore($playerCards);
            $dealerScore = $this->calculateHandScore($dealerCards);

            if ($playerScore > 21) {
                $bet->update([
                    'player_cards' => $playerCards,
                    'player_score' => $playerScore,
                    'remaining_deck' => $deck,
                    'status' => 'busted',
                    'admin_profit' => $bet->bet_amount,
                    'result_message' => 'Busted over 21'
                ]);

                return [
                    'success' => true,
                    'new_card' => $newCard,
                    'player_cards' => $playerCards,
                    'dealer_cards' => $dealerCards,
                    'player_score' => $playerScore,
                    'dealer_score' => $dealerScore,
                    'status' => 'busted',
                    'win_amount' => 0.00,
                    'is_demo' => false,
                    'message' => 'Bust! Over 21'
                ];
            }

            $bet->update([
                'player_cards' => $playerCards,
                'player_score' => $playerScore,
                'remaining_deck' => $deck,
            ]);

            return [
                'success' => true,
                'new_card' => $newCard,
                'player_cards' => $playerCards,
                'dealer_cards' => $dealerCards,
                'player_score' => $playerScore,
                'dealer_score' => $dealerScore,
                'status' => 'pending',
                'win_amount' => 0.00,
                'is_demo' => false,
                'message' => 'Hit or Stand?'
            ];
        });
    }

    public function stand(?User $user, array $data): array {
        $isDemo = (bool)($data['is_demo'] ?? false);
        $betId = $data['bet_id'] ?? null;
        $settings = $this->getSettings();

        if ($isDemo) {
            $playerCards = $data['player_cards'] ?? [];
            $dealerCards = $data['dealer_cards'] ?? [];
            $deck = $data['remaining_deck'] ?? [];
            $amount = (float)($data['amount'] ?? 20);

            $playerScore = $this->calculateHandScore($playerCards);
            $dealerScore = $this->calculateHandScore($dealerCards);

            // Dealer draws until 17 or higher
            while ($dealerScore < 17 && !empty($deck)) {
                $card = array_pop($deck);
                $dealerCards[] = $card;
                $dealerScore = $this->calculateHandScore($dealerCards);
            }

            $status = 'lost';
            $winAmount = 0.00;
            $msg = 'Dealer won';

            if ($dealerScore > 21 || $playerScore > $dealerScore) {
                $status = 'won';
                $winAmount = round($amount * $settings->win_multiplier, 2);
                $msg = 'You won!';
            } elseif ($playerScore === $dealerScore) {
                $status = 'draw';
                $winAmount = $amount;
                $msg = 'Draw!';
            }

            return [
                'success' => true,
                'player_cards' => $playerCards,
                'dealer_cards' => $dealerCards,
                'player_score' => $playerScore,
                'dealer_score' => $dealerScore,
                'status' => $status,
                'win_amount' => $winAmount,
                'is_demo' => true,
                'message' => $msg
            ];
        }

        if (!$user) {
            throw new Exception('Please log in.');
        }

        return DB::transaction(function () use ($user, $betId, $settings) {
            $bet = CardGames21Bet::where('id', $betId)->where('user_id', $user->id)->lockForUpdate()->first();
            if (!$bet || $bet->status !== 'pending') {
                throw new Exception('Invalid game state or round already finished.');
            }

            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            $deck = $bet->remaining_deck ?: $this->generateDeck();
            $playerCards = $bet->player_cards ?: [];
            $dealerCards = $bet->dealer_cards ?: [];

            $playerScore = $this->calculateHandScore($playerCards);
            $dealerScore = $this->calculateHandScore($dealerCards);

            $rigService = app(GameOutcomeRiggingService::class);
            $rigAction = $rigService->determineSpinRigAction($lockedUser);

            $shouldWin = false;
            if ($rigAction === 'win') {
                $shouldWin = true;
            } elseif ($rigAction === 'lose') {
                $shouldWin = false;
            } else {
                $winChance = (int)($settings->win_chance_percentage ?? 30);
                $shouldWin = (rand(1, 100) <= $winChance);
            }

            // Play dealer hand
            while ($dealerScore < 17 && !empty($deck)) {
                $card = array_pop($deck);
                $dealerCards[] = $card;
                $dealerScore = $this->calculateHandScore($dealerCards);
            }

            // Adjust dealer result if rigged
            if ($shouldWin && $dealerScore >= $playerScore && $dealerScore <= 21) {
                // Make dealer bust
                $dealerCards[] = 'K' . $this->suits[array_rand($this->suits)];
                $dealerScore = $this->calculateHandScore($dealerCards);
            }

            $status = 'lost';
            $winAmount = 0.00;
            $msg = 'Dealer has more points';

            if ($dealerScore > 21) {
                $status = 'won';
                $winAmount = round($bet->bet_amount * $settings->win_multiplier, 2);
                $msg = 'Dealer Busted! You win!';
            } elseif ($playerScore > $dealerScore) {
                $status = 'won';
                $winAmount = round($bet->bet_amount * $settings->win_multiplier, 2);
                $msg = 'You won!';
            } elseif ($playerScore === $dealerScore) {
                $status = 'draw';
                $winAmount = (float)$bet->bet_amount;
                $msg = 'Draw - Bet refunded!';
            }

            $adminProfit = round($bet->bet_amount - $winAmount, 2);

            if ($winAmount > 0) {
                $balanceBeforeWin = (float)$lockedUser->balance;
                $lockedUser->balance += $winAmount;
                $lockedUser->save();

                CardGames21Transaction::create([
                    'user_id' => $lockedUser->id,
                    'bet_id' => $bet->id,
                    'type' => $status === 'draw' ? 'refund_draw' : 'credit_win',
                    'amount' => $winAmount,
                    'balance_before' => $balanceBeforeWin,
                    'balance_after' => (float)$lockedUser->balance
                ]);
            }

            $bet->update([
                'dealer_cards' => $dealerCards,
                'dealer_score' => $dealerScore,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'status' => $status,
                'result_message' => $msg
            ]);

            return [
                'success' => true,
                'player_cards' => $playerCards,
                'dealer_cards' => $dealerCards,
                'player_score' => $playerScore,
                'dealer_score' => $dealerScore,
                'status' => $status,
                'win_amount' => $winAmount,
                'new_balance' => (float)$lockedUser->balance,
                'is_demo' => false,
                'message' => $msg
            ];
        });
    }
}
