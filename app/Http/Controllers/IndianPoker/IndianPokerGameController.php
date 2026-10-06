<?php

namespace App\Http\Controllers\IndianPoker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\IndianPokerService;
use App\Models\IndianPokerBet;
use Exception;

class IndianPokerGameController extends Controller {
    protected IndianPokerService $service;

    public function __construct(IndianPokerService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $user = auth()->user();
        return view('customer.indian-poker', compact('settings', 'user'));
    }

    public function getState() {
        $settings = $this->service->getSettings();
        $user = auth()->user();

        $history = IndianPokerBet::where('status', '!=', 'pending')
            ->latest()
            ->take(10)
            ->get(['id', 'bet_amount', 'multiplier', 'win_amount', 'card1', 'card2', 'card3', 'hand_type', 'status', 'created_at']);

        return response()->json([
            'success' => true,
            'user_balance' => $user ? (float)$user->balance : null,
            'user_currency' => $user ? $user->currency : 'BDT',
            'user_name' => $user ? $user->name : 'Guest',
            'settings' => [
                'min_bet' => (float)$settings->min_bet,
                'max_bet' => (float)$settings->max_bet,
                'pair_multiplier' => (float)$settings->pair_multiplier,
                'flush_multiplier' => (float)$settings->flush_multiplier,
                'straight_multiplier' => (float)$settings->straight_multiplier,
                'three_multiplier' => (float)$settings->three_multiplier,
                'sf_multiplier' => (float)$settings->sf_multiplier,
                'demo_default_balance' => (float)$settings->demo_default_balance,
            ],
            'history' => $history
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:0.1',
            'is_demo' => 'required|boolean'
        ]);

        try {
            $result = $this->service->processBet(auth()->user(), $request->all());
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    public function getHistory() {
        $user = auth()->user();
        $history = IndianPokerBet::where('status', '!=', 'pending')
            ->when($user, function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })
            ->latest()
            ->take(15)
            ->get();

        return response()->json([
            'success' => true,
            'history' => $history
        ]);
    }
}
