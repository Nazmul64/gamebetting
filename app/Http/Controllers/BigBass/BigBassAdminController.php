<?php

namespace App\Http\Controllers\BigBass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BigBassSetting;
use App\Models\BigBassSpin;
use Illuminate\Support\Facades\Storage;

class BigBassAdminController extends Controller {
    public function index() {
        $settings = BigBassSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Big Bass Splash',
            'min_bet' => 2.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 32,
        ]);
        
        $totalCollected = (float)BigBassSpin::where('is_demo', false)->sum('bet_amount');
        $totalPaidOut = (float)BigBassSpin::where('is_demo', false)->sum('win_amount');
        $adminProfit = (float)BigBassSpin::where('is_demo', false)->sum('admin_profit');
        $totalSpins = BigBassSpin::count();
        $recentSpins = BigBassSpin::with('user')->latest()->take(15)->get();

        return view('admin.modules.big_bass.index', compact(
            'settings',
            'totalCollected',
            'totalPaidOut',
            'adminProfit',
            'totalSpins',
            'recentSpins'
        ));
    }

    public function updateSettings(Request $request) {
        $settings = BigBassSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'min_bet',
            'max_bet',
            'demo_spin_limit',
            'demo_default_balance'
        ]));

        return back()->with('success', 'Big Bass Splash সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound,reel_splash_sound,fisherman_hook_sound',
            'audio_file' => 'required|mimes:mp3,wav|max:10240'
        ]);

        $settings = BigBassSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/bigbass', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'সাউন্ড ট্র্যাক সফলভাবে আপডেট হয়েছে!');
    }
}
