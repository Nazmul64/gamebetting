<?php

namespace App\Services;

use App\Models\CasinoGameRegistry;
use App\Models\CasinoGameSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CasinoCentralTrackingService
{
    /**
     * User Activity Heartbeat Ping.
     * Demo players are strictly excluded from real user counts.
     */
    public function heartbeat(string $gameKey, ?int $userId, bool $isDemo = false): void
    {
        if ($isDemo || !$userId) {
            return; // Demo players are not counted in real active user statistics
        }

        CasinoGameSession::updateOrCreate(
            ['user_id' => $userId, 'game_key' => $gameKey],
            ['is_demo' => false, 'last_action_at' => Carbon::now()]
        );

        // Count real users active within the last 5 minutes
        $activeCount = CasinoGameSession::where('game_key', $gameKey)
            ->where('is_demo', false)
            ->where('last_action_at', '>=', Carbon::now()->subMinutes(5))
            ->count();

        CasinoGameRegistry::where('game_key', $gameKey)->update([
            'active_real_players_count' => max($activeCount, 1)
        ]);
    }

    /**
     * Record real money transaction and evaluate Game RTP & House Health.
     */
    public function recordRealTransaction(string $gameKey, float $betAmount, float $winAmount): void
    {
        if ($betAmount <= 0 && $winAmount <= 0) {
            return;
        }

        DB::transaction(function () use ($gameKey, $betAmount, $winAmount) {
            $game = CasinoGameRegistry::where('game_key', $gameKey)->lockForUpdate()->first();
            if (!$game) {
                // Auto-create if not yet registered
                $game = CasinoGameRegistry::create([
                    'game_key' => $gameKey,
                    'name'     => ucwords(str_replace('_', ' ', $gameKey)),
                    'is_active'=> true,
                ]);
            }

            $game->total_real_bets += $betAmount;
            $game->total_real_payouts += $winAmount;
            $game->net_house_profit = $game->total_real_bets - $game->total_real_payouts;

            // Health Status Determination based on Payout Ratio / RTP
            if ($game->total_real_bets > 0) {
                $payoutRatio = ($game->total_real_payouts / $game->total_real_bets) * 100;
                if ($payoutRatio > 95) {
                    $game->health_status = 'critical_loss'; // High payout risk
                } elseif ($payoutRatio >= 70 && $payoutRatio <= 95) {
                    $game->health_status = 'balanced';
                } else {
                    $game->health_status = 'healthy'; // Profitable
                }
            } else {
                $game->health_status = 'healthy';
            }

            $game->save();
        });
    }

    /**
     * Record real deposit / withdraw volume attributed to game.
     */
    public function recordFinancialVolume(string $gameKey, float $deposit = 0.0, float $withdraw = 0.0): void
    {
        CasinoGameRegistry::where('game_key', $gameKey)->update([
            'total_real_deposit_volume'  => DB::raw("total_real_deposit_volume + $deposit"),
            'total_real_withdraw_volume' => DB::raw("total_real_withdraw_volume + $withdraw"),
        ]);
    }

    /**
     * Seed or sync historical data from all game tables into registry.
     */
    public function syncHistoricData(): void
    {
        $games = [
            'boxing_king' => 'Boxing King (Ring Champion)',
            'aviator_crash' => 'Aviator Crash (1xGames)',
            'western_vault' => 'Western Vault',
            'olympus_gold' => 'Olympus Gold (Gates of Olympus)',
            'gems_mines' => 'Gems & Mines',
            'big_bass_splash' => 'Big Bass Splash'
        ];

        foreach ($games as $key => $name) {
            $reg = CasinoGameRegistry::firstOrCreate(
                ['game_key' => $key],
                ['name' => $name, 'is_active' => true]
            );

            // Calculate historic totals from respective tables if available
            $bets = 0.0;
            $payouts = 0.0;
            $players = 0;

            if ($key === 'boxing_king' && Schema::hasTable('boxing_king_spins')) {
                $bets = (float) DB::table('boxing_king_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('boxing_king_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('boxing_king_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'aviator_crash' && Schema::hasTable('game_bets')) {
                $bets = (float) DB::table('game_bets')->sum('bet_amount');
                $payouts = (float) DB::table('game_bets')->where('result', 'won')->sum('winnings');
                $players = DB::table('game_bets')->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'western_vault' && Schema::hasTable('western_vault_bets')) {
                $bets = (float) DB::table('western_vault_bets')->where('is_demo', false)->where('is_bot', false)->sum('bet_amount');
                $payouts = (float) DB::table('western_vault_bets')->where('is_demo', false)->where('is_bot', false)->sum('win_amount');
                $players = DB::table('western_vault_bets')->where('is_demo', false)->where('is_bot', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'olympus_gold' && Schema::hasTable('olympus_rounds')) {
                $bets = (float) DB::table('olympus_rounds')->where('mode', 'real')->sum('total_deducted');
                $payouts = (float) DB::table('olympus_rounds')->where('mode', 'real')->sum('final_win');
                $players = DB::table('olympus_rounds')->where('mode', 'real')->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            }

            $reg->total_real_bets = $bets;
            $reg->total_real_payouts = $payouts;
            $reg->net_house_profit = $bets - $payouts;
            $reg->active_real_players_count = max($players, 1);

            if ($bets > 0) {
                $payoutRatio = ($payouts / $bets) * 100;
                $reg->health_status = ($payoutRatio > 95) ? 'critical_loss' : (($payoutRatio >= 70) ? 'balanced' : 'healthy');
            } else {
                $reg->health_status = 'healthy';
            }

            $reg->save();
        }
    }
}
