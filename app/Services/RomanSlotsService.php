<?php

namespace App\Services;

use App\Models\RomanSlotsSetting;
use App\Models\RomanSlotsSpin;
use App\Models\RomanSlotsTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class RomanSlotsService {
    private array $symbols = ['H1', 'H2', 'H3', 'H4', 'L1', 'L2', 'L3', 'L4', 'W', 'S'];
    
    // 20 Standard Paylines
    private array $lines = [
        [1,1,1,1,1], [0,0,0,0,0], [2,2,2,2,2], [0,1,2,1,0], [2,1,0,1,2],
        [0,0,1,0,0], [2,2,1,2,2], [1,2,2,2,1], [1,0,0,0,1], [1,0,1,0,1],
        [1,2,1,2,1], [0,1,0,1,0], [2,1,2,1,2], [0,1,1,1,0], [2,1,1,1,2],
        [1,1,0,1,1], [1,1,2,1,1], [0,2,0,2,0], [2,0,2,0,2], [0,2,2,2,0]
    ];

    private array $payTable = [
        'H1' => [0, 0, 50, 200, 1000],
        'H2' => [0, 0, 40, 150, 500],
        'H3' => [0, 0, 30, 100, 300],
        'H4' => [0, 0, 20, 80, 200],
        'L1' => [0, 0, 10, 30, 100],
        'L2' => [0, 0, 10, 30, 100],
        'L3' => [0, 0, 5, 20, 50],
        'L4' => [0, 0, 5, 20, 50],
        'W'  => [0, 0, 50, 200, 1000]
    ];

    private array $scatterPay = [0, 0, 0, 2, 10, 50];

    public function getSettings(): RomanSlotsSetting {
        return RomanSlotsSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Roman Slots',
            'min_bet' => 1.00,
            'max_bet' => 5000.00,
            'demo_default_balance' => 1000.00,
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
                'hit_cells' => $spinResult['hit_cells'],
                'scatter_win' => $spinResult['scatter_win'],
                'extra_msg' => $spinResult['extra_msg'],
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

            $spin = RomanSlotsSpin::create([
                'user_id' => $lockedUser->id,
                'bet_amount' => $betAmount,
                'win_amount' => $winAmount,
                'admin_profit' => $adminProfit,
                'grid_matrix' => $spinResult['grid'],
                'winning_lines' => $spinResult['winning_lines'],
                'message' => $winAmount > 0 ? 'WIN ' . number_format($winAmount, 2) : '',
                'status' => $winAmount > 0 ? 'won' : 'lost',
                'is_demo' => false
            ]);

            RomanSlotsTransaction::create([
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

                RomanSlotsTransaction::create([
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
                'hit_cells' => $spinResult['hit_cells'],
                'scatter_win' => $spinResult['scatter_win'],
                'extra_msg' => $spinResult['extra_msg'],
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
                    $row[] = $this->symbols[array_rand($this->symbols)];
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

        // Fallback guaranteed grid
        if ($shouldWin) {
            $sym = 'H1';
            $grid = [
                [$sym, $sym, $sym, 'L3', 'L4'],
                ['L1', 'L2', 'L3', 'L4', 'L1'],
                ['L2', 'L3', 'L4', 'L1', 'L2']
            ];
        } else {
            $grid = [
                ['H1', 'H2', 'H3', 'H4', 'L1'],
                ['L2', 'L3', 'L4', 'H1', 'H2'],
                ['H3', 'H4', 'L1', 'L2', 'L3']
            ];
        }
        $eval = $this->evaluateGrid($grid, $bet);
        return array_merge(['grid' => $grid], $eval);
    }

    private function evaluateGrid(array $grid, float $bet): array {
        $lineBet = $bet / 20;
        $total = 0.00;
        $hit = [];
        $winningLines = [];

        foreach ($this->lines as $idx => $line) {
            $lineSymbols = [];
            for ($c = 0; $c < 5; $c++) {
                $r = $line[$c];
                $lineSymbols[] = $grid[$r][$c];
            }

            $target = null;
            foreach ($lineSymbols as $s) {
                if ($s !== 'W' && $s !== 'S') {
                    $target = $s;
                    break;
                }
            }
            if (!$target) $target = 'W';

            $n = 0;
            while ($n < 5 && ($lineSymbols[$n] === $target || $lineSymbols[$n] === 'W')) {
                $n++;
            }

            if ($n >= 3 && isset($this->payTable[$target])) {
                $payout = $this->payTable[$target][$n - 1] * $lineBet;
                $total += $payout;
                $winningLines[] = ['line' => $idx, 'count' => $n, 'symbol' => $target, 'payout' => $payout];
                for ($i = 0; $i < $n; $i++) {
                    $hit[] = $line[$i] * 5 + $i;
                }
            }
        }

        // Scatter check
        $sc = [];
        for ($r = 0; $r < 3; $r++) {
            for ($c = 0; $c < 5; $c++) {
                if ($grid[$r][$c] === 'S') {
                    $sc[] = $r * 5 + $c;
                }
            }
        }

        $extra = '';
        $scWin = false;
        if (count($sc) >= 3) {
            $scCount = min(count($sc), 5);
            $scPayout = $bet * $this->scatterPay[$scCount];
            $total += $scPayout;
            $extra = ' Scatter x' . count($sc) . '!';
            $scWin = true;
            foreach ($sc as $idx) {
                $hit[] = $idx;
            }
        }

        return [
            'total_win' => round($total, 2),
            'hit_cells' => array_values(array_unique($hit)),
            'winning_lines' => $winningLines,
            'scatter_win' => $scWin,
            'extra_msg' => $extra
        ];
    }
}
