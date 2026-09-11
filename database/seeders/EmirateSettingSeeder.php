<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmirateSetting;

class EmirateSettingSeeder extends Seeder {
    public function run(): void {
        EmirateSetting::updateOrCreate(['id' => 1], [
            'game_name' => 'The Emirate',
            'min_bet' => 5.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 30,
            'bg_music' => 'defaults/audio/emirate/arabic_lounge.mp3',
            'spin_sound' => 'defaults/audio/emirate/mechanical_spin.mp3',
            'win_sound' => 'defaults/audio/emirate/dubai_coins.mp3',
            'scatter_sound' => 'defaults/audio/emirate/palm_jingle.mp3',
        ]);
    }
}
