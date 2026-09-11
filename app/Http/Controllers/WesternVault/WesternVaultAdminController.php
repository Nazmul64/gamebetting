<?php

namespace App\Http\Controllers\WesternVault;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WesternVaultSetting;
use App\Models\WesternVaultRound;
use App\Models\WesternVaultTransaction;
use Illuminate\Support\Facades\Storage;

class WesternVaultAdminController extends Controller {
    
    public function index() {
        $settings = WesternVaultSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Western Vault',
            'min_bet' => 10.00,
            'max_bet' => 50000.00,
            'demo_initial_balance' => 10000.00,
            'house_edge_percent' => 5.00,
            'win_chance_percentage' => 35,
            'control_mode' => 'house_profit',
            'bot_status' => true,
            'bot_trigger_player_count' => 10,
            'bot_min_bet' => 50.00,
            'bot_max_bet' => 2000.00,
            'round_duration' => 25,
        ]);
        $recentRounds = WesternVaultRound::latest()->take(15)->get();

        $totalCollected = WesternVaultRound::sum('real_bets_total_a') + WesternVaultRound::sum('real_bets_total_b');
        $totalPaidOut = WesternVaultRound::sum('total_payout');
        $netProfit = WesternVaultRound::sum('admin_profit');

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'settings' => $settings,
                'recentRounds' => $recentRounds,
                'totalCollected' => $totalCollected,
                'totalPaidOut' => $totalPaidOut,
                'netProfit' => $netProfit,
            ]);
        }

        return view('admin.modules.western_vault.index', compact('settings', 'recentRounds', 'totalCollected', 'totalPaidOut', 'netProfit'));
    }

    public function updateSettings(Request $request) {
        $settings = WesternVaultSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'win_chance_percentage',
            'control_mode',
            'bot_status',
            'bot_trigger_player_count',
            'min_bet',
            'max_bet',
            'round_duration',
            'demo_initial_balance',
            'house_edge_percent',
            'bot_min_bet',
            'bot_max_bet'
        ]));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Western Vault কনফিগারেশন আপডেট সম্পন্ন!',
                'settings' => $settings->fresh()
            ]);
        }

        return back()->with('success', 'Western Vault কনফিগারেশন আপডেট সম্পন্ন!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound',
            'audio_file' => 'required|mimes:mp3,wav,ogg|max:10240'
        ]);

        $settings = WesternVaultSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/western_vault', 'public');
        $settings->update([$type => $path]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'অডিও সফলভাবে সেভ হয়েছে!',
                'path' => asset('storage/' . $path)
            ]);
        }

        return back()->with('success', 'অডিও সফলভাবে সেভ হয়েছে!');
    }

    public function ledgerIndex() {
        $transactions = WesternVaultTransaction::with('user')->latest()->paginate(25);
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'transactions' => $transactions
            ]);
        }

        return view('admin.modules.western_vault.ledger', compact('transactions'));
    }
}
