<?php

namespace App\Http\Controllers\IndianPoker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndianPokerSetting;
use App\Models\IndianPokerBet;
use App\Models\IndianPokerTransaction;
use App\Services\IndianPokerService;

class IndianPokerAdminController extends Controller {
    protected IndianPokerService $service;

    public function __construct(IndianPokerService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $totalBets = IndianPokerBet::where('is_demo', false)->count();
        $totalTurnover = IndianPokerBet::where('is_demo', false)->sum('bet_amount');
        $totalPayout = IndianPokerBet::where('is_demo', false)->sum('win_amount');
        $netProfit = $totalTurnover - $totalPayout;
        $profitMargin = $totalTurnover > 0 ? round(($netProfit / $totalTurnover) * 100, 2) : 0;

        $recentBets = IndianPokerBet::with('user')->latest()->take(25)->get();

        return view('admin.modules.indian_poker.index', compact(
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
            'pair_multiplier' => 'required|numeric|min:0.1',
            'flush_multiplier' => 'required|numeric|min:0.1',
            'straight_multiplier' => 'required|numeric|min:0.1',
            'three_multiplier' => 'required|numeric|min:0.1',
            'sf_multiplier' => 'required|numeric|min:0.1',
            'demo_default_balance' => 'required|numeric|min:10',
        ]);

        $settings = $this->service->getSettings();
        $settings->update($request->all());

        return redirect()->back()->with('success', 'Indian Poker settings updated successfully!');
    }
}
