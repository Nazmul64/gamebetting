<?php

namespace App\Http\Controllers\LuckyJoker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LuckyJokerSetting;
use App\Models\LuckyJokerSpin;
use Illuminate\Support\Facades\Storage;

class LuckyJokerAdminController extends Controller {
    public function index() {
        $settings = LuckyJokerSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Lucky Joker 100',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
        ]);
        
        $totalCollected = (float)LuckyJokerSpin::where('is_demo', false)->sum('bet_amount');
        $totalPaidOut = (float)LuckyJokerSpin::where('is_demo', false)->sum('win_amount');
        $adminProfit = (float)LuckyJokerSpin::where('is_demo', false)->sum('admin_profit');
        $totalSpins = LuckyJokerSpin::count();
        $recentSpins = LuckyJokerSpin::with('user')->latest()->take(15)->get();

        return view('admin.modules.lucky_joker.index', compact(
            'settings',
            'totalCollected',
            'totalPaidOut',
            'adminProfit',
            'totalSpins',
            'recentSpins'
        ));
    }

    public function updateSettings(Request $request) {
        $settings = LuckyJokerSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'min_bet',
            'max_bet',
            'demo_spin_limit',
            'demo_default_balance'
        ]));

        return back()->with('success', 'Lucky Joker 100 সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound,joker_laugh_sound',
            'audio_file' => 'required|mimes:mp3,wav|max:10240'
        ]);

        $settings = LuckyJokerSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/joker', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'সাউন্ড ফাইল সফলভাবে আপডেট হয়েছে!');
    }
}
