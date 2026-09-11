<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BigBassSetting;

class BigBassSettingSeeder extends Seeder {
    public function run(): void {
        BigBassSetting::updateOrCreate(['id' => 1], [
            'game_name' => 'Big Bass Splash',
            'min_bet' => 2.00,
            'max_bet' => 5000.00,
            'demo_spin_limit' => 3,
            'demo_default_balance' => 10000.00,
            'control_mode' => 'house_profit',
            'win_chance_percentage' => 32,
            'bg_music' => 'defaults/audio/bigbass/underwater_ambient.mp3',
            'spin_sound' => 'defaults/audio/bigbass/reel_spin.mp3',
            'win_sound' => 'defaults/audio/bigbass/splash_win.mp3',
            'reel_splash_sound' => 'defaults/audio/bigbass/water_splash.mp3',
            'fisherman_hook_sound' => 'defaults/audio/bigbass/fisherman_cast.mp3',
        ]);
    }
}
