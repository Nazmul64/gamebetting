<?php

namespace App\Http\Controllers\BonBon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BonbonGameService;
use App\Models\BonbonSetting;

class BonbonGameController extends Controller {
    protected BonbonGameService $service;

    public function __construct(BonbonGameService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = BonbonSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'BonBon Bonanza',
            'min_bet' => 1.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
        ]);
        return view('customer.bonbon-bonanza', compact('settings'));
    }

    public function spin(Request $request) {
        $request->validate([
            'bet_amount' => 'required|numeric|min:1',
            'is_demo' => 'required|boolean',
            'demo_spins_count' => 'nullable|integer',
            'scatter_boost' => 'nullable|boolean'
        ]);

        try {
            $data = $this->service->executeSpin(
                auth()->user(),
                (float)$request->bet_amount,
                (bool)$request->is_demo,
                (int)($request->demo_spins_count ?? 0),
                (bool)($request->scatter_boost ?? false)
            );
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
