<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FortuneGemsSetting;

class FortuneGemsSeeder extends Seeder {
    public function run(): void {
        FortuneGemsSetting::updateOrCreate(['id' => 1], [
            'game_name' => 'Fortune Gems 2',
            'min_bet' => 10.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
            'bg_music' => null,
            'spin_sound' => null,
            'win_sound' => null,
            'wheel_bonus_sound' => null,
        ]);
    }
}
