<?php

namespace App\Services;

use App\Models\BurningHotSetting;
use App\Models\BurningHotSpin;
use App\Models\BurningHotTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class BurningHotService {
    private array $symbols = ['seven', 'wild', 'pineapple', 'banana', 'dollar', 'grape', 'apple', 'cherry', 'star', 'pear', 'strawberry'];
    
    // 5 Classic Paylines
    private array $paylines = [
        [1, 1, 1, 1, 1], // Center (Row 1)
        [0, 0, 0, 0, 0], // Top (Row 0)
        [2, 2, 2, 2, 2], // Bottom (Row 2)
        [0, 1, 2, 1, 0], // V-Shape
        [2, 1, 0, 1, 2], // Inverted V
    ];

    private array $symbolPayouts = [
        'seven'      => [0, 0, 20, 200, 1000],
        'pineapple'  => [0, 0, 15, 50, 200],
        'banana'     => [0, 0, 15, 50, 200],
        'grape'      => [0, 0, 15, 50, 200],
        'apple'      => [0, 0, 10, 30, 100],
        'cherry'     => [0, 0, 10, 30, 100],
        'pear'       => [0, 0, 10, 30, 100],
        'strawberry' => [0, 0, 10, 30, 100],
        'dollar'     => [0, 0, 15, 100, 500], // Scatter
        'star'       => [0, 0, 100, 100, 100] // Scatter
    ];

    public function getSettings(): BurningHotSetting {
        return BurningHotSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Burning Hot',
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
            $spinResult = $this->generateGridAndEvaluate($shouldWin, $betAmount);
            return [
                'success' => true,
                'grid' => $spinResult['grid'],
                'win_amount' => $spinResult['total_win'],
                'winning_lines' => $spinResult['winning_lines'],
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

            $spinResult = $this->generateGridAndEvaluate($shouldWin, $betAmount);
            $winAmount = (float)$spinResult['total_win'];
            $adminProfit = round($betAmount - $winAmount, 2);

            $spin = BurningHotSpin::create([
                'user_id' => $lockedUser->id,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'winning_lines' => $spinResult['winning_lines'],
                'status' => $winAmount > 0 ? 'won' : 'lost',
                'is_demo' => false
            ]);

            BurningHotTransaction::create([
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

                BurningHotTransaction::create([
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
                'grid' => $spinResult['grid'],
                'win_amount' => $winAmount,
                'winning_lines' => $spinResult['winning_lines'],
                'new_balance' => (float)$lockedUser->balance,
                'is_demo' => false,
                'message' => $winAmount > 0 ? 'WIN ' . number_format($winAmount, 2) : ''
            ];
        });
    }

    private function generateGridAndEvaluate(bool $shouldWin, float $bet): array {
        for ($attempts = 0; $attempts < 100; $attempts++) {
            $grid = [];
            for ($r = 0; $r < 3; $r++) {
                $row = [];
                for ($c = 0; $c < 5; $c++) {
                    $row[] = $this->getRandomSymbol();
                }
                $grid[] = $row;
            }

            $eval = $this->evaluateGrid($grid, $bet);
            if ($shouldWin && $eval['total_win'] > 0) {
                return array_merge(['grid' => $grid], $eval);
            }
            if (!$shouldWin && $eval['total_win'] === 0.00) {
                return array_merge(['grid' => $grid], $eval);
            }
        }

        // Guaranteed fallback
        if ($shouldWin) {
            $sym = 'seven';
            $grid = [
                ['apple', 'banana', 'cherry', 'grape', 'pear'],
                [$sym, $sym, $sym, 'banana', 'cherry'],
                ['strawberry', 'apple', 'pineapple', 'grape', 'banana']
            ];
        } else {
            $grid = [
                ['apple', 'banana', 'cherry', 'grape', 'pear'],
                ['banana', 'cherry', 'grape', 'pear', 'apple'],
                ['cherry', 'grape', 'pear', 'apple', 'banana']
            ];
        }
        $eval = $this->evaluateGrid($grid, $bet);
        return array_merge(['grid' => $grid], $eval);
    }

    private function getRandomSymbol(): string {
        $r = rand(1, 100);
        if ($r <= 12) return 'seven';
        if ($r <= 20) return 'wild';
        if ($r <= 32) return 'pineapple';
        if ($r <= 44) return 'banana';
        if ($r <= 52) return 'dollar';
        if ($r <= 64) return 'grape';
        if ($r <= 74) return 'apple';
        if ($r <= 84) return 'cherry';
        if ($r <= 89) return 'star';
        if ($r <= 95) return 'pear';
        return 'strawberry';
    }

    private function evaluateGrid(array $grid, float $bet): array {
        $lineBet = $bet / 5;
        $total = 0.00;
        $winningLines = [];

        foreach ($this->paylines as $idx => $line) {
            $lineSymbols = [];
            for ($c = 0; $c < 5; $c++) {
                $r = $line[$c];
                $lineSymbols[] = $grid[$r][$c];
            }

            $target = null;
            foreach ($lineSymbols as $s) {
                if ($s !== 'wild' && $s !== 'dollar' && $s !== 'star') {
                    $target = $s;
                    break;
                }
            }
            if (!$target) $target = 'seven';

            $n = 0;
            while ($n < 5 && ($lineSymbols[$n] === $target || $lineSymbols[$n] === 'wild')) {
                $n++;
            }

            if ($n >= 3 && isset($this->symbolPayouts[$target])) {
                $payout = $this->symbolPayouts[$target][$n - 1] * $lineBet;
                $total += $payout;
                $winningLines[] = [
                    'line_idx' => $idx,
                    'count' => $n,
                    'symbol' => $target,
                    'payout' => $payout,
                    'positions' => array_map(fn($c) => ['r' => $line[$c], 'c' => $c], range(0, $n - 1))
                ];
            }
        }

        // Dollar Scatter Check (Anywhere on reels 1, 3, 5)
        $dollarCount = 0;
        for ($r = 0; $r < 3; $r++) {
            for ($c = 0; $c < 5; $c++) {
                if ($grid[$r][$c] === 'dollar') $dollarCount++;
            }
        }
        if ($dollarCount >= 3) {
            $payout = $this->symbolPayouts['dollar'][min($dollarCount, 5) - 1] * $lineBet;
            $total += $payout;
            $winningLines[] = ['line_idx' => -1, 'symbol' => 'dollar', 'count' => $dollarCount, 'payout' => $payout];
        }

        return [
            'total_win' => round($total, 2),
            'winning_lines' => $winningLines
        ];
    }
}
