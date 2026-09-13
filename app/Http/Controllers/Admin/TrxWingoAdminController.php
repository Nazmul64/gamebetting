<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrxWingoSetting;
use App\Models\TrxWingoPeriod;
use App\Models\TrxWingoBet;
use App\Services\TrxWingoService;
use Carbon\Carbon;

class TrxWingoAdminController extends Controller {
    protected TrxWingoService $service;

    public function __construct(TrxWingoService $service) {
        $this->service = $service;
    }

    public function index() {
        $settings = $this->service->getSettings();
        
        $stats = [
            'total_rounds' => TrxWingoPeriod::where('status', 'completed')->count(),
            'total_real_bets' => (float)TrxWingoPeriod::where('status', 'completed')->sum('total_real_bets'),
            'total_payout' => (float)TrxWingoPeriod::where('status', 'completed')->sum('total_payout'),
            'admin_profit' => (float)TrxWingoPeriod::where('status', 'completed')->sum('admin_profit'),
        ];

        // Fetch live active periods
        $livePeriods = TrxWingoPeriod::with(['bets' => function($q) {
                $q->where('is_bot', false)->where('is_demo', false);
            }])
            ->where('status', '!=', 'completed')
            ->orderBy('id', 'desc')
            ->get();

        // Calculate live payout simulation for each live period
        $livePayoutSimulations = [];
        foreach ($livePeriods as $lp) {
            $sim = [];
            for ($n = 0; $n <= 9; $n++) {
                $sim[$n] = $this->service->calculatePotentialPayout($lp->id, $n);
            }
            $livePayoutSimulations[$lp->id] = $sim;
        }

        $recentRounds = TrxWingoPeriod::withCount('bets')
            ->where('status', 'completed')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.modules.trxwingo.index', compact(
            'settings',
            'stats',
            'livePeriods',
            'livePayoutSimulations',
            'recentRounds'
        ));
    }

    public function updateSettings(Request $request) {
        $request->validate([
            'control_mode' => 'required|in:house_profit,fixed_percentage,random,manual',
            'win_chance_percentage' => 'required|integer|min:1|max:100',
            'min_bet' => 'required|numeric|min:0.1',
            'max_bet' => 'required|numeric|min:10',
            'demo_limit' => 'required|integer|min:0',
            'bot_status' => 'nullable|boolean',
            'bot_trigger_count' => 'required|integer|min:1|max:20',
            'next_force_number' => 'nullable|integer|min:0|max:9',
            'how_to_play_rules' => 'nullable|string',
        ]);

        $settings = $this->service->getSettings();
        $settings->update([
            'control_mode' => $request->control_mode,
            'win_chance_percentage' => (int)$request->win_chance_percentage,
            'min_bet' => (float)$request->min_bet,
            'max_bet' => (float)$request->max_bet,
            'demo_limit' => (int)$request->demo_limit,
            'bot_status' => $request->has('bot_status') ? (bool)$request->bot_status : false,
            'bot_trigger_count' => (int)$request->bot_trigger_count,
            'next_force_number' => $request->filled('next_force_number') ? (int)$request->next_force_number : null,
            'how_to_play_rules' => $request->how_to_play_rules,
        ]);

        return redirect()->back()->with('success', 'TrxWinGo গেম সেটিংস সফলভাবে আপডেট করা হয়েছে!');
    }

    public function forceSettle(Request $request, $periodId) {
        $period = TrxWingoPeriod::findOrFail($periodId);
        if ($period->status !== 'completed') {
            if ($request->filled('force_number')) {
                $settings = $this->service->getSettings();
                $settings->update(['next_force_number' => (int)$request->force_number]);
            }
            $this->service->settlePeriod($period);
        }
        return redirect()->back()->with('success', "TrxWinGo পিরিয়ড {$period->period_number} সফলভাবে সেটেল করা হয়েছে!");
    }
}
