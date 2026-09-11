<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeadsTailsSetting;

class HeadsTailsSettingSeeder extends Seeder {
    public function run(): void {
        HeadsTailsSetting::updateOrCreate(['id' => 1], [
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
            'bg_sea_music' => 'defaults/audio/headstails/sea_ambient.mp3',
            'coin_flip_sound' => 'defaults/audio/headstails/coin_spin.mp3',
            'win_sound' => 'defaults/audio/headstails/mermaid_cheer.mp3',
            'loss_sound' => 'defaults/audio/headstails/water_splash.mp3',
        ]);
    }
}
