<?php

namespace App\Http\Controllers\UnderAndOver7;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnderAndOver7Setting;
use App\Models\UnderAndOver7Bet;

class UnderAndOver7AdminController extends Controller {
    public function index() {
        $settings = UnderAndOver7Setting::firstOrCreate(['id' => 1], [
            'game_name' => 'Under and Over 7',
            'min_bet' => 1.00,
            'max_bet' => 50000.00,
            'over_multiplier' => 2.30,
            'equal_multiplier' => 5.80,
            'under_multiplier' => 2.30,
            'demo_default_balance' => 100.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 45,
        ]);

        $totalRealBets = UnderAndOver7Bet::where('is_demo', false)->sum('bet_amount');
        $totalRealPayout = UnderAndOver7Bet::where('is_demo', false)->where('status', 'won')->sum('win_amount');
        $netProfit = $totalRealBets - $totalRealPayout;
        $totalPlays = UnderAndOver7Bet::count();
        $recentBets = UnderAndOver7Bet::with('user')->latest()->take(20)->get();

        return view('admin.modules.under_and_over7.index', compact(
            'settings',
            'totalRealBets',
            'totalRealPayout',
            'netProfit',
            'totalPlays',
            'recentBets'
        ));
    }

    public function updateSettings(Request $request) {
        $settings = UnderAndOver7Setting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'over_multiplier',
            'equal_multiplier',
            'under_multiplier',
            'min_bet',
            'max_bet',
            'demo_default_balance',
        ]));

        return back()->with('success', 'Under and Over 7 settings updated successfully!');
    }
}
