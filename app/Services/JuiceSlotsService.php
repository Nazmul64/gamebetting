<?php

namespace App\Services;

use App\Models\JuiceSlotsSetting;
use App\Models\JuiceSlotsSpin;
use App\Models\JuiceSlotsTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class JuiceSlotsService
{
    protected const KEYS = ['straw', 'ban', 'grape', 'juice', 'cup', 'egg', 'org'];
    protected const PAYTABLE = [
        'cup'   => [3 => 20, 4 => 100, 5 => 500], // Trophy / Cup
        'juice' => [3 => 15, 4 => 75,  5 => 300], // Juice (Wild)
        'grape' => [3 => 8,  4 => 30,  5 => 120], // Grapes
        'straw' => [3 => 6,  4 => 20,  5 => 80],  // Strawberry
        'org'   => [3 => 5,  4 => 15,  5 => 60],  // Orange
        'ban'   => [3 => 4,  4 => 12,  5 => 40],  // Banana
        'egg'   => [3 => 3,  4 => 10,  5 => 30],  // Eggplant
    ];

    protected const PAYLINES = [
        [ [0,0], [1,0], [2,0], [3,0], [4,0] ], // Line 1: Top
        [ [0,1], [1,1], [2,1], [3,1], [4,1] ], // Line 2: Middle
        [ [0,2], [1,2], [2,2], [3,2], [4,2] ], // Line 3: Bottom
        [ [0,0], [1,1], [2,2], [3,1], [4,0] ], // Line 4: V shape
        [ [0,2], [1,1], [2,0], [3,1], [4,2] ], // Line 5: Inverted V
        [ [0,0], [1,0], [2,1], [3,2], [4,2] ], // Line 6
        [ [0,2], [1,2], [2,1], [3,0], [4,0] ], // Line 7
        [ [0,1], [1,0], [2,0], [3,0], [4,1] ], // Line 8
        [ [0,1], [1,2], [2,2], [3,2], [4,1] ], // Line 9
        [ [0,0], [1,1], [2,0], [3,1], [4,0] ], // Line 10
    ];

    public function getSettings(): JuiceSlotsSetting
    {
        return JuiceSlotsSetting::firstOrCreate([], [
            'control_mode' => 'house_profit',
            'house_profit_percentage' => 70.00,
            'rtp_percentage' => 30.00,
            'win_chance_percentage' => 30.00,
            'min_bet' => 10.00,
            'max_bet' => 50000.00,
            'max_payout_per_spin' => 1000000.00,
            'is_active' => true,
        ]);
    }

    public function spin(User $user, float $betAmount, bool $isDemo = false): array
    {
        $settings = $this->getSettings();

        if (!$settings->is_active) {
            throw new Exception("Juice Slots is currently under scheduled maintenance.");
        }

        if ($betAmount < $settings->min_bet || $betAmount > $settings->max_bet) {
            throw new Exception("Bet amount must be between ৳{$settings->min_bet} and ৳{$settings->max_bet}.");
        }

        if (!$isDemo) {
            GameOutcomeRiggingService::validatePlayerCanPlay($user, 'juice_slots');
        }

        $balanceBefore = (float) $user->balance;
        if (!$isDemo && $balanceBefore < $betAmount) {
            throw new Exception("Insufficient account balance to place bet.");
        }

        $targetOutcome = null;
        if (!$isDemo) {
            $rigAction = GameOutcomeRiggingService::determineSpinRigAction($user, 'juice_slots');
            if ($rigAction === 'force_win') {
                $targetOutcome = 'win';
            } elseif ($rigAction === 'force_lose') {
                $targetOutcome = 'lose';
            }
        }

        if ($targetOutcome === null) {
            $winChance = $settings->win_chance_percentage ?? 30.0;
            $randVal = mt_rand(1, 10000) / 100.0;
            $targetOutcome = ($randVal <= $winChance) ? 'win' : 'lose';
        }

        $bestGrid = null;
        $bestResult = null;
        $attempts = 0;

        while ($attempts < 30) {
            $attempts++;
            $grid = $this->generateGrid();
            $eval = $this->evaluateGrid($grid, $betAmount);

            if ($targetOutcome === 'win' && $eval['win_amount'] > 0) {
                $bestGrid = $grid;
                $bestResult = $eval;
                break;
            } elseif ($targetOutcome === 'lose' && $eval['win_amount'] == 0) {
                $bestGrid = $grid;
                $bestResult = $eval;
                break;
            }

            if ($bestGrid === null) {
                $bestGrid = $grid;
                $bestResult = $eval;
            }
        }

        $winAmount = min($bestResult['win_amount'], (float)$settings->max_payout_per_spin);
        $multiplier = $betAmount > 0 ? round($winAmount / $betAmount, 2) : 0;

        $spinRecord = null;
        $balanceAfter = $balanceBefore;

        if (!$isDemo) {
            DB::beginTransaction();
            try {
                $userLocked = User::where('id', $user->id)->lockForUpdate()->first();
                if ($userLocked->balance < $betAmount) {
                    throw new Exception("Insufficient balance.");
                }

                $userLocked->balance -= $betAmount;
                JuiceSlotsTransaction::create([
                    'user_id' => $userLocked->id,
                    'type' => 'bet_debit',
                    'amount' => $betAmount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $userLocked->balance,
                    'description' => "Placed bet on Juice Slots",
                ]);

                if ($winAmount > 0) {
                    $balBeforeWin = $userLocked->balance;
                    $userLocked->balance += $winAmount;
                    JuiceSlotsTransaction::create([
                        'user_id' => $userLocked->id,
                        'type' => 'win_credit',
                        'amount' => $winAmount,
                        'balance_before' => $balBeforeWin,
                        'balance_after' => $userLocked->balance,
                        'description' => "Won prize on Juice Slots ({$multiplier}x)",
                    ]);
                }

                $userLocked->save();
                $balanceAfter = (float)$userLocked->balance;

                $spinRecord = JuiceSlotsSpin::create([
                    'user_id' => $userLocked->id,
                    'bet_amount' => $betAmount,
                    'win_amount' => $winAmount,
                    'multiplier' => $multiplier,
                    'grid_matrix' => $bestGrid,
                    'winning_lines' => $bestResult['lines'],
                    'status' => 'completed',
                    'is_demo' => false,
                ]);

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            $balanceAfter = max(0, $balanceBefore - $betAmount + $winAmount);
        }

        return [
            'success' => true,
            'grid' => $bestGrid,
            'winning_lines' => $bestResult['lines'],
            'win_amount' => $winAmount,
            'multiplier' => $multiplier,
            'is_win' => ($winAmount > 0),
            'balance' => $balanceAfter,
            'is_demo' => $isDemo,
            'spin_id' => $spinRecord ? $spinRecord->id : null,
        ];
    }

    protected function generateGrid(): array
    {
        $grid = [];
        $weights = [
            'egg'   => 25,
            'ban'   => 20,
            'org'   => 16,
            'straw' => 12,
            'grape' => 8,
            'juice' => 5,
            'cup'   => 3,
        ];

        $pool = [];
        foreach ($weights as $sym => $count) {
            for ($i = 0; $i < $count; $i++) {
                $pool[] = $sym;
            }
        }

        for ($col = 0; $col < 5; $col++) {
            $column = [];
            for ($row = 0; $row < 3; $row++) {
                $column[] = $pool[array_rand($pool)];
            }
            $grid[] = $column;
        }

        return $grid;
    }

    protected function evaluateGrid(array $grid, float $betAmount): array
    {
        $lineBet = $betAmount / 10.0;
        $totalWin = 0.0;
        $winningLines = [];

        foreach (self::PAYLINES as $lineIdx => $coords) {
            $firstSymbol = null;
            $matchCount = 0;

            foreach ($coords as $pos) {
                $col = $pos[0];
                $row = $pos[1];
                $sym = $grid[$col][$row];

                if ($firstSymbol === null) {
                    $firstSymbol = $sym;
                    $matchCount = 1;
                } else {
                    if ($sym === $firstSymbol || $sym === 'juice' || $firstSymbol === 'juice') {
                        if ($firstSymbol === 'juice' && $sym !== 'juice') {
                            $firstSymbol = $sym;
                        }
                        $matchCount++;
                    } else {
                        break;
                    }
                }
            }

            if ($matchCount >= 3 && isset(self::PAYTABLE[$firstSymbol][$matchCount])) {
                $mult = self::PAYTABLE[$firstSymbol][$matchCount];
                $lineWin = $lineBet * $mult;
                $totalWin += $lineWin;
                $winningLines[] = [
                    'line_index' => $lineIdx,
                    'symbol' => $firstSymbol,
                    'count' => $matchCount,
                    'multiplier' => $mult,
                    'win_amount' => round($lineWin, 2),
                    'coords' => array_slice($coords, 0, $matchCount),
                ];
            }
        }

        return [
            'win_amount' => round($totalWin, 2),
            'lines' => $winningLines,
        ];
    }
}
