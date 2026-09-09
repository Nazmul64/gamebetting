<?php

namespace App\Services;

use App\Models\OlympusConfig;

class OlympusEngineService
{
    const COLS = 6;
    const ROWS = 5;

    /**
     * Generate 6x5 grid using cryptographic random generator according to config rules.
     */
    public function generateGrid(OlympusConfig $config, bool $isDoubleChance = false, bool $guaranteeScatters = false): array
    {
        $multipliers = $config->multipliers_json ?? [];
        $grid = [];

        // Determine scatter probability (Double chance increases scatter chance)
        $scatterThreshold = $isDoubleChance ? 14 : 7; // percent out of 100
        $multiThreshold   = 12; // percent out of 100

        for ($c = 0; $c < self::COLS; $c++) {
            $grid[$c] = [];
            for ($r = 0; $r < self::ROWS; $r++) {
                $randVal = random_int(1, 100);

                if ($randVal <= $scatterThreshold) {
                    $grid[$c][$r] = [
                        'type' => 'scatter',
                        'data' => 10,
                    ];
                } elseif ($randVal <= ($scatterThreshold + $multiThreshold)) {
                    $selectedMulti = $this->pickWeightedMultiplier($multipliers);
                    $grid[$c][$r] = [
                        'type' => 'multi',
                        'data' => $selectedMulti,
                    ];
                } else {
                    $shapeId = random_int(1, 9);
                    $grid[$c][$r] = [
                        'type' => 'shape',
                        'data' => $shapeId,
                    ];
                }
            }
        }

        // If Buy Feature is active or guaranteed scatters requested, ensure at least required scatters (e.g. 4)
        if ($guaranteeScatters) {
            $requiredScatters = max(4, $config->required_scatters_for_free_spins);
            $availablePositions = [];
            for ($c = 0; $c < self::COLS; $c++) {
                for ($r = 0; $r < self::ROWS; $r++) {
                    if ($grid[$c][$r]['type'] !== 'scatter') {
                        $availablePositions[] = [$c, $r];
                    }
                }
            }

            // Count existing scatters
            $existingScatters = 0;
            for ($c = 0; $c < self::COLS; $c++) {
                for ($r = 0; $r < self::ROWS; $r++) {
                    if ($grid[$c][$r]['type'] === 'scatter') {
                        $existingScatters++;
                    }
                }
            }

            $needed = $requiredScatters - $existingScatters;
            if ($needed > 0 && count($availablePositions) >= $needed) {
                shuffle($availablePositions);
                for ($i = 0; $i < $needed; $i++) {
                    [$c, $r] = $availablePositions[$i];
                    $grid[$c][$r] = [
                        'type' => 'scatter',
                        'data' => 10,
                    ];
                }
            }
        }

        return $grid;
    }

    /**
     * Pick a multiplier symbol based on configured probability weights.
     */
    protected function pickWeightedMultiplier(array $multipliers): array
    {
        if (empty($multipliers)) {
            return ['label' => '2X', 'value' => 2, 'tone' => 'tone-orange'];
        }

        $totalWeight = 0;
        foreach ($multipliers as $m) {
            $totalWeight += ($m['weight'] ?? 10);
        }

        $randomWeight = random_int(1, max(1, $totalWeight));
        $current = 0;

        foreach ($multipliers as $m) {
            $current += ($m['weight'] ?? 10);
            if ($randomWeight <= $current) {
                return [
                    'label' => $m['label'] ?? ($m['value'] . 'X'),
                    'value' => (int) $m['value'],
                    'tone'  => $m['tone'] ?? 'tone-orange',
                ];
            }
        }

        return $multipliers[0];
    }

    /**
     * Evaluate grid combinations, calculate base win, scatters, multipliers, and final win.
     */
    public function evaluateRound(array $grid, float $betAmount, OlympusConfig $config): array
    {
        $paytable = $config->paytable_json ?? [];

        $shapeCounts = [];
        $shapeCells = [];
        $scatterCount = 0;
        $scatterCells = [];
        $multiplierSymbols = [];
        $multiplierCells = [];
        $totalMultiplier = 0;

        // Flatten & analyze grid positions
        for ($c = 0; $c < self::COLS; $c++) {
            for ($r = 0; $r < self::ROWS; $r++) {
                $cell = $grid[$c][$r];

                if ($cell['type'] === 'shape') {
                    $shapeId = (string) $cell['data'];
                    if (!isset($shapeCounts[$shapeId])) {
                        $shapeCounts[$shapeId] = 0;
                        $shapeCells[$shapeId] = [];
                    }
                    $shapeCounts[$shapeId]++;
                    $shapeCells[$shapeId][] = ['col' => $c, 'row' => $r];
                } elseif ($cell['type'] === 'scatter') {
                    $scatterCount++;
                    $scatterCells[] = ['col' => $c, 'row' => $r];
                } elseif ($cell['type'] === 'multi') {
                    $val = (int) ($cell['data']['value'] ?? 2);
                    $totalMultiplier += $val;
                    $multiplierSymbols[] = $cell['data'];
                    $multiplierCells[] = [
                        'col'   => $c,
                        'row'   => $r,
                        'data'  => $cell['data'],
                    ];
                }
            }
        }

        $baseWin = 0.00;
        $winningShapes = [];
        $winningCells = [];

        // 1. Evaluate Shape Cluster Matches (8 or more matching shapes pays!)
        foreach ($shapeCounts as $shapeId => $count) {
            if ($count >= 8) {
                $payoutRate = 0.00;
                $shapeConfig = $paytable[$shapeId] ?? null;

                if ($shapeConfig) {
                    if ($count >= 12) {
                        $payoutRate = (float) ($shapeConfig['match_12_plus'] ?? 2.00);
                    } elseif ($count >= 10) {
                        $payoutRate = (float) ($shapeConfig['match_10_11'] ?? 1.00);
                    } else {
                        $payoutRate = (float) ($shapeConfig['match_8_9'] ?? 0.50);
                    }
                } else {
                    // Fallback rates if paytable not set
                    $idNum = (int) $shapeId;
                    if ($idNum <= 3) {
                        $payoutRate = $count >= 12 ? 2.0 : ($count >= 10 ? 1.0 : 0.4);
                    } elseif ($idNum <= 6) {
                        $payoutRate = $count >= 12 ? 8.0 : ($count >= 10 ? 1.5 : 0.8);
                    } else {
                        $payoutRate = $count >= 12 ? 15.0 : ($count >= 10 ? 5.0 : 1.5);
                    }
                }

                $shapeWinAmount = $betAmount * $payoutRate;
                $baseWin += $shapeWinAmount;

                $winningShapes[] = [
                    'shape_id'       => $shapeId,
                    'count'          => $count,
                    'payout_rate'    => $payoutRate,
                    'win_amount'     => round($shapeWinAmount, 2),
                    'cells'          => $shapeCells[$shapeId],
                ];

                foreach ($shapeCells[$shapeId] as $coord) {
                    $winningCells[] = $coord;
                }
            }
        }

        // 2. Evaluate Scatter Wins (4+ Scatters pays and triggers Free Spins)
        $triggeredFreeSpins = false;
        $freeSpinsCount = 0;
        $scatterWinAmount = 0.00;

        $reqScatters = max(4, $config->required_scatters_for_free_spins);
        if ($scatterCount >= $reqScatters) {
            $triggeredFreeSpins = true;
            $freeSpinsCount = $config->free_spins_count ?: 10;

            $scatterConfig = $paytable['scatter'] ?? null;
            $scatterMultiplier = 3.00;
            if ($scatterConfig) {
                if ($scatterCount >= 6) {
                    $scatterMultiplier = (float) ($scatterConfig['match_6'] ?? 100.00);
                } elseif ($scatterCount === 5) {
                    $scatterMultiplier = (float) ($scatterConfig['match_5'] ?? 15.00);
                } else {
                    $scatterMultiplier = (float) ($scatterConfig['match_4'] ?? 3.00);
                }
            } else {
                if ($scatterCount >= 6) $scatterMultiplier = 100.00;
                elseif ($scatterCount === 5) $scatterMultiplier = 15.00;
                else $scatterMultiplier = 3.00;
            }

            $scatterWinAmount = $betAmount * $scatterMultiplier;
            $baseWin += $scatterWinAmount;

            foreach ($scatterCells as $coord) {
                $winningCells[] = $coord;
            }
        }

        // 3. Compute Final Win with Multipliers
        $maxMulti = $config->max_multiplier ?: 500;
        $effectiveMultiplier = min($totalMultiplier, $maxMulti);

        $finalWin = 0.00;
        if ($baseWin > 0) {
            if ($effectiveMultiplier > 0) {
                $finalWin = $baseWin * $effectiveMultiplier;
            } else {
                $finalWin = $baseWin;
            }
        }

        return [
            'grid'                 => $grid,
            'winning_shapes'       => $winningShapes,
            'winning_cells'        => $winningCells,
            'scatter_count'        => $scatterCount,
            'scatter_cells'        => $scatterCells,
            'scatter_win_amount'   => round($scatterWinAmount, 2),
            'triggered_free_spins' => $triggeredFreeSpins,
            'free_spins_count'     => $freeSpinsCount,
            'multiplier_symbols'   => $multiplierSymbols,
            'multiplier_cells'     => $multiplierCells,
            'total_multiplier'     => $effectiveMultiplier,
            'base_win'             => round($baseWin, 2),
            'final_win'            => round($finalWin, 2),
            'is_win'               => $finalWin > 0,
        ];
    }
}
