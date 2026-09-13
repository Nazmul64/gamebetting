<?php

namespace App\Http\Controllers\RoyalEmirates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoyalEmiratesService;
use App\Models\RoyalEmiratesSetting;

class RoyalEmiratesGameController extends Controller {
    protected RoyalEmiratesService $service;

    public function __construct(RoyalEmiratesService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = RoyalEmiratesSetting::firstOrCreate(['id' => 1]);
        return view('customer.royal-emirates', compact('settings'));
    }

    public function spin(Request $request) {
        $request->validate([
            'bet_amount' => 'required|numeric|min:0.1',
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
