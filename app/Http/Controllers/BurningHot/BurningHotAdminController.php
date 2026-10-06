<?php

namespace App\Http\Controllers\BurningHot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BurningHotSetting;
use App\Models\BurningHotSpin;
use App\Models\BurningHotTransaction;
use App\Services\BurningHotService;

class BurningHotAdminController extends Controller {
    protected BurningHotService $service;

    public function __construct(BurningHotService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $totalSpins = BurningHotSpin::where('is_demo', false)->count();
        $totalTurnover = BurningHotSpin::where('is_demo', false)->sum('bet_amount');
        $totalPayout = BurningHotSpin::where('is_demo', false)->sum('win_amount');
        $netProfit = $totalTurnover - $totalPayout;
        $profitMargin = $totalTurnover > 0 ? round(($netProfit / $totalTurnover) * 100, 2) : 0;

        $recentSpins = BurningHotSpin::with('user')->latest()->take(25)->get();

        return view('admin.modules.burning_hot.index', compact(
            'settings',
            'totalSpins',
            'totalTurnover',
            'totalPayout',
            'netProfit',
            'profitMargin',
            'recentSpins'
        ));
    }

    public function updateSettings(Request $request) {
        $request->validate([
            'min_bet' => 'required|numeric|min:0.1',
            'max_bet' => 'required|numeric|gt:min_bet',
            'control_mode' => 'required|in:house_profit,fixed_percentage,random',
            'win_chance_percentage' => 'required|integer|min:1|max:100',
            'admin_profit_percentage' => 'required|integer|min:0|max:100',
            'demo_default_balance' => 'required|numeric|min:10',
        ]);

        $settings = $this->service->getSettings();
        $settings->update($request->all());

        return redirect()->back()->with('success', 'Burning Hot settings updated successfully!');
    }
}
