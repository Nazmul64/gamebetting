<?php

namespace App\Http\Controllers\JuiceSlots;

use App\Http\Controllers\Controller;
use App\Services\JuiceSlotsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JuiceSlotsGameController extends Controller
{
    protected JuiceSlotsService $service;

    public function __construct(JuiceSlotsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('customer.juice-slots');
    }

    public function getState()
    {
        $settings = $this->service->getSettings();
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'balance' => $user ? (float)$user->balance : 1000.0,
            'is_auth' => Auth::check(),
            'min_bet' => $settings->min_bet,
            'max_bet' => $settings->max_bet,
        ]);
    }

    public function spin(Request $request)
    {
        $validated = $request->validate([
            'bet_amount' => 'required|numeric|min:1',
            'is_demo' => 'nullable|boolean',
        ]);

        $betAmount = (float) $validated['bet_amount'];
        $isDemo = (bool) ($validated['is_demo'] ?? false);

        if (!$isDemo && !Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to play with real money.'
            ], 401);
        }

        $user = Auth::check() ? Auth::user() : new \App\Models\User(['balance' => 1000.0, 'id' => 0]);

        try {
            $result = $this->service->spin($user, $betAmount, $isDemo);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
