<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\K3Service;
use App\Models\K3Setting;
use App\Models\K3Period;
use App\Models\K3Bet;
use Carbon\Carbon;

class K3Controller extends Controller {
    protected K3Service $service;

    public function __construct(K3Service $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = K3Setting::firstOrCreate(['id' => 1], [
            'game_name' => 'K3 Lottery',
            'min_bet' => 1.00,
            'max_bet' => 50000.00,
            'demo_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'bot_status' => true,
            'bot_trigger_count' => 5,
            'audio_countdown_enabled' => true
        ]);
        return view('games.k3', compact('settings'));
    }

    public function getState(Request $request) {
        $timeType = $request->query('type', '1m');
        if (!in_array($timeType, ['1m', '3m', '5m', '10m'])) {
            $timeType = '1m';
        }

        $period = $this->service->getOrCreatePeriod($timeType);
        $now = Carbon::now();

        if ($now->greaterThanOrEqualTo($period->ends_at) && $period->status === 'betting') {
            $period = $this->service->settlePeriod($period);
            $period = $this->service->getOrCreatePeriod($timeType);
        }

        $lastCompleted = K3Period::where('time_type', $timeType)
            ->where('status', 'completed')
            ->latest('id')
            ->first();

        $recentHistory = K3Period::where('time_type', $timeType)
            ->where('status', 'completed')
            ->latest('id')
            ->take(50)
            ->get(['period_number', 'dice_1', 'dice_2', 'dice_3', 'total_sum', 'size', 'parity', 'pattern', 'created_at']);

        $user = auth()->user();
        $settings = K3Setting::firstOrCreate(['id' => 1]);

        return response()->json([
            'period_number' => $period->period_number,
            'time_remaining' => max(0, $now->diffInSeconds($period->ends_at, false)),
            'status' => $period->status,
            'last_dice_1' => $lastCompleted ? $lastCompleted->dice_1 : 1,
            'last_dice_2' => $lastCompleted ? $lastCompleted->dice_2 : 2,
            'last_dice_3' => $lastCompleted ? $lastCompleted->dice_3 : 3,
            'last_total_sum' => $lastCompleted ? $lastCompleted->total_sum : 6,
            'last_size' => $lastCompleted ? $lastCompleted->size : 'small',
            'last_parity' => $lastCompleted ? $lastCompleted->parity : 'even',
            'user_balance' => $user ? $user->balance : null,
            'history' => $recentHistory,
            'settings' => [
                'min_bet' => $settings->min_bet,
                'max_bet' => $settings->max_bet,
                'demo_limit' => $settings->demo_limit,
                'audio_countdown_enabled' => (bool)$settings->audio_countdown_enabled,
                'audio_countdown_url' => $settings->audio_countdown_url,
                'audio_win_url' => $settings->audio_win_url,
                'audio_roll_url' => $settings->audio_roll_url
            ]
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'time_type' => 'required|in:1m,3m,5m,10m',
            'bet_type' => 'nullable|in:total,size,parity,2_same,3_same,different',
            'selected_value' => 'nullable|string',
            'bets' => 'nullable|array',
            'bets.*.bet_type' => 'required_with:bets|in:total,size,parity,2_same,3_same,different',
            'bets.*.selected_value' => 'required_with:bets|string',
            'amount' => 'required|numeric|min:0.1',
            'multiplier' => 'required|numeric|min:1',
            'is_demo' => 'nullable|boolean',
            'demo_bets_count' => 'nullable|integer'
        ]);

        try {
            $res = $this->service->processBet(auth()->user(), $request->all());
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function myHistory(Request $request) {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['history' => []]);
        }

        $timeType = $request->query('type', '1m');

        $bets = K3Bet::where('user_id', $user->id)
            ->whereHas('period', function ($q) use ($timeType) {
                $q->where('time_type', $timeType);
            })
            ->with(['period:id,period_number,dice_1,dice_2,dice_3,total_sum,size,parity,status'])
            ->latest('id')
            ->take(30)
            ->get();

        return response()->json(['history' => $bets]);
    }
}
