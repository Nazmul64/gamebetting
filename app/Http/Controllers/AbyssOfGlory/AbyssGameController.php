<?php

namespace App\Http\Controllers\AbyssOfGlory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AbyssGameService;
use App\Models\AbyssSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbyssGameController extends Controller {
    protected AbyssGameService $service;

    public function __construct(AbyssGameService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = AbyssSetting::firstOrCreate(['id' => 1]);
        $user = Auth::user();

        if (Auth::check()) {
            try {
                if (class_exists(\App\Services\CasinoCentralTrackingService::class)) {
                    app(\App\Services\CasinoCentralTrackingService::class)->heartbeat('temple_of_fortune', Auth::id(), false);
                }
            } catch (\Exception $e) {}
        }

        return view('customer.temple-of-fortune', compact('settings', 'user'));
    }

    public function getGameState() {
        $settings = AbyssSetting::firstOrCreate(['id' => 1]);
        $round = $this->service->getActiveOrCreateRound();
        $now = Carbon::now();

        if ($now->greaterThanOrEqualTo($round->ends_at) && $round->status === 'betting') {
            $round = $this->service->settleRound($round);
            // Create or get fresh active round for betting
            $round = $this->service->getActiveOrCreateRound();
        }

        $user = Auth::user();
        $timeLeft = max(0, (int)$now->diffInSeconds($round->ends_at, false));
        if ($timeLeft > (int)$settings->round_duration_seconds) {
            $timeLeft = (int)$settings->round_duration_seconds;
        }

        return response()->json([
            'round_id' => $round->round_id,
            'status' => $round->status,
            'time_left' => $timeLeft,
            'total_poseidon' => (float)($round->real_bets_poseidon + $round->bot_bets_poseidon),
            'total_anubis' => (float)($round->real_bets_anubis + $round->bot_bets_anubis),
            'winning_side' => $round->winning_side,
            'grid' => $round->grid_matrix,
            'user_balance' => $user ? (float)$user->balance : null,
            'audio' => [
                'bg' => $settings->bg_magic_music ? asset('storage/' . $settings->bg_magic_music) : null,
                'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                'clash' => $settings->god_clash_sound ? asset('storage/' . $settings->god_clash_sound) : null,
            ]
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'side' => 'required|in:poseidon,anubis',
            'amount' => 'required|numeric|min:0.40',
            'is_demo' => 'required|boolean',
            'demo_spins_done' => 'nullable|integer'
        ]);

        try {
            $res = $this->service->processBet(Auth::user(), $request->all());
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
