<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AbyssSetting;

class AbyssSettingSeeder extends Seeder {
    public function run(): void {
        AbyssSetting::updateOrCreate(['id' => 1], [
            'game_name' => 'Abyss of Glory',
            'min_bet' => 0.40,
            'max_bet' => 10000.00,
            'demo_spin_limit' => 3,
            'demo_initial_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'payout_multiplier' => 1.95,
            'bot_status' => true,
            'bot_trigger_count' => 5,
            'bot_min_bet' => 50.00,
            'bot_max_bet' => 2000.00,
            'round_duration_seconds' => 25,
            'bg_magic_music' => 'defaults/audio/abyss/temple_magic.mp3',
            'spin_sound' => 'defaults/audio/abyss/reel_spin.mp3',
            'win_sound' => 'defaults/audio/abyss/victory_epic.mp3',
            'god_clash_sound' => 'defaults/audio/abyss/thunder_clash.mp3',
        ]);
    }
}
