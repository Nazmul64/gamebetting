<?php

namespace App\Http\Controllers\TheEmirate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmirateGameService;
use App\Models\EmirateSetting;

class EmirateGameController extends Controller {
    protected EmirateGameService $service;

    public function __construct(EmirateGameService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = EmirateSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'The Emirate',
            'min_bet' => 5.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
        ]);
        return view('customer.the-emirate', compact('settings'));
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
