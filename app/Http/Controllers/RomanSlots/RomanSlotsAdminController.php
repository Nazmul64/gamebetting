<?php

namespace App\Http\Controllers\RomanSlots;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RomanSlotsSetting;
use App\Models\RomanSlotsSpin;
use App\Models\RomanSlotsTransaction;
use App\Services\RomanSlotsService;

class RomanSlotsAdminController extends Controller {
    protected RomanSlotsService $service;

    public function __construct(RomanSlotsService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        $totalSpins = RomanSlotsSpin::where('is_demo', false)->count();
        $totalTurnover = RomanSlotsSpin::where('is_demo', false)->sum('bet_amount');
        $totalPayout = RomanSlotsSpin::where('is_demo', false)->sum('win_amount');
        $netProfit = $totalTurnover - $totalPayout;
        $profitMargin = $totalTurnover > 0 ? round(($netProfit / $totalTurnover) * 100, 2) : 0;

        $recentSpins = RomanSlotsSpin::with('user')->latest()->take(25)->get();

        return view('admin.modules.roman_slots.index', compact(
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

        return redirect()->back()->with('success', 'Roman Slots settings updated successfully!');
    }
}
