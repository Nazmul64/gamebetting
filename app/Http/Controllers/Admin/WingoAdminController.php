<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WingoSetting;
use App\Models\WingoPeriod;
use App\Models\WingoBet;
use App\Services\WingoService;
use Carbon\Carbon;

class WingoAdminController extends Controller {
    protected WingoService $service;

    public function __construct(WingoService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = WingoSetting::firstOrCreate(['id' => 1]);
        
        $stats = [
            'total_rounds' => WingoPeriod::where('status', 'completed')->count(),
            'total_real_bets' => WingoPeriod::where('status', 'completed')->sum('total_real_bets'),
            'total_payout' => WingoPeriod::where('status', 'completed')->sum('total_payout'),
            'admin_profit' => WingoPeriod::where('status', 'completed')->sum('admin_profit'),
        ];

        $livePeriods = WingoPeriod::withCount('bets')
            ->where('status', '!=', 'completed')
            ->orderBy('id', 'desc')
            ->get();

        $recentRounds = WingoPeriod::withCount('bets')
            ->where('status', 'completed')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.modules.wingo.index', compact('settings', 'stats', 'livePeriods', 'recentRounds'));
    }

    public function updateSettings(Request $request) {
        $request->validate([
            'control_mode' => 'required|in:house_profit,fixed_percentage,random',
            'win_chance_percentage' => 'required|integer|min:1|max:100',
            'min_bet' => 'required|numeric|min:0.1',
            'max_bet' => 'required|numeric|min:10',
            'demo_limit' => 'required|integer|min:0',
            'bot_status' => 'nullable|boolean',
        ]);

        $settings = WingoSetting::firstOrCreate(['id' => 1]);
        $settings->update([
            'control_mode' => $request->control_mode,
            'win_chance_percentage' => (int)$request->win_chance_percentage,
            'min_bet' => (float)$request->min_bet,
            'max_bet' => (float)$request->max_bet,
            'demo_limit' => (int)$request->demo_limit,
            'bot_status' => $request->has('bot_status') ? (bool)$request->bot_status : false,
        ]);

        return redirect()->back()->with('success', 'WinGo গেম সেটিংস সফলভাবে আপডেট করা হয়েছে!');
    }

    public function forceSettle(Request $request, $periodId) {
        $period = WingoPeriod::findOrFail($periodId);
        if ($period->status !== 'completed') {
            $this->service->settlePeriod($period);
        }
        return redirect()->back()->with('success', "পিরিয়ড {$period->period_number} সফলভাবে সেটেল করা হয়েছে!");
    }
}
