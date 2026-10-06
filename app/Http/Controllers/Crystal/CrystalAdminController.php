<?php

namespace App\Http\Controllers\Crystal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CrystalSetting;
use App\Models\CrystalSpin;
use App\Models\CrystalTransaction;
use App\Services\CrystalService;

class CrystalAdminController extends Controller {
    protected CrystalService $service;

    public function __construct(CrystalService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $totalSpins = CrystalSpin::where('is_demo', false)->count();
        $totalTurnover = CrystalSpin::where('is_demo', false)->sum('bet_amount');
        $totalPayout = CrystalSpin::where('is_demo', false)->sum('win_amount');
        $netProfit = $totalTurnover - $totalPayout;
        $profitMargin = $totalTurnover > 0 ? round(($netProfit / $totalTurnover) * 100, 2) : 0;

        $recentSpins = CrystalSpin::with('user')->latest()->take(25)->get();

        return view('admin.modules.crystal.index', compact(
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

        return redirect()->back()->with('success', 'Crystal Slot settings updated successfully!');
    }
}
