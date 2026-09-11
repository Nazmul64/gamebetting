<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LuckyJokerSetting;

class LuckyJokerSeeder extends Seeder {
    public function run(): void {
        LuckyJokerSetting::updateOrCreate(['id' => 1], [
            'game_name' => 'Lucky Joker 100',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'bg_music' => 'defaults/audio/joker/casino_ambient.mp3',
            'spin_sound' => 'defaults/audio/joker/reel_spin.mp3',
            'win_sound' => 'defaults/audio/joker/coin_payout.mp3',
            'joker_laugh_sound' => 'defaults/audio/joker/joker_wild.mp3',
        ]);
    }
}
