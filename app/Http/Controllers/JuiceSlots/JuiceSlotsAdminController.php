<?php

namespace App\Http\Controllers\JuiceSlots;

use App\Http\Controllers\Controller;
use App\Models\JuiceSlotsSetting;
use App\Models\JuiceSlotsSpin;
use Illuminate\Http\Request;

class JuiceSlotsAdminController extends Controller
{
    public function index()
    {
        $settings = JuiceSlotsSetting::firstOrCreate([], [
            'control_mode' => 'house_profit',
            'house_profit_percentage' => 70.00,
            'rtp_percentage' => 30.00,
            'win_chance_percentage' => 30.00,
            'min_bet' => 10.00,
            'max_bet' => 50000.00,
            'max_payout_per_spin' => 1000000.00,
            'is_active' => true,
        ]);

        $recentSpins = JuiceSlotsSpin::with('user')->orderBy('id', 'desc')->take(30)->get();
        $totalSpins = JuiceSlotsSpin::count();
        $totalWagered = JuiceSlotsSpin::where('is_demo', false)->sum('bet_amount');
        $totalWon = JuiceSlotsSpin::where('is_demo', false)->sum('win_amount');
        $houseProfit = $totalWagered - $totalWon;

        return view('admin.modules.juice_slots.index', compact('settings', 'recentSpins', 'totalSpins', 'totalWagered', 'totalWon', 'houseProfit'));
    }

    public function updateSettings(Request $request)
    {
        $settings = JuiceSlotsSetting::firstOrCreate([]);
        $settings->update($request->only([
            'control_mode',
            'house_profit_percentage',
            'rtp_percentage',
            'win_chance_percentage',
            'min_bet',
            'max_bet',
            'max_payout_per_spin',
            'is_active',
        ]));

        return redirect()->back()->with('success', 'Juice Slots settings updated successfully!');
    }
}
