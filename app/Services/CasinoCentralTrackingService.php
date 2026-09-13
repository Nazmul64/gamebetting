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

        // Verify user is not admin
        $user = \App\Models\User::find($userId);
        if (!$user || $user->is_admin) {
            return;
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
            'active_real_players_count' => $activeCount
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
     * Seed or sync historical data from all 15 game tables into registry.
     */
    public function syncHistoricData(): void
    {
        $games = [
            'helicopterx'     => 'HelicopterX',
            '1xaero'          => '1xAero',
            'aero'            => 'Aero',
            'crashx'          => 'CrashX',
            'crash'           => 'Crash (1xGames)',
            'olympus_gold'    => 'Olympus Gold™',
            'western_vault'   => 'Western Vault™',
            'fortune_gems_2'  => 'Fortune Gems 2™',
            'boxing_king'     => 'Boxing King™',
            'abyss_of_glory'  => 'Abyss of Glory™',
            'heads_or_tails'  => 'Heads or Tails™',
            'lucky_joker_100' => 'Lucky Joker 100™',
            'bonbon_bonanza'  => 'BonBon Bonanza™',
            'big_bass_splash' => 'Big Bass Splash™',
            'the_emirate'     => 'The Emirate™',
            'royal_emirates'  => 'Royal Emirates: Hold and Spin™',
        ];

        foreach ($games as $key => $name) {
            $reg = CasinoGameRegistry::firstOrCreate(
                ['game_key' => $key],
                ['name' => $name, 'is_active' => true]
            );

            $bets = 0.0;
            $payouts = 0.0;
            $players = 0;

            if (in_array($key, ['helicopterx', '1xaero', 'aero', 'crashx', 'crash'])) {
                if (Schema::hasTable('game_bets')) {
                    $prefixMap = [
                        'helicopterx' => 'HX-%',
                        '1xaero'      => 'AX-%',
                        'aero'        => 'AE-%',
                        'crashx'      => 'CX-%',
                        'crash'       => 'RC-%',
                    ];
                    $prefix = $prefixMap[$key] ?? 'HX-%';
                    $bets = (float) DB::table('game_bets')->where('round_id', 'like', $prefix)->sum('bet_amount');
                    $payouts = (float) DB::table('game_bets')->where('round_id', 'like', $prefix)->where('result', 'won')->sum('winnings');
                    $players = DB::table('game_bets')->where('round_id', 'like', $prefix)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
                }
            } elseif ($key === 'boxing_king' && Schema::hasTable('boxing_king_spins')) {
                $bets = (float) DB::table('boxing_king_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('boxing_king_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('boxing_king_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'western_vault' && Schema::hasTable('western_vault_bets')) {
                $bets = (float) DB::table('western_vault_bets')->where('is_demo', false)->where('is_bot', false)->sum('bet_amount');
                $payouts = (float) DB::table('western_vault_bets')->where('is_demo', false)->where('is_bot', false)->sum('win_amount');
                $players = DB::table('western_vault_bets')->where('is_demo', false)->where('is_bot', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'olympus_gold' && Schema::hasTable('olympus_rounds')) {
                $bets = (float) DB::table('olympus_rounds')->where('mode', 'real')->sum('total_deducted');
                $payouts = (float) DB::table('olympus_rounds')->where('mode', 'real')->sum('final_win');
                $players = DB::table('olympus_rounds')->where('mode', 'real')->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'fortune_gems_2' && Schema::hasTable('fortune_gems_spins')) {
                $bets = (float) DB::table('fortune_gems_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('fortune_gems_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('fortune_gems_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'abyss_of_glory' && Schema::hasTable('abyss_bets')) {
                $bets = (float) DB::table('abyss_bets')->where('is_demo', false)->where('is_bot', false)->sum('bet_amount');
                $payouts = (float) DB::table('abyss_bets')->where('is_demo', false)->where('is_bot', false)->sum('win_amount');
                $players = DB::table('abyss_bets')->where('is_demo', false)->where('is_bot', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'heads_or_tails' && Schema::hasTable('heads_tails_bets')) {
                $bets = (float) DB::table('heads_tails_bets')->where('is_demo', false)->where('is_bot', false)->sum('bet_amount');
                $payouts = (float) DB::table('heads_tails_bets')->where('is_demo', false)->where('is_bot', false)->sum('win_amount');
                $players = DB::table('heads_tails_bets')->where('is_demo', false)->where('is_bot', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'lucky_joker_100' && Schema::hasTable('lucky_joker_spins')) {
                $bets = (float) DB::table('lucky_joker_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('lucky_joker_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('lucky_joker_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'bonbon_bonanza' && Schema::hasTable('bonbon_spins')) {
                $bets = (float) DB::table('bonbon_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('bonbon_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('bonbon_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'big_bass_splash' && Schema::hasTable('big_bass_spins')) {
                $bets = (float) DB::table('big_bass_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('big_bass_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('big_bass_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'the_emirate' && Schema::hasTable('emirate_spins')) {
                $bets = (float) DB::table('emirate_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('emirate_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('emirate_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            } elseif ($key === 'royal_emirates' && Schema::hasTable('royal_emirates_spins')) {
                $bets = (float) DB::table('royal_emirates_spins')->where('is_demo', false)->sum('bet_amount');
                $payouts = (float) DB::table('royal_emirates_spins')->where('is_demo', false)->sum('win_amount');
                $players = DB::table('royal_emirates_spins')->where('is_demo', false)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
            }

            // Real active sessions in last 5 minutes (if any)
            $liveSessions = CasinoGameSession::where('game_key', $key)
                ->where('is_demo', false)
                ->where('last_action_at', '>=', Carbon::now()->subMinutes(5))
                ->count();

            $reg->total_real_bets = $bets;
            $reg->total_real_payouts = $payouts;
            $reg->net_house_profit = $bets - $payouts;
            $reg->active_real_players_count = $liveSessions > 0 ? $liveSessions : $players;

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
