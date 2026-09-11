<?php

namespace App\Http\Controllers\BonBon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BonbonSetting;
use App\Models\BonbonSpin;
use Illuminate\Support\Facades\Storage;

class BonbonAdminController extends Controller {
    public function index() {
        $settings = BonbonSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'BonBon Bonanza',
            'min_bet' => 1.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
        ]);
        
        $totalCollected = (float)BonbonSpin::where('is_demo', false)->sum('bet_amount');
        $totalPaidOut = (float)BonbonSpin::where('is_demo', false)->sum('win_amount');
        $adminProfit = (float)BonbonSpin::where('is_demo', false)->sum('admin_profit');
        $totalSpins = BonbonSpin::count();
        $recentSpins = BonbonSpin::with('user')->latest()->take(15)->get();

        return view('admin.modules.bonbon.index', compact(
            'settings',
            'totalCollected',
            'totalPaidOut',
            'adminProfit',
            'totalSpins',
            'recentSpins'
        ));
    }

    public function updateSettings(Request $request) {
        $settings = BonbonSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'min_bet',
            'max_bet',
            'demo_spin_limit',
            'demo_default_balance'
        ]));

        return back()->with('success', 'BonBon Bonanza সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound,tumble_blast_sound',
            'audio_file' => 'required|mimes:mp3,wav|max:10240'
        ]);

        $settings = BonbonSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/bonbon', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'সাউন্ড ট্র্যাক সফলভাবে আপডেট হয়েছে!');
    }
}
