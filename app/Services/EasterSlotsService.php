<?php

namespace App\Services;

use App\Models\EasterSlotsSetting;
use App\Models\EasterSlotsSpin;
use App\Models\EasterSlotsTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class EasterSlotsService
{
    protected const SYMBOLS = ['Q', 'J', 'U', 'R', 'P', 'G', 'B', 'W', 'C'];
    protected const PAYTABLE = [
        'W' => [3 => 10, 4 => 40, 5 => 200], // Easter Bunny (Wild)
        'G' => [3 => 8,  4 => 30, 5 => 150], // Gold Egg
        'P' => [3 => 6,  4 => 20, 5 => 100], // Purple Egg
        'R' => [3 => 5,  4 => 15, 5 => 80],  // Red Egg
        'U' => [3 => 4,  4 => 12, 5 => 60],  // Blue Egg
        'Q' => [3 => 3,  4 => 8,  5 => 40],  // Queen
        'J' => [3 => 2,  4 => 6,  5 => 30],  // Jack
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
        [ [0,2], [1,1], [2,2], [3,1], [4,2] ], // Line 11
        [ [0,1], [1,0], [2,1], [3,2], [4,1] ], // Line 12
        [ [0,1], [1,2], [2,1], [3,0], [4,1] ], // Line 13
        [ [0,0], [1,0], [2,2], [3,0], [4,0] ], // Line 14
        [ [0,2], [1,2], [2,0], [3,2], [4,2] ], // Line 15
        [ [0,0], [1,2], [2,0], [3,2], [4,0] ], // Line 16
        [ [0,2], [1,0], [2,2], [3,0], [4,2] ], // Line 17
        [ [0,1], [1,1], [2,0], [3,1], [4,1] ], // Line 18
        [ [0,1], [1,1], [2,2], [3,1], [4,1] ], // Line 19
        [ [0,0], [1,2], [2,1], [3,0], [4,2] ], // Line 20
    ];

    public function getSettings(): EasterSlotsSetting
    {
        return EasterSlotsSetting::firstOrCreate([], [
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
            throw new Exception("Easter Slots is currently under scheduled maintenance.");
        }

        if ($betAmount < $settings->min_bet || $betAmount > $settings->max_bet) {
            throw new Exception("Bet amount must be between ৳{$settings->min_bet} and ৳{$settings->max_bet}.");
        }

        if (!$isDemo) {
            GameOutcomeRiggingService::validatePlayerCanPlay($user, 'easter_slots');
        }

        $balanceBefore = (float) $user->balance;
        if (!$isDemo && $balanceBefore < $betAmount) {
            throw new Exception("Insufficient account balance to place bet.");
        }

        $targetOutcome = null;
        if (!$isDemo) {
            $rigAction = GameOutcomeRiggingService::determineSpinRigAction($user, 'easter_slots');
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
                EasterSlotsTransaction::create([
                    'user_id' => $userLocked->id,
                    'type' => 'bet_debit',
                    'amount' => $betAmount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $userLocked->balance,
                    'description' => "Placed bet on Easter Slots",
                ]);

                if ($winAmount > 0) {
                    $balBeforeWin = $userLocked->balance;
                    $userLocked->balance += $winAmount;
                    EasterSlotsTransaction::create([
                        'user_id' => $userLocked->id,
                        'type' => 'win_credit',
                        'amount' => $winAmount,
                        'balance_before' => $balBeforeWin,
                        'balance_after' => $userLocked->balance,
                        'description' => "Won prize on Easter Slots ({$multiplier}x)",
                    ]);
                }

                $userLocked->save();
                $balanceAfter = (float)$userLocked->balance;

                $spinRecord = EasterSlotsSpin::create([
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
            'J' => 24, 'Q' => 20, 'U' => 16, 'R' => 14,
            'P' => 10, 'G' => 8,  'B' => 4,  'W' => 3, 'C' => 1
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
        $lineBet = $betAmount / 20.0;
        $totalWin = 0.0;
        $winningLines = [];

        foreach (self::PAYLINES as $lineIdx => $coords) {
            $firstSymbol = null;
            $matchCount = 0;

            foreach ($coords as $pos) {
                $col = $pos[0];
                $row = $pos[1];
                $sym = $grid[$col][$row];

                if ($sym === 'C' || $sym === 'B') {
                    // Scatter/Bonus handled separately
                    break;
                }

                if ($firstSymbol === null) {
                    $firstSymbol = $sym;
                    $matchCount = 1;
                } else {
                    if ($sym === $firstSymbol || $sym === 'W' || $firstSymbol === 'W') {
                        if ($firstSymbol === 'W' && $sym !== 'W') {
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

        // Scatter checks
        $scatterCount = 0;
        $scatterCoords = [];
        for ($c = 0; $c < 5; $c++) {
            for ($r = 0; $r < 3; $r++) {
                if ($grid[$c][$r] === 'C') {
                    $scatterCount++;
                    $scatterCoords[] = [$c, $r];
                }
            }
        }

        if ($scatterCount >= 3) {
            $scatterMult = ($scatterCount === 3) ? 5 : (($scatterCount === 4) ? 20 : 50);
            $scatterWin = $betAmount * $scatterMult;
            $totalWin += $scatterWin;
            $winningLines[] = [
                'line_index' => -1,
                'symbol' => 'C',
                'count' => $scatterCount,
                'multiplier' => $scatterMult,
                'win_amount' => round($scatterWin, 2),
                'coords' => $scatterCoords,
            ];
        }

        return [
            'win_amount' => round($totalWin, 2),
            'lines' => $winningLines,
        ];
    }
}
