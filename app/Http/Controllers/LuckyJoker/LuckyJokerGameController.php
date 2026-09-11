<?php

namespace App\Http\Controllers\LuckyJoker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LuckyJokerService;
use App\Models\LuckyJokerSetting;

class LuckyJokerGameController extends Controller {
    protected LuckyJokerService $service;

    public function __construct(LuckyJokerService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = LuckyJokerSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Lucky Joker 100',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
        ]);
        return view('customer.lucky-joker-100', compact('settings'));
    }

    public function getState() {
        $settings = LuckyJokerSetting::firstOrCreate(['id' => 1]);
        $user = auth()->user();

        return response()->json([
            'game_name' => $settings->game_name,
            'user_balance' => $user ? (float)$user->balance : null,
            'min_bet' => (float)$settings->min_bet,
            'max_bet' => (float)$settings->max_bet,
            'demo_spin_limit' => (int)$settings->demo_spin_limit,
            'demo_default_balance' => (float)$settings->demo_default_balance,
            'audio' => [
                'bg' => $settings->bg_music ? asset('storage/' . $settings->bg_music) : null,
                'spin' => $settings->spin_sound ? asset('storage/' . $settings->spin_sound) : null,
                'win' => $settings->win_sound ? asset('storage/' . $settings->win_sound) : null,
                'wild' => $settings->joker_laugh_sound ? asset('storage/' . $settings->joker_laugh_sound) : null,
            ]
        ]);
    }

    public function spin(Request $request) {
        $request->validate([
            'bet_amount' => 'required|numeric|min:1',
            'is_demo' => 'required|boolean',
            'demo_spins_count' => 'nullable|integer'
        ]);

        try {
            $data = $this->service->executeSpin(
                auth()->user(),
                (float)$request->bet_amount,
                (bool)$request->is_demo,
                (int)($request->demo_spins_count ?? 0)
            );
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
