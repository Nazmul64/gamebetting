<?php

namespace App\Http\Controllers\Crystal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CrystalService;
use App\Models\CrystalSpin;
use Exception;

class CrystalGameController extends Controller {
    protected CrystalService $service;

    public function __construct(CrystalService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $user = auth()->user();
        return view('customer.crystal', compact('settings', 'user'));
    }

    public function getState() {
        $settings = $this->service->getSettings();
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'user_balance' => $user ? (float)$user->balance : null,
            'user_currency' => $user ? $user->currency : 'BDT',
            'user_name' => $user ? $user->name : 'Guest',
            'settings' => [
                'min_bet' => (float)$settings->min_bet,
                'max_bet' => (float)$settings->max_bet,
                'demo_default_balance' => (float)$settings->demo_default_balance,
            ]
        ]);
    }

    public function spin(Request $request) {
        $request->validate([
            'bet' => 'required|numeric|min:0.1',
            'is_demo' => 'required|boolean'
        ]);

        try {
            $result = $this->service->executeSpin(auth()->user(), $request->all());
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
}
