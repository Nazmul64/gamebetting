<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TrxWingoService;
use App\Models\TrxWingoSetting;
use App\Models\TrxWingoPeriod;
use App\Models\TrxWingoBet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TrxWingoController extends Controller {
    protected TrxWingoService $service;

    public function __construct(TrxWingoService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $user = Auth::user();
        $initialPeriod = $this->service->getOrCreatePeriod('1m');
        $initialLastCompleted = TrxWingoPeriod::where('time_type', '1m')
            ->where('status', 'completed')
            ->orderBy('id', 'desc')
            ->first();
        return view('games.trx_wingo', compact('settings', 'user', 'initialPeriod', 'initialLastCompleted'));
    }

    public function getState(Request $request) {
        $timeType = $request->query('type', '1m');
        if (!in_array($timeType, ['1m', '3m', '5m'])) {
            $timeType = '1m';
        }

        $now = Carbon::now();
        $period = $this->service->getOrCreatePeriod($timeType);

        if ($now->greaterThanOrEqualTo($period->ends_at) && $period->status === 'betting') {
            $this->service->settlePeriod($period);
            $period = $this->service->getOrCreatePeriod($timeType);
        }

        $user = Auth::user();

        // Get completed history for blockchain table & charts
        $recentHistory = TrxWingoPeriod::where('time_type', $timeType)
            ->where('status', 'completed')
            ->orderBy('id', 'desc')
            ->take(50)
            ->get([
                'id',
                'period_number',
                'block_height',
                'block_time',
                'hash_value',
                'hash_tail_chars',
                'winning_number',
                'winning_color',
                'winning_size',
                'created_at'
            ]);

        $lastCompleted = $recentHistory->first();

        // Calculate statistics for last 100 periods
        $statsHistory = TrxWingoPeriod::where('time_type', $timeType)
            ->where('status', 'completed')
            ->orderBy('id', 'desc')
            ->take(100)
            ->get(['winning_number', 'winning_color', 'winning_size']);

        $stats = $this->calculateChartStats($statsHistory);
        $settings = $this->service->getSettings();

        return response()->json([
            'period_number' => $period->period_number,
            'time_type' => $timeType,
            'block_height' => $period->block_height,
            'block_time' => $period->block_time,
            'time_remaining' => max(0, $now->diffInSeconds($period->ends_at, false)),
            'status' => $period->status,
            'user_balance' => $user ? (float)$user->balance : null,
            'history' => $recentHistory,
            'last_completed' => $lastCompleted,
            'stats' => $stats,
            'how_to_play' => $settings->how_to_play_rules,
            'settings' => [
                'min_bet' => (float)$settings->min_bet,
                'max_bet' => (float)$settings->max_bet,
                'demo_limit' => (int)$settings->demo_limit,
            ]
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'time_type' => 'required|in:1m,3m,5m',
            'bet_type' => 'required|in:color,number,size',
            'selected_value' => 'required|string',
            'amount' => 'required|numeric|min:0.1',
            'multiplier' => 'required|numeric|min:1',
            'is_demo' => 'nullable|boolean',
            'demo_bets_count' => 'nullable|integer'
        ]);

        try {
            $res = $this->service->processBet(Auth::user(), $request->all());
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function getMyHistory(Request $request) {
        $user = Auth::user();
        $isDemo = $request->query('is_demo', '0') == '1';
        $timeType = $request->query('time_type');

        $query = TrxWingoBet::with('period')
            ->orderBy('id', 'desc')
            ->take(50);

        if ($timeType && in_array($timeType, ['1m', '3m', '5m'])) {
            $query->where('time_type', $timeType);
        }

        if ($isDemo) {
            $query->where('is_demo', true);
            if ($user) {
                $query->where('user_id', $user->id);
            }
        } else {
            if (!$user) {
                return response()->json(['bets' => []]);
            }
            $query->where('user_id', $user->id)->where('is_demo', false);
        }

        $bets = $query->get()->map(function ($bet) {
            return [
                'id' => $bet->id,
                'period_number' => $bet->period ? $bet->period->period_number : '---',
                'bet_type' => $bet->bet_type,
                'selected_value' => $bet->selected_value,
                'total_amount' => (float)$bet->total_amount,
                'win_amount' => (float)$bet->win_amount,
                'status' => $bet->status,
                'winning_number' => $bet->period ? $bet->period->winning_number : null,
                'winning_color' => $bet->period ? $bet->period->winning_color : null,
                'winning_size' => $bet->period ? $bet->period->winning_size : null,
                'time' => $bet->created_at->format('H:i:s'),
                'date' => $bet->created_at->format('Y-m-d')
            ];
        });

        return response()->json(['bets' => $bets]);
    }

    private function calculateChartStats($records) {
        $missing = array_fill(0, 10, 0);
        $found = array_fill(0, 10, false);
        $frequency = array_fill(0, 10, 0);
        $maxConsecutive = array_fill(0, 10, 0);
        $currentConsecutive = array_fill(0, 10, 0);
        $avgMissing = array_fill(0, 10, 5);

        $colorCounts = ['green' => 0, 'red' => 0, 'violet' => 0];
        $total = count($records);

        foreach ($records as $index => $rec) {
            $num = $rec->winning_number;
            if ($num !== null && $num >= 0 && $num <= 9) {
                $frequency[$num]++;

                // Color distribution
                if (in_array($num, [1, 3, 7, 9])) $colorCounts['green']++;
                elseif (in_array($num, [2, 4, 6, 8])) $colorCounts['red']++;
                elseif (in_array($num, [0, 5])) {
                    $colorCounts['violet']++;
                    if ($num === 0) $colorCounts['red'] += 0.5;
                    if ($num === 5) $colorCounts['green'] += 0.5;
                }
            }
        }

        // Calculate current missing counts from newest backwards
        foreach ($records as $index => $rec) {
            $num = $rec->winning_number;
            for ($i = 0; $i <= 9; $i++) {
                if (!$found[$i]) {
                    if ($num === $i) {
                        $found[$i] = true;
                    } else {
                        $missing[$i]++;
                    }
                }
            }
        }

        for ($i = 0; $i <= 9; $i++) {
            $freq = $frequency[$i];
            $avgMissing[$i] = $freq > 0 ? (int)round(($total - $freq) / $freq) : 10;
            $maxConsecutive[$i] = $freq > 0 ? min(3, $freq) : 0;
        }

        return [
            'missing' => $missing,
            'avg_missing' => $avgMissing,
            'frequency' => $frequency,
            'max_consecutive' => $maxConsecutive,
            'color_percentages' => [
                'green' => $total > 0 ? round(($colorCounts['green'] / $total) * 100) : 48,
                'red' => $total > 0 ? round(($colorCounts['red'] / $total) * 100) : 45,
                'violet' => $total > 0 ? round(($colorCounts['violet'] / $total) * 100) : 7,
            ]
        ];
    }
}
