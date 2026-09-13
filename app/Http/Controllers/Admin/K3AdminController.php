<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\K3Setting;
use App\Models\K3Period;
use App\Models\K3Bet;
use App\Services\K3Service;
use Carbon\Carbon;

class K3AdminController extends Controller {
    protected K3Service $service;

    public function __construct(K3Service $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = K3Setting::firstOrCreate(['id' => 1]);
        
        $stats = [
            'total_rounds' => K3Period::where('status', 'completed')->count(),
            'total_real_bets' => K3Period::where('status', 'completed')->sum('total_real_bets'),
            'total_payout' => K3Period::where('status', 'completed')->sum('total_payout'),
            'admin_profit' => K3Period::where('status', 'completed')->sum('admin_profit'),
        ];

        $livePeriods = K3Period::withCount('bets')
            ->where('status', '!=', 'completed')
            ->orderBy('id', 'desc')
            ->get();

        $recentRounds = K3Period::withCount('bets')
            ->where('status', 'completed')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.modules.k3.index', compact('settings', 'stats', 'livePeriods', 'recentRounds'));
    }

    public function updateSettings(Request $request) {
        $request->validate([
            'control_mode' => 'required|in:house_profit,fixed_percentage,random,manual',
            'win_chance_percentage' => 'required|integer|min:1|max:100',
            'min_bet' => 'required|numeric|min:0.1',
            'max_bet' => 'required|numeric|min:10',
            'demo_limit' => 'required|integer|min:0',
            'bot_status' => 'nullable|boolean',
            'audio_countdown_enabled' => 'nullable|boolean',
            'audio_countdown_url' => 'nullable|string',
            'audio_win_url' => 'nullable|string',
            'audio_roll_url' => 'nullable|string',
            'how_to_play_rules' => 'nullable|string'
        ]);

        $settings = K3Setting::firstOrCreate(['id' => 1]);
        $settings->update([
            'control_mode' => $request->control_mode,
            'win_chance_percentage' => (int)$request->win_chance_percentage,
            'min_bet' => (float)$request->min_bet,
            'max_bet' => (float)$request->max_bet,
            'demo_limit' => (int)$request->demo_limit,
            'bot_status' => $request->has('bot_status') ? (bool)$request->bot_status : false,
            'audio_countdown_enabled' => $request->has('audio_countdown_enabled') ? (bool)$request->audio_countdown_enabled : false,
            'audio_countdown_url' => $request->audio_countdown_url,
            'audio_win_url' => $request->audio_win_url,
            'audio_roll_url' => $request->audio_roll_url,
            'how_to_play_rules' => $request->how_to_play_rules
        ]);

        return redirect()->back()->with('success', 'K3 লটারি সেটিংস সফলভাবে আপডেট করা হয়েছে!');
    }

    public function forceSettle(Request $request, $periodId) {
        $period = K3Period::findOrFail($periodId);
        if ($period->status !== 'completed') {
            $manualDice = null;
            if ($request->filled('dice_1') && $request->filled('dice_2') && $request->filled('dice_3')) {
                $manualDice = [
                    (int)$request->input('dice_1'),
                    (int)$request->input('dice_2'),
                    (int)$request->input('dice_3')
                ];
            }
            $this->service->settlePeriod($period, $manualDice);
        }
        return redirect()->back()->with('success', "K3 পিরিয়ড {$period->period_number} সফলভাবে সেটেল করা হয়েছে!");
    }

    public function uploadAudio(Request $request) {
        $request->validate([
            'audio_type' => 'required|in:audio_countdown_url,audio_win_url,audio_roll_url',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg,aac|max:10240'
        ]);

        $file = $request->file('audio_file');
        $filename = time() . '_' . $request->audio_type . '.' . $file->getClientOriginalExtension();
        $destination = public_path('assets/audio/k3');
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }
        $file->move($destination, $filename);
        $url = '/assets/audio/k3/' . $filename;

        $settings = K3Setting::firstOrCreate(['id' => 1]);
        $type = $request->audio_type;
        $settings->$type = $url;
        $settings->save();

        return redirect()->back()->with('success', 'অডিও ফাইল সফলভাবে আপলোড করা হয়েছে!');
    }
}
