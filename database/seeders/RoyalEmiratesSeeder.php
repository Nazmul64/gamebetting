<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoyalEmiratesSetting;

class RoyalEmiratesSeeder extends Seeder {
    public function run(): void {
        RoyalEmiratesSetting::updateOrCreate(['id' => 1], [
            'game_name' => 'Royal Emirates Hold and Spin',
            'min_bet' => 1.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'mini_multiplier' => 10.00,
            'minor_multiplier' => 25.00,
            'mega_multiplier' => 50.00,
            'grand_multiplier' => 5000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 32,
            'bg_music' => null,
            'spin_sound' => null,
            'win_sound' => null,
            'coin_drop_sound' => null,
            'hold_spin_trigger_sound' => null,
        ]);
    }
}
