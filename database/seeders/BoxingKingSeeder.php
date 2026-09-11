<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BoxingKingSetting;

class BoxingKingSeeder extends Seeder
{
    public function run(): void
    {
        BoxingKingSetting::firstOrCreate(['id' => 1], [
            'game_name' => 'Boxing King',
            'min_bet' => 3.00,
            'max_bet' => 10000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 1000.00,
            'win_chance_percentage' => 30,
            'control_mode' => 'house_profit',
            'bg_music' => 'assets/audio/western/western_bg.wav',
            'spin_sound' => 'assets/audio/western/western_spin.wav',
            'win_sound' => 'assets/audio/western/western_win.wav',
            'fire_burn_sound' => 'assets/audio/western/western_win.wav',
        ]);
    }
}
