<?php

namespace App\Services;

use App\Models\CrystalSetting;
use App\Models\CrystalSpin;
use App\Models\CrystalTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class CrystalService {
    private array $gems = ['red', 'violet', 'blue', 'yellow', 'azure', 'green', 'wild'];
    private array $gemPayout = [
        'red'    => 2.0,
        'violet' => 1.9,
        'blue'   => 1.5,
        'yellow' => 0.9,
        'azure'  => 0.8,
        'green'  => 0.5,
    ];

    public function getSettings(): CrystalSetting {
        return CrystalSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Crystal',
            'min_bet' => 1.00,
            'max_bet' => 50000.00,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'admin_profit_percentage' => 70,
        ]);
    }

    public function executeSpin(?User $user, array $data): array {
        $settings = $this->getSettings();
        $betAmount = (float)($data['bet'] ?? 20);
        $isDemo = (bool)($data['is_demo'] ?? false);

        if ($betAmount < (float)$settings->min_bet || $betAmount > (float)$settings->max_bet) {
            throw new Exception("Bet amount must be between {$settings->min_bet} and {$settings->max_bet}");
        }

        if ($isDemo) {
            $shouldWin = (rand(1, 100) <= 35);
            $spinResult = $this->generateCascades($shouldWin, $betAmount);
            return [
                'success' => true,
                'initial_grid' => $spinResult['initial_grid'],
                'cascades' => $spinResult['cascades'],
                'win_amount' => $spinResult['total_win'],
                'is_demo' => true,
                'message' => $spinResult['total_win'] > 0 ? 'WIN ' . number_format($spinResult['total_win'], 2) : ''
            ];
        }

        if (!$user) {
            throw new Exception('Please log in to play real mode.');
        }

        return DB::transaction(function () use ($user, $settings, $betAmount) {
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser || $lockedUser->balance < $betAmount) {
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
                $shouldWin = (rand(1, 100) <= $winChance);
            }

            $balanceBefore = (float)$lockedUser->balance;
            $lockedUser->balance -= $betAmount;
            $lockedUser->save();

            $spinResult = $this->generateCascades($shouldWin, $betAmount);
            $winAmount = (float)$spinResult['total_win'];
            $adminProfit = round($betAmount - $winAmount, 2);

            $spin = CrystalSpin::create([
                'user_id' => $lockedUser->id,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'initial_grid' => $spinResult['initial_grid'],
                'cascades' => $spinResult['cascades'],
                'status' => $winAmount > 0 ? 'won' : 'lost',
                'is_demo' => false
            ]);

            CrystalTransaction::create([
                'user_id' => $lockedUser->id,
                'spin_id' => $spin->id,
                'type' => 'debit_spin',
                'amount' => $betAmount,
                'balance_before' => $balanceBefore,
                'balance_after' => (float)$lockedUser->balance
            ]);

            if ($winAmount > 0) {
                $balanceBeforeWin = (float)$lockedUser->balance;
                $lockedUser->balance += $winAmount;
                $lockedUser->save();

                CrystalTransaction::create([
                    'user_id' => $lockedUser->id,
                    'spin_id' => $spin->id,
                    'type' => 'credit_win',
                    'amount' => $winAmount,
                    'balance_before' => $balanceBeforeWin,
                    'balance_after' => (float)$lockedUser->balance
                ]);
            }

            return [
                'success' => true,
                'spin_id' => $spin->id,
                'initial_grid' => $spinResult['initial_grid'],
                'cascades' => $spinResult['cascades'],
                'win_amount' => $winAmount,
                'new_balance' => (float)$lockedUser->balance,
                'is_demo' => false,
                'message' => $winAmount > 0 ? 'WIN ' . number_format($winAmount, 2) : ''
            ];
        });
    }

    private function generateCascades(bool $shouldWin, float $bet): array {
        for ($attempts = 0; $attempts < 50; $attempts++) {
            $grid = [];
            for ($r = 0; $r < 7; $r++) {
                $row = [];
                for ($c = 0; $c < 7; $c++) {
                    $row[] = $this->getRandomGem();
                }
                $grid[] = $row;
            }

            if ($shouldWin && $attempts === 0) {
                // Seed a cluster of 5 red gems
                $gem = 'red';
                $grid[2][2] = $gem; $grid[2][3] = $gem; $grid[2][4] = $gem;
                $grid[3][3] = $gem; $grid[4][3] = $gem;
            }

            $eval = $this->evaluateCascades($grid, $bet);
            if ($shouldWin && $eval['total_win'] > 0) {
                return array_merge(['initial_grid' => $grid], $eval);
            }
            if (!$shouldWin && $eval['total_win'] === 0.00) {
                return array_merge(['initial_grid' => $grid], $eval);
            }
        }

        // Guaranteed fallback
        if ($shouldWin) {
            $grid = $this->createGuaranteedWinningGrid();
        } else {
            $grid = $this->createGuaranteedLosingGrid();
        }
        $eval = $this->evaluateCascades($grid, $bet);
        return array_merge(['initial_grid' => $grid], $eval);
    }

    private function getRandomGem(): string {
        $r = rand(1, 100);
        if ($r <= 5) return 'wild';
        if ($r <= 20) return 'red';
        if ($r <= 35) return 'violet';
        if ($r <= 50) return 'blue';
        if ($r <= 65) return 'yellow';
        if ($r <= 80) return 'azure';
        return 'green';
    }

    private function createGuaranteedWinningGrid(): array {
        $grid = [];
        $palette = ['red', 'violet', 'blue', 'yellow', 'azure', 'green'];
        for ($r = 0; $r < 7; $r++) {
            $row = [];
            for ($c = 0; $c < 7; $c++) {
                $row[] = $palette[($r + $c) % 6];
            }
            $grid[] = $row;
        }
        // Cluster of 5
        $grid[2][2] = 'red'; $grid[2][3] = 'red'; $grid[2][4] = 'red';
        $grid[3][3] = 'red'; $grid[4][3] = 'red';
        return $grid;
    }

    private function createGuaranteedLosingGrid(): array {
        $grid = [];
        $palette = ['red', 'violet', 'blue', 'yellow', 'azure', 'green'];
        for ($r = 0; $r < 7; $r++) {
            $row = [];
            for ($c = 0; $c < 7; $c++) {
                $row[] = $palette[($r * 2 + $c) % 6];
            }
            $grid[] = $row;
        }
        return $grid;
    }

    private function evaluateCascades(array $grid, float $bet): array {
        $totalWin = 0.00;
        $cascades = [];
        $currentGrid = $grid;

        for ($step = 0; $step < 5; $step++) {
            $clusters = $this->findClusters($currentGrid);
            if (empty($clusters)) {
                break;
            }

            $stepWin = 0.00;
            $clearedPositions = [];
            foreach ($clusters as $cluster) {
                $gemType = $cluster['gem'];
                $mult = $this->gemPayout[$gemType] ?? 0.5;
                $payout = round($bet * $mult * (count($cluster['positions']) / 5), 2);
                $stepWin += $payout;
                foreach ($cluster['positions'] as $pos) {
                    $clearedPositions[] = $pos;
                }
            }

            $totalWin += $stepWin;
            $cascades[] = [
                'step' => $step + 1,
                'clusters' => $clusters,
                'step_win' => $stepWin,
                'grid_before' => $currentGrid
            ];

            // Apply gravity
            $currentGrid = $this->applyGravity($currentGrid, $clearedPositions);
        }

        return [
            'total_win' => round($totalWin, 2),
            'cascades' => $cascades
        ];
    }

    private function findClusters(array $grid): array {
        $visited = array_fill(0, 7, array_fill(0, 7, false));
        $clusters = [];

        for ($r = 0; $r < 7; $r++) {
            for ($c = 0; $c < 7; $c++) {
                if ($visited[$r][$c]) continue;
                $gem = $grid[$r][$c];
                if ($gem === 'wild') continue;

                $cluster = [];
                $queue = [[$r, $c]];
                $visited[$r][$c] = true;

                while (!empty($queue)) {
                    [$currR, $currC] = array_shift($queue);
                    $cluster[] = ['r' => $currR, 'c' => $currC];

                    $neighbors = [
                        [$currR - 1, $currC], [$currR + 1, $currC],
                        [$currR, $currC - 1], [$currR, $currC + 1]
                    ];

                    foreach ($neighbors as [$nR, $nC]) {
                        if ($nR >= 0 && $nR < 7 && $nC >= 0 && $nC < 7 && !$visited[$nR][$nC]) {
                            $neighborGem = $grid[$nR][$nC];
                            if ($neighborGem === $gem || $neighborGem === 'wild') {
                                $visited[$nR][$nC] = true;
                                $queue[] = [$nR, $nC];
                            }
                        }
                    }
                }

                if (count($cluster) >= 5) {
                    $clusters[] = ['gem' => $gem, 'positions' => $cluster];
                }
            }
        }
        return $clusters;
    }

    private function applyGravity(array $grid, array $clearedPositions): array {
        $clearedMap = [];
        foreach ($clearedPositions as $pos) {
            $clearedMap[$pos['r']][$pos['c']] = true;
        }

        $newGrid = $grid;
        for ($c = 0; $c < 7; $c++) {
            $colGems = [];
            for ($r = 6; $r >= 0; $r--) {
                if (!isset($clearedMap[$r][$c])) {
                    $colGems[] = $grid[$r][$c];
                }
            }
            while (count($colGems) < 7) {
                $colGems[] = $this->getRandomGem();
            }
            for ($r = 6; $r >= 0; $r--) {
                $newGrid[$r][$c] = $colGems[6 - $r];
            }
        }
        return $newGrid;
    }
}
