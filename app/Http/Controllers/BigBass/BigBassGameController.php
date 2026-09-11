<?php

namespace App\Http\Controllers\BigBass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BigBassGameService;
use App\Models\BigBassSetting;

class BigBassGameController extends Controller {
    protected BigBassGameService $service;

    public function __construct(BigBassGameService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = BigBassSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Big Bass Splash',
            'min_bet' => 2.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 32,
        ]);
        return view('customer.big-bass-splash', compact('settings'));
    }

    public function spin(Request $request) {
        $request->validate([
            'bet_amount' => 'required|numeric|min:1',
            'is_demo' => 'required|boolean',
            'demo_spins_count' => 'nullable|integer',
            'is_buy_bonus' => 'nullable|boolean'
        ]);

        try {
            $data = $this->service->executeSpin(
                auth()->user(),
                (float)$request->bet_amount,
                (bool)$request->is_demo,
                (int)($request->demo_spins_count ?? 0),
                (bool)($request->is_buy_bonus ?? false)
            );
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
