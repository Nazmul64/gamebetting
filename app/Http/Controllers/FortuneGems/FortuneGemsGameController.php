<?php

namespace App\Http\Controllers\FortuneGems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FortuneGemsService;
use App\Models\FortuneGemsSetting;

class FortuneGemsGameController extends Controller {
    protected FortuneGemsService $service;

    public function __construct(FortuneGemsService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = FortuneGemsSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Fortune Gems 2',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
        ]);
        return view('customer.fortune-gems-2', compact('settings'));
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
