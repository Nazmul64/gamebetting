<?php

namespace App\Http\Controllers\TheEmirate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmirateSetting;
use App\Models\EmirateSpin;
use Illuminate\Support\Facades\Storage;

class EmirateAdminController extends Controller {
    public function index() {
        $settings = EmirateSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'The Emirate',
            'min_bet' => 5.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
        ]);
        
        $totalCollected = (float)EmirateSpin::where('is_demo', false)->sum('bet_amount');
        $totalPaidOut = (float)EmirateSpin::where('is_demo', false)->sum('win_amount');
        $adminProfit = (float)EmirateSpin::where('is_demo', false)->sum('admin_profit');
        $totalSpins = EmirateSpin::count();
        $recentSpins = EmirateSpin::with('user')->latest()->take(15)->get();

        return view('admin.modules.the_emirate.index', compact(
            'settings',
            'totalCollected',
            'totalPaidOut',
            'adminProfit',
            'totalSpins',
            'recentSpins'
        ));
    }

    public function updateSettings(Request $request) {
        $settings = EmirateSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'min_bet',
            'max_bet',
            'demo_spin_limit',
            'demo_default_balance'
        ]));

        return back()->with('success', 'The Emirate সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound,scatter_sound',
            'audio_file' => 'required|mimes:mp3,wav|max:10240'
        ]);

        $settings = EmirateSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/emirate', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'সাউন্ড ট্র্যাক সফলভাবে আপডেট হয়েছে!');
    }
}
