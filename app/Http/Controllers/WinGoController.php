<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WingoService;
use App\Models\WingoSetting;
use App\Models\WingoPeriod;
use App\Models\WingoBet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WinGoController extends Controller {
    protected WingoService $service;

    public function __construct(WingoService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = WingoSetting::firstOrCreate(['id' => 1]);
        $user = Auth::user();
        return view('games.wingo', compact('settings', 'user'));
    }

    public function getState(Request $request) {
        $timeType = $request->query('type', '30s');
        if (!in_array($timeType, ['30s', '1m', '3m', '5m'])) {
            $timeType = '30s';
        }

        $period = $this->service->getOrCreatePeriod($timeType);
        $now = Carbon::now();

        // যদি বর্তমান পিরিয়ডের সময় শেষ হয়ে থাকে এবং স্ট্যাটাস এখনও betting থাকে, তবে settle করা হবে
        if ($now->greaterThanOrEqualTo($period->ends_at) && $period->status === 'betting') {
            $this->service->settlePeriod($period);
            // সেটেল করার পর তাৎক্ষণিক পরবর্তী নতুন পিরিয়ড রিটার্ন হবে
            $period = $this->service->getOrCreatePeriod($timeType);
        }

        $user = Auth::user();
        $recentHistory = WingoPeriod::where('time_type', $timeType)
            ->where('status', 'completed')
            ->orderBy('id', 'desc')
            ->take(100)
            ->get(['period_number', 'winning_number', 'winning_color', 'winning_size']);



        $timeRemaining = max(0, $now->diffInSeconds($period->ends_at, false));

        return response()->json([
            'period_number' => $period->period_number,
            'time_remaining' => $timeRemaining,
            'status' => $period->status,
            'user_balance' => $user ? (float)$user->balance : null,
            'history' => $recentHistory
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'time_type' => 'required|in:30s,1m,3m,5m',
            'bet_type' => 'required|in:color,number,size',
            'selected_value' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'multiplier' => 'required|numeric|min:1',
            'is_demo' => 'nullable',
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
        if (!$user) {
            return response()->json(['bets' => []]);
        }

        $timeType = $request->query('type', '30s');
        $bets = WingoBet::with('period')
            ->where('user_id', $user->id)
            ->where('is_demo', false)
            ->whereHas('period', function($q) use ($timeType) {
                if ($timeType) {
                    $q->where('time_type', $timeType);
                }
            })
            ->orderBy('id', 'desc')
            ->take(50)
            ->get();

        return response()->json(['bets' => $bets]);
    }
}
