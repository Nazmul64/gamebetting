<?php

namespace App\Http\Controllers\CardGames21;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CardGames21Service;
use App\Models\CardGames21Bet;
use Exception;

class CardGames21GameController extends Controller {
    protected CardGames21Service $service;

    public function __construct(CardGames21Service $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $user = auth()->user();
        return view('customer.card-games-21', compact('settings', 'user'));
    }

    public function getState() {
        $settings = $this->service->getSettings();
        $user = auth()->user();

        $history = CardGames21Bet::where('status', '!=', 'pending')
            ->latest()
            ->take(10)
            ->get(['id', 'bet_amount', 'multiplier', 'win_amount', 'player_score', 'dealer_score', 'status', 'created_at']);

        return response()->json([
            'success' => true,
            'user_balance' => $user ? (float)$user->balance : null,
            'user_currency' => $user ? $user->currency : 'BDT',
            'user_name' => $user ? $user->name : 'Guest',
            'settings' => [
                'min_bet' => (float)$settings->min_bet,
                'max_bet' => (float)$settings->max_bet,
                'win_multiplier' => (float)$settings->win_multiplier,
                'demo_default_balance' => (float)$settings->demo_default_balance,
            ],
            'history' => $history
        ]);
    }

    public function startRound(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:0.1',
            'is_demo' => 'required|boolean'
        ]);

        try {
            $result = $this->service->startRound(auth()->user(), $request->all());
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    public function hit(Request $request) {
        try {
            $result = $this->service->hit(auth()->user(), $request->all());
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    public function stand(Request $request) {
        try {
            $result = $this->service->stand(auth()->user(), $request->all());
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
}
