<?php

namespace App\Http\Controllers\HeadsOrTails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HeadsTailsService;
use App\Models\HeadsTailsSetting;
use App\Models\HeadsTailsRound;
use Carbon\Carbon;

class HeadsTailsGameController extends Controller {
    protected HeadsTailsService $service;

    public function __construct(HeadsTailsService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Heads or Tails',
            'min_bet' => 1.00,
            'max_bet' => 10000.00,
            'demo_toss_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
            'base_multiplier' => 1.96,
            'bot_status' => true,
            'bot_trigger_count' => 5,
            'bot_min_bet' => 10.00,
            'bot_max_bet' => 500.00,
            'round_duration_seconds' => 15,
        ]);

        // ডাইনামিক সাইডবারের জন্য বিগত ১০টি রাউন্ডের হিস্ট্রি
        $history = HeadsTailsRound::where('status', 'completed')
            ->latest()
            ->take(10)
            ->get(['round_id', 'winning_side', 'total_payout', 'created_at']);

        return view('customer.heads-or-tails', compact('settings', 'history'));
    }

    public function getGameState() {
        $round = $this->service->getActiveOrCreateRound();
        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1]);
        $now = Carbon::now();

        if ($now->greaterThanOrEqualTo($round->ends_at) && $round->status === 'betting') {
            $round = $this->service->settleRound($round);
        }

        $user = auth()->user();
        $recentHistory = HeadsTailsRound::where('status', 'completed')
            ->latest()
            ->take(10)
            ->get(['round_id', 'winning_side', 'total_payout', 'created_at']);

        return response()->json([
            'round_id' => $round->round_id,
            'status' => $round->status,
            'time_left' => max(0, $now->diffInSeconds($round->ends_at, false)),
            'total_heads' => (float)($round->real_bets_heads + $round->bot_bets_heads),
            'total_tails' => (float)($round->real_bets_tails + $round->bot_bets_tails),
            'winning_side' => $round->winning_side,
            'user_balance' => $user ? (float)$user->balance : null,
            'history' => $recentHistory,
            'settings' => [
                'min_bet' => (float)$settings->min_bet,
                'max_bet' => (float)$settings->max_bet,
                'base_multiplier' => (float)$settings->base_multiplier,
                'demo_toss_limit' => (int)$settings->demo_toss_limit,
                'demo_default_balance' => (float)$settings->demo_default_balance,
            ],
            'audio' => [
                'bg' => $settings->bg_sea_music ? asset('storage/' . $settings->bg_sea_music) : null,
                'flip' => $settings->coin_flip_sound ? asset('storage/' . $settings->coin_flip_sound) : null,
                'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                'loss' => $settings->loss_sound ? asset('storage/' . $settings->loss_sound) : null,
            ]
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'side' => 'required|in:heads,tails',
            'amount' => 'required|numeric|min:0.1',
            'is_demo' => 'required|boolean',
            'demo_toss_done' => 'nullable|integer'
        ]);

        try {
            $res = $this->service->processBet(auth()->user(), $request->all());
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function instantToss(Request $request) {
        $request->validate([
            'side' => 'required|in:heads,tails',
            'amount' => 'required|numeric|min:0.1',
            'is_demo' => 'required|boolean',
            'step' => 'nullable|integer',
            'demo_toss_done' => 'nullable|integer'
        ]);

        try {
            $res = $this->service->instantToss(auth()->user(), $request->all());
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
