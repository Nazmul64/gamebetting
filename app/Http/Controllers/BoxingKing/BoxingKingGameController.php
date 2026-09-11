<?php

namespace App\Http\Controllers\BoxingKing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BoxingKingService;
use App\Services\CasinoCentralTrackingService;
use App\Models\BoxingKingSetting;

class BoxingKingGameController extends Controller {
    protected BoxingKingService $service;
    protected CasinoCentralTrackingService $tracker;

    public function __construct(BoxingKingService $service, CasinoCentralTrackingService $tracker) {
        $this->service = $service;
        $this->tracker = $tracker;
    }

    public function index() {
        $settings = BoxingKingSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Boxing King',
            'min_bet' => 3.00,
            'max_bet' => 10000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'win_chance_percentage' => 30,
            'control_mode' => 'house_profit',
        ]);

        // Default to real mode heartbeat when user enters game page
        if (auth()->check()) {
            $this->tracker->heartbeat('boxing_king', auth()->id(), false);
        }

        return view('customer.boxing-king', compact('settings'));
    }

    public function spin(Request $request) {
        $request->validate([
            'bet_amount' => 'required|numeric|min:0.5',
            'is_demo' => 'required|boolean',
            'demo_spins_count' => 'nullable|integer'
        ]);

        $isDemo = (bool)$request->is_demo;

        // Record heartbeat
        if (auth()->check()) {
            $this->tracker->heartbeat('boxing_king', auth()->id(), $isDemo);
        }

        try {
            $data = $this->service->executeSpin(
                auth()->user(),
                (float)$request->bet_amount,
                $isDemo,
                (int)($request->demo_spins_count ?? 0)
            );

            // Record in Central Ledger only if REAL MONEY
            if (!$isDemo) {
                $this->tracker->recordRealTransaction(
                    'boxing_king',
                    (float)$request->bet_amount,
                    (float)($data['win_amount'] ?? 0)
                );
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
