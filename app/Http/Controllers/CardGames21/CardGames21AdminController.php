<?php

namespace App\Http\Controllers\CardGames21;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CardGames21Setting;
use App\Models\CardGames21Bet;
use App\Models\CardGames21Transaction;
use App\Services\CardGames21Service;

class CardGames21AdminController extends Controller {
    protected CardGames21Service $service;

    public function __construct(CardGames21Service $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $totalBets = CardGames21Bet::where('is_demo', false)->count();
        $totalTurnover = CardGames21Bet::where('is_demo', false)->sum('bet_amount');
        $totalPayout = CardGames21Bet::where('is_demo', false)->sum('win_amount');
        $netProfit = $totalTurnover - $totalPayout;
        $profitMargin = $totalTurnover > 0 ? round(($netProfit / $totalTurnover) * 100, 2) : 0;

        $recentBets = CardGames21Bet::with('user')->latest()->take(25)->get();

        return view('admin.modules.card_games21.index', compact(
            'settings',
            'totalBets',
            'totalTurnover',
            'totalPayout',
            'netProfit',
            'profitMargin',
            'recentBets'
        ));
    }

    public function updateSettings(Request $request) {
        $request->validate([
            'min_bet' => 'required|numeric|min:0.1',
            'max_bet' => 'required|numeric|gt:min_bet',
            'control_mode' => 'required|in:house_profit,fixed_percentage,random',
            'win_chance_percentage' => 'required|integer|min:1|max:100',
            'admin_profit_percentage' => 'required|integer|min:0|max:100',
            'win_multiplier' => 'required|numeric|min:1.0',
            'demo_default_balance' => 'required|numeric|min:10',
        ]);

        $settings = $this->service->getSettings();
        $settings->update($request->all());

        return redirect()->back()->with('success', 'Card Games 21 settings updated successfully!');
    }
}
