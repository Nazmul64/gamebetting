<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BonbonSetting;

class BonBonSettingSeeder extends Seeder {
    public function run(): void {
        BonbonSetting::updateOrCreate(['id' => 1], [
            'game_name' => 'BonBon Bonanza',
            'min_bet' => 1.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 35,
            'bg_music' => null,
            'spin_sound' => null,
            'win_sound' => null,
            'tumble_blast_sound' => null,
        ]);
    }
}
