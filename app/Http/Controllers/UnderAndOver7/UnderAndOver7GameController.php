<?php

namespace App\Http\Controllers\UnderAndOver7;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UnderAndOver7Service;
use App\Models\UnderAndOver7Setting;
use App\Models\UnderAndOver7Bet;

class UnderAndOver7GameController extends Controller {
    protected UnderAndOver7Service $service;

    public function __construct(UnderAndOver7Service $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $user = auth()->user();

        $historyQuery = UnderAndOver7Bet::where('status', '!=', 'pending')->latest()->take(10);
        if ($user) {
            $history = (clone $historyQuery)->where('user_id', $user->id)->get();
            if ($history->isEmpty()) {
                $history = $historyQuery->get();
            }
        } else {
            $history = $historyQuery->get();
        }

        return view('customer.under-and-over-7', compact('settings', 'history', 'user'));
    }

    public function getState() {
        $settings = $this->service->getSettings();
        $user = auth()->user();

        $history = UnderAndOver7Bet::where('status', '!=', 'pending')
            ->latest()
            ->take(10)
            ->get(['id', 'bet_choice', 'bet_amount', 'multiplier', 'die1', 'die2', 'sum', 'win_amount', 'status', 'created_at']);

        return response()->json([
            'success' => true,
            'user_balance' => $user ? (float)$user->balance : null,
            'user_currency' => $user ? $user->currency : 'EUR',
            'user_name' => $user ? $user->name : 'Guest',
            'settings' => [
                'min_bet' => (float)$settings->min_bet,
                'max_bet' => (float)$settings->max_bet,
                'over_multiplier' => (float)$settings->over_multiplier,
                'equal_multiplier' => (float)$settings->equal_multiplier,
                'under_multiplier' => (float)$settings->under_multiplier,
                'demo_default_balance' => (float)$settings->demo_default_balance,
            ],
            'history' => $history
        ]);
    }

    public function placeBet(Request $request) {
        $request->validate([
            'choice' => 'required|in:under,equal,over',
            'amount' => 'required|numeric|min:0.1',
            'is_demo' => 'required|boolean'
        ]);

        try {
            $result = $this->service->processBet(auth()->user(), $request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    public function getHistory() {
        $user = auth()->user();
        $history = UnderAndOver7Bet::where('status', '!=', 'pending')
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
