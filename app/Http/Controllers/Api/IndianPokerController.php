<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\GameSetting;
use App\Models\BetHistory;
use App\Models\IndianPokerSetting;
use App\Models\IndianPokerBet;
use App\Models\IndianPokerTransaction;

class IndianPokerController extends Controller
{
    // কার্ডের ডেক (৫২টি কার্ড)
    private $suits = ['S', 'H', 'D', 'C']; // Spade, Heart, Diamond, Club
    private $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]; // 11=J, 12=Q, 13=K, 14=A

    public function placeBet(Request $request)
    {
        $request->validate([
            'bet_amount' => 'required|numeric|min:1',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'অননুমোদিত ব্যবহারকারী। অনুগ্রহ করে লগইন করুন।'], 401);
        }

        $betAmount = (float) $request->bet_amount;

        if ($user->balance < $betAmount) {
            return response()->json(['success' => false, 'message' => 'অপর্যাপ্ত ব্যালেন্স'], 400);
        }

        return DB::transaction(function () use ($user, $betAmount) {
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if ($lockedUser->balance < $betAmount) {
                return response()->json(['success' => false, 'message' => 'অপর্যাপ্ত ব্যালেন্স'], 400);
            }

            // ১. ব্যালেন্স কাটা
            $balanceBefore = (float)$lockedUser->balance;
            $lockedUser->decrement('balance', $betAmount);
            $lockedUser->refresh();

            // ২. অ্যাডমিন সেটিংস থেকে প্রফিট পলিসি আনা (ডিফল্ট: অ্যাডমিন ৭০% লাভ, ইউজার ৩০% উইন)
            $userWinRate = 30;
            try {
                if (Schema::hasTable('game_settings')) {
                    $setting = GameSetting::firstOrCreate(
                        ['game_key' => 'indian_poker'],
                        ['target_profit' => 70, 'user_win_rate' => 30]
                    );
                    $userWinRate = (float)($setting->user_win_rate ?? 30);
                } elseif (Schema::hasTable('indian_poker_settings')) {
                    $pokerSetting = IndianPokerSetting::first();
                    if ($pokerSetting) {
                        $userWinRate = (float)($pokerSetting->win_chance_percentage ?? 30);
                    }
                }
            } catch (\Throwable $e) {
                $userWinRate = 30;
            }

            $isWinningRound = (mt_rand(1, 100) <= $userWinRate);

            // ৩. কার্ড জেনারেশন (অ্যাডমিন কন্ট্রোল অনুযায়ী)
            $cards = $this->generateHand($isWinningRound);
            $evaluation = $this->evaluateCards($cards);

            $payout = $betAmount * $evaluation['multiplier'];
            $isWin = $evaluation['multiplier'] > 0;

            // ৪. উইন হলে ইউজারের একাউন্টে ব্যালেন্স যোগ
            if ($isWin && $payout > 0) {
                $lockedUser->increment('balance', $payout);
                $lockedUser->refresh();
            }

            // কার্ড কোড রূপান্তর (যেমন: 14 + S => 'AS', 10 + D => '10D')
            $cardCodes = array_map(function ($c) {
                $r = $c['rank'];
                $rankStr = ($r === 14) ? 'A' : (($r === 13) ? 'K' : (($r === 12) ? 'Q' : (($r === 11) ? 'J' : (string)$r)));
                return $rankStr . $c['suit'];
            }, $cards);

            // ৫. বেটিং হিস্ট্রি সেভ করা
            try {
                if (Schema::hasTable('bet_histories')) {
                    BetHistory::create([
                        'user_id' => $lockedUser->id,
                        'game_key' => 'indian_poker',
                        'bet_amount' => $betAmount,
                        'multiplier' => $evaluation['multiplier'],
                        'payout' => $payout,
                        'result_data' => [
                            'cards' => $cards,
                            'card_codes' => $cardCodes,
                            'hand_type' => $evaluation['hand_type']
                        ],
                        'status' => $isWin ? 'win' : 'loss'
                    ]);
                }

                if (Schema::hasTable('indian_poker_bets')) {
                    $bet = IndianPokerBet::create([
                        'user_id' => $lockedUser->id,
                        'bet_amount' => $betAmount,
                        'multiplier' => $evaluation['multiplier'],
                        'win_amount' => $payout,
                        'admin_profit' => round($betAmount - $payout, 2),
                        'card1' => $cardCodes[0] ?? null,
                        'card2' => $cardCodes[1] ?? null,
                        'card3' => $cardCodes[2] ?? null,
                        'hand_type' => strtolower(str_replace(' ', '_', $evaluation['hand_type'])),
                        'status' => $isWin ? 'won' : 'lost',
                        'is_demo' => false
                    ]);

                    if (Schema::hasTable('indian_poker_transactions')) {
                        IndianPokerTransaction::create([
                            'user_id' => $lockedUser->id,
                            'bet_id' => $bet->id,
                            'type' => 'debit_bet',
                            'amount' => $betAmount,
                            'balance_before' => $balanceBefore,
                            'balance_after' => $balanceBefore - $betAmount
                        ]);

                        if ($isWin && $payout > 0) {
                            IndianPokerTransaction::create([
                                'user_id' => $lockedUser->id,
                                'bet_id' => $bet->id,
                                'type' => 'credit_win',
                                'amount' => $payout,
                                'balance_before' => $balanceBefore - $betAmount,
                                'balance_after' => (float)$lockedUser->balance
                            ]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Log or continue silently to ensure game response
            }

            return response()->json([
                'success' => true,
                'is_win' => $isWin,
                'cards' => $cards, // যেমন: [['rank' => 7, 'suit' => 'S'], ...]
                'card_codes' => $cardCodes, // যেমন: ['7S', '8H', '10D']
                'hand_type' => $evaluation['hand_type'],
                'multiplier' => $evaluation['multiplier'],
                'payout' => $payout,
                'win_amount' => $payout,
                'current_balance' => (float) $lockedUser->balance,
                'new_balance' => (float) $lockedUser->balance
            ]);
        });
    }

    private function generateHand($isWin)
    {
        if ($isWin) {
            // উইন ক্যাটাগরি ঠিক করা (Weighted Probability)
            $rand = mt_rand(1, 1000);
            if ($rand <= 850) {
                return $this->buildPairHand();           // x1 (বেশি ভাগ সময় এটি দিয়ে ইউজারকে সন্তুষ্ট রাখা হয়)
            } elseif ($rand <= 950) {
                return $this->buildFlushHand();          // x5
            } elseif ($rand <= 990) {
                return $this->buildStraightHand();       // x10
            } elseif ($rand <= 999) {
                return $this->buildThreeOfKindHand();    // x50
            } else {
                return $this->buildStraightFlushHand();  // x75
            }
        } else {
            // বাধ্যতামূলক হারানো (High Card তৈরি করা)
            return $this->buildLosingHand();
        }
    }

    private function buildLosingHand()
    {
        do {
            $ranks = array_rand(array_flip($this->ranks), 3);
            sort($ranks);
            $suits = [$this->suits[array_rand($this->suits)], $this->suits[array_rand($this->suits)], $this->suits[array_rand($this->suits)]];
            
            $isFlush = (count(array_unique($suits)) === 1);
            $isStraight = ($ranks[0] + 1 == $ranks[1] && $ranks[1] + 1 == $ranks[2]) || ($ranks == [2, 3, 14]);
            $isPair = (count(array_unique($ranks)) < 3);
        } while ($isFlush || $isStraight || $isPair);

        return [
            ['rank' => $ranks[0], 'suit' => $suits[0]],
            ['rank' => $ranks[1], 'suit' => $suits[1]],
            ['rank' => $ranks[2], 'suit' => $suits[2]],
        ];
    }

    private function buildPairHand()
    {
        $pairRank = $this->ranks[array_rand($this->ranks)];
        $otherRank = $this->ranks[array_rand(array_diff($this->ranks, [$pairRank]))];
        $suits = array_rand(array_flip($this->suits), 2);
        $thirdSuit = $this->suits[array_rand($this->suits)];

        return [
            ['rank' => $pairRank, 'suit' => $suits[0]],
            ['rank' => $pairRank, 'suit' => $suits[1]],
            ['rank' => $otherRank, 'suit' => $thirdSuit],
        ];
    }

    private function buildFlushHand()
    {
        $suit = $this->suits[array_rand($this->suits)];
        do {
            $ranks = array_rand(array_flip($this->ranks), 3);
            sort($ranks);
            $isStraight = ($ranks[0] + 1 == $ranks[1] && $ranks[1] + 1 == $ranks[2]) || ($ranks == [2, 3, 14]);
        } while ($isStraight);

        return [
            ['rank' => $ranks[0], 'suit' => $suit],
            ['rank' => $ranks[1], 'suit' => $suit],
            ['rank' => $ranks[2], 'suit' => $suit],
        ];
    }

    private function buildStraightHand()
    {
        $start = mt_rand(2, 12);
        $ranks = [$start, $start + 1, $start + 2];
        // ভিন্ন স্যুট যাতে ফ্লাশ না হয়
        return [
            ['rank' => $ranks[0], 'suit' => 'S'],
            ['rank' => $ranks[1], 'suit' => 'H'],
            ['rank' => $ranks[2], 'suit' => 'D'],
        ];
    }

    private function buildThreeOfKindHand()
    {
        $rank = $this->ranks[array_rand($this->ranks)];
        return [
            ['rank' => $rank, 'suit' => 'S'],
            ['rank' => $rank, 'suit' => 'H'],
            ['rank' => $rank, 'suit' => 'D'],
        ];
    }

    private function buildStraightFlushHand()
    {
        $start = mt_rand(2, 12);
        $suit = $this->suits[array_rand($this->suits)];
        return [
            ['rank' => $start, 'suit' => $suit],
            ['rank' => $start + 1, 'suit' => $suit],
            ['rank' => $start + 2, 'suit' => $suit],
        ];
    }

    private function evaluateCards($cards)
    {
        $ranks = array_column($cards, 'rank');
        $suits = array_column($cards, 'suit');
        sort($ranks);

        $isFlush = (count(array_unique($suits)) === 1);
        $isStraight = ($ranks[0] + 1 == $ranks[1] && $ranks[1] + 1 == $ranks[2]) || ($ranks == [2, 3, 14]);
        $counts = array_count_values($ranks);

        if ($isStraight && $isFlush) return ['hand_type' => 'Straight Flush', 'multiplier' => 75];
        if (in_array(3, $counts)) return ['hand_type' => '3 of a Kind', 'multiplier' => 50];
        if ($isStraight) return ['hand_type' => 'Straight', 'multiplier' => 10];
        if ($isFlush) return ['hand_type' => 'Flush', 'multiplier' => 5];
        if (in_array(2, $counts)) return ['hand_type' => 'Pair', 'multiplier' => 1];

        return ['hand_type' => 'High Card', 'multiplier' => 0];
    }
}
