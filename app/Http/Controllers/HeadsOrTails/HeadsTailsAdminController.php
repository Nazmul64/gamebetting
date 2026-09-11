<?php

namespace App\Http\Controllers\HeadsOrTails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeadsTailsSetting;
use App\Models\HeadsTailsRound;
use App\Models\HeadsTailsBet;
use Illuminate\Support\Facades\Storage;

class HeadsTailsAdminController extends Controller {
    public function index() {
        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Heads or Tails',
            'min_bet' => 1.00,
            'max_bet' => 10000.00,
            'demo_toss_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
            'base_multiplier' => 1.96,
            'bot_status' => true,
            'bot_trigger_count' => 5,
            'bot_min_bet' => 10.00,
            'bot_max_bet' => 500.00,
            'round_duration_seconds' => 15,
        ]);
        
        $totalCollected = (float)(HeadsTailsRound::sum('real_bets_heads') + HeadsTailsRound::sum('real_bets_tails'));
        $totalPaidOut = (float)HeadsTailsRound::sum('total_payout');
        $adminProfit = (float)HeadsTailsRound::sum('admin_profit');
        $totalRounds = HeadsTailsRound::count();

        $recentRounds = HeadsTailsRound::with(['bets.user'])->latest()->take(15)->get();

        return view('admin.modules.heads_tails.index', compact(
            'settings',
            'totalCollected',
            'totalPaidOut',
            'adminProfit',
            'totalRounds',
            'recentRounds'
        ));
    }

    public function updateSettings(Request $request) {
        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'game_name',
            'control_mode',
            'win_chance_percentage',
            'base_multiplier',
            'bot_status',
            'bot_trigger_count',
            'bot_min_bet',
            'bot_max_bet',
            'min_bet',
            'max_bet',
            'demo_toss_limit',
            'demo_default_balance',
            'round_duration_seconds'
        ]));

        return back()->with('success', 'Heads or Tails সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_sea_music,coin_flip_sound,win_sound,loss_sound',
            'audio_file' => 'required|mimes:mp3,wav|max:10240'
        ]);

        $settings = HeadsTailsSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'defaults/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/headstails', 'public');
        $settings->update([$type => $path]);

        return back()->with('success', 'অডিও ফাইল সফলভাবে আপডেট হয়েছে!');
    }
}
