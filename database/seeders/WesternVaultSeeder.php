<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WesternVaultSetting;

class WesternVaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WesternVaultSetting::updateOrCreate(
            ['id' => 1],
            [
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
                'bg_music' => 'assets/audio/western/western_bg.wav',
                'spin_sound' => 'assets/audio/western/western_spin.wav',
                'win_sound' => 'assets/audio/western/western_win.wav',
            ]
        );
    }
}
