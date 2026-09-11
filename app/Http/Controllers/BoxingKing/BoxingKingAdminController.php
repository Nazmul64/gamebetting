<?php

namespace App\Http\Controllers\BoxingKing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoxingKingSetting;
use App\Models\BoxingKingSpin;
use App\Models\BoxingKingTransaction;
use Illuminate\Support\Facades\Storage;

class BoxingKingAdminController extends Controller {
    public function index() {
        $settings = BoxingKingSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Boxing King',
            'min_bet' => 3.00,
            'max_bet' => 10000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'win_chance_percentage' => 30,
            'control_mode' => 'house_profit',
        ]);
        
        // নিট প্রফিট অ্যানালিটিক্স
        $totalBets = BoxingKingSpin::where('is_demo', false)->sum('bet_amount');
        $totalPayout = BoxingKingSpin::where('is_demo', false)->sum('win_amount');
        $adminProfit = BoxingKingSpin::where('is_demo', false)->sum('admin_profit');
        $recentSpins = BoxingKingSpin::with('user')->latest()->take(20)->get();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'settings' => $settings,
                'totalBets' => $totalBets,
                'totalPayout' => $totalPayout,
                'adminProfit' => $adminProfit,
                'recentSpins' => $recentSpins,
            ]);
        }

        return view('admin.modules.boxing_king.index', compact('settings', 'totalBets', 'totalPayout', 'adminProfit', 'recentSpins'));
    }

    public function updateSettings(Request $request) {
        $settings = BoxingKingSetting::firstOrCreate(['id' => 1]);
        $settings->update($request->only([
            'win_chance_percentage',
            'control_mode',
            'demo_spin_limit',
            'min_bet',
            'max_bet',
            'demo_default_balance'
        ]));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Boxing King সেটিংস সফলভাবে আপডেট হয়েছে!',
                'settings' => $settings->fresh()
            ]);
        }

        return back()->with('success', 'Boxing King সেটিংস সফলভাবে আপডেট হয়েছে!');
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:bg_music,spin_sound,win_sound,fire_burn_sound',
            'audio_file' => 'required|mimes:mp3,wav,ogg|max:10240'
        ]);

        $settings = BoxingKingSetting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;

        if ($settings->$type && !str_starts_with($settings->$type, 'assets/')) {
            Storage::disk('public')->delete($settings->$type);
        }

        $path = $request->file('audio_file')->store('audio/boxing_king', 'public');
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

    public function recentSpins() {
        $spins = BoxingKingSpin::with('user')->latest()->paginate(25);
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'spins' => $spins
            ]);
        }
        return response()->json(['spins' => $spins]);
    }
}
