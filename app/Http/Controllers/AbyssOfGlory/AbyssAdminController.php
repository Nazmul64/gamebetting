<?php

namespace App\Http\Controllers\AbyssOfGlory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AbyssSetting;
use App\Models\AbyssRound;
use App\Models\AbyssBet;
use App\Models\AbyssTransaction;
use Illuminate\Support\Facades\Storage;

class AbyssAdminController extends Controller {
    public function index() {
        $settings = AbyssSetting::firstOrCreate(['id' => 1]);
        
        $totalCollected = (float)(AbyssRound::sum('real_bets_poseidon') + AbyssRound::sum('real_bets_anubis'));
        $totalPaidOut = (float)AbyssRound::sum('total_payout');
        $adminProfit = (float)AbyssRound::sum('admin_profit');
        $totalRounds = AbyssRound::count();
        $recentRounds = AbyssRound::with('bets')->latest()->take(10)->get();

        $totalUsers    = \App\Models\User::where('is_admin', false)->count();
        $totalDeposits = \App\Models\User::where('is_admin', false)->sum('balance');
        $recentUsers   = \App\Models\User::where('is_admin', false)->latest()->limit(10)->get();

        return view('admin.modules.abyss_of_glory.index', compact('settings', 'totalCollected', 'totalPaidOut', 'adminProfit', 'totalRounds', 'recentRounds', 'totalUsers', 'totalDeposits', 'recentUsers'));
    }

    public function updateSettings(Request $request) {
        $settings = AbyssSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'payout_multiplier',
            'bot_status',
            'bot_trigger_count',
            'bot_min_bet',
            'bot_max_bet',
            'min_bet',
            'max_bet',
            'demo_spin_limit',
            'demo_initial_balance',
            'round_duration_seconds'
        ]));

        return back()->with('success', 'Abyss of Glory সেটিংস আপডেট সম্পন্ন!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_magic_music,spin_sound,win_sound,god_clash_sound',
            'audio_file' => 'required|mimes:mp3,wav|max:10240'
        ]);

        $settings = AbyssSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/abyss', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'সাউন্ড ফাইল সফলভাবে আপডেট হয়েছে!');
    }
}
