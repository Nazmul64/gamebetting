<?php

namespace App\Http\Controllers\FortuneGems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FortuneGemsSetting;
use App\Models\FortuneGemsSpin;
use Illuminate\Support\Facades\Storage;

class FortuneGemsAdminController extends Controller {
    public function index() {
        $settings = FortuneGemsSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Fortune Gems 2',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
        ]);
        
        $totalCollected = (float)FortuneGemsSpin::where('is_demo', false)->sum('bet_amount');
        $totalPaidOut = (float)FortuneGemsSpin::where('is_demo', false)->sum('win_amount');
        $adminProfit = (float)FortuneGemsSpin::where('is_demo', false)->sum('admin_profit');
        $totalSpins = FortuneGemsSpin::count();
        $recentSpins = FortuneGemsSpin::with('user')->latest()->take(15)->get();

        return view('admin.modules.fortune_gems.index', compact(
            'settings',
            'totalCollected',
            'totalPaidOut',
            'adminProfit',
            'totalSpins',
            'recentSpins'
        ));
    }

    public function updateSettings(Request $request) {
        $settings = FortuneGemsSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'min_bet',
            'max_bet',
            'demo_spin_limit',
            'demo_default_balance'
        ]));

        return back()->with('success', 'Fortune Gems 2 সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound,wheel_bonus_sound',
            'audio_file' => 'required|mimes:mp3,wav|max:10240'
        ]);

        $settings = FortuneGemsSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/gems', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'সাউন্ড ট্র্যাক সফলভাবে আপডেট হয়েছে!');
    }
}
