<?php

namespace App\Http\Controllers\RoyalEmirates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoyalEmiratesSetting;
use App\Models\RoyalEmiratesSpin;
use Illuminate\Support\Facades\Storage;

class RoyalEmiratesAdminController extends Controller {
    public function index() {
        $settings = RoyalEmiratesSetting::firstOrCreate(['id' => 1]);
        
        $totalCollected = (float)RoyalEmiratesSpin::where('is_demo', false)->sum('bet_amount');
        $totalPaidOut = (float)RoyalEmiratesSpin::where('is_demo', false)->sum('win_amount');
        $adminProfit = (float)RoyalEmiratesSpin::where('is_demo', false)->sum('admin_profit');
        $recentSpins = RoyalEmiratesSpin::with('user')->orderBy('id', 'desc')->limit(20)->get();

        return view('admin.modules.royal_emirates.index', compact('settings', 'totalCollected', 'totalPaidOut', 'adminProfit', 'recentSpins'));
    }

    public function updateSettings(Request $request) {
        $settings = RoyalEmiratesSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'control_mode',
            'win_chance_percentage',
            'min_bet',
            'max_bet',
            'demo_spin_limit',
            'mini_multiplier',
            'minor_multiplier',
            'mega_multiplier',
            'grand_multiplier'
        ]));

        return back()->with('success', 'Royal Emirates সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound,coin_drop_sound,hold_spin_trigger_sound',
            'audio_file' => 'required|mimes:mp3,wav,ogg|max:10240'
        ]);

        $settings = RoyalEmiratesSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/royal_emirates', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'সাউন্ড ফাইল সফলভাবে আপডেট হয়েছে!');
    }
}
