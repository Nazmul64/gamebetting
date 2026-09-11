<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CasinoGameRegistry;
use App\Services\CasinoCentralTrackingService;
use Illuminate\Http\Request;

class CasinoAnalyticsController extends Controller
{
    protected CasinoCentralTrackingService $tracker;

    public function __construct(CasinoCentralTrackingService $tracker)
    {
        $this->tracker = $tracker;
    }

    public function index()
    {
        // Re-sync current figures to ensure 100% accuracy
        $this->tracker->syncHistoricData();

        $games = CasinoGameRegistry::orderBy('total_real_bets', 'desc')->get();

        // Totals across all real money engines
        $totalRealDeposit = $games->sum('total_real_deposit_volume');
        $totalRealWithdraw = $games->sum('total_real_withdraw_volume');
        $totalRealBets = $games->sum('total_real_bets');
        $totalRealPayouts = $games->sum('total_real_payouts');
        $totalPlatformProfit = $games->sum('net_house_profit');
        $totalActiveRealUsers = $games->sum('active_real_players_count');

        return view('admin.analytics.index', compact(
            'games',
            'totalRealDeposit',
            'totalRealWithdraw',
            'totalRealBets',
            'totalRealPayouts',
            'totalPlatformProfit',
            'totalActiveRealUsers'
        ));
    }

    public function getLiveJson()
    {
        $this->tracker->syncHistoricData();
        $games = CasinoGameRegistry::orderBy('total_real_bets', 'desc')->get();

        return response()->json([
            'success' => true,
            'games' => $games,
            'totals' => [
                'real_deposits' => $games->sum('total_real_deposit_volume'),
                'real_withdrawals' => $games->sum('total_real_withdraw_volume'),
                'real_bets' => $games->sum('total_real_bets'),
                'real_payouts' => $games->sum('total_real_payouts'),
                'house_profit' => $games->sum('net_house_profit'),
                'active_players' => $games->sum('active_real_players_count'),
            ]
        ]);
    }
}
