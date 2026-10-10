<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\WesternVaultSetting;
use App\Models\HeadsTailsSetting;
use App\Models\LuckyJokerSetting;
use App\Models\FortuneGemsSetting;
use App\Models\BonbonSetting;
use App\Models\BigBassSetting;
use App\Models\EmirateSetting;
use App\Models\RoyalEmiratesSetting;
use App\Models\AbyssSetting;
use App\Models\BoxingKingSetting;
use App\Models\BurningHotSetting;
use App\Models\CrystalSetting;
use App\Models\CardGames21Setting;
use App\Models\IndianPokerSetting;
use App\Models\UnderAndOver7Setting;
use App\Models\RomanSlotsSetting;
use App\Models\EasterSlotsSetting;
use App\Models\JuiceSlotsSetting;

class GameAudioSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crash Games: 5 Distinct Flight Musics + 5 Distinct Countdown Ticks
        $crashGames = [
            'helicopterx' => [
                'bg'   => '/assets/audio/games/helicopterx_bg.mp3',
                'tick' => '/assets/audio/games/countdown_helicopterx.mp3',
            ],
            '1xaero' => [
                'bg'   => '/assets/audio/games/1xaero_bg.mp3',
                'tick' => '/assets/audio/games/countdown_1xaero.mp3',
            ],
            'aero' => [
                'bg'   => '/assets/audio/games/aero_bg.mp3',
                'tick' => '/assets/audio/games/countdown_aero.mp3',
            ],
            'crashx' => [
                'bg'   => '/assets/audio/games/crashx_bg.mp3',
                'tick' => '/assets/audio/games/countdown_crashx.mp3',
            ],
            'crash' => [
                'bg'   => '/assets/audio/games/crash_bg.mp3',
                'tick' => '/assets/audio/games/countdown_crash.mp3',
            ],
        ];

        foreach ($crashGames as $cg => $audio) {
            Setting::updateOrCreate(
                ['key' => "game_bg_music_{$cg}"],
                ['value' => $audio['bg']]
            );
            Setting::updateOrCreate(
                ['key' => "game_countdown_sound_{$cg}"],
                ['value' => $audio['tick']]
            );
        }

        // 2. Slot & Table Games Model Specific Mapping
        $gameSettingMap = [
            WesternVaultSetting::class => '/assets/audio/games/western_vault_bg.mp3',
            HeadsTailsSetting::class   => '/assets/audio/games/heads_or_tails_bg.mp3',
            LuckyJokerSetting::class   => '/assets/audio/games/lucky_joker_100_bg.mp3',
            FortuneGemsSetting::class  => '/assets/audio/games/fortune_gems_bg.mp3',
            BonbonSetting::class       => '/assets/audio/games/bonbon_bonanza_bg.mp3',
            BigBassSetting::class      => '/assets/audio/games/big_bass_splash_bg.mp3',
            EmirateSetting::class      => '/assets/audio/games/the_emirate_bg.mp3',
            RoyalEmiratesSetting::class=> '/assets/audio/games/royal_emirates_bg.mp3',
            AbyssSetting::class        => '/assets/audio/games/abyss_of_glory_bg.mp3',
            BoxingKingSetting::class   => '/assets/audio/games/boxing_king_bg.mp3',
            BurningHotSetting::class   => '/assets/audio/games/burning_hot_bg.mp3',
            CrystalSetting::class      => '/assets/audio/games/crystal_bg.mp3',
            CardGames21Setting::class  => '/assets/audio/games/card_games_21_bg.mp3',
            IndianPokerSetting::class  => '/assets/audio/games/indian_poker_bg.mp3',
            UnderAndOver7Setting::class=> '/assets/audio/games/under_and_over_7_bg.mp3',
            RomanSlotsSetting::class   => '/assets/audio/games/roman_slot_bg.mp3',
            EasterSlotsSetting::class  => '/assets/audio/games/easter_slot_bg.mp3',
            JuiceSlotsSetting::class   => '/assets/audio/games/juice_slots_bg.mp3',
        ];

        foreach ($gameSettingMap as $modelClass => $defaultAudio) {
            if (class_exists($modelClass)) {
                try {
                    $row = $modelClass::first();
                    if ($row) {
                        $row->update(['bg_music' => $defaultAudio]);
                    } else {
                        $modelClass::create(['bg_music' => $defaultAudio]);
                    }
                } catch (\Throwable $e) {
                    // Ignore
                }
            }
        }

        // 3. Global and per-game Setting table records (30+ distinct games)
        $gameAudioMapping = [
            'helicopterx'       => '/assets/audio/games/helicopterx_bg.mp3',
            '1xaero'            => '/assets/audio/games/1xaero_bg.mp3',
            'aero'              => '/assets/audio/games/aero_bg.mp3',
            'crashx'            => '/assets/audio/games/crashx_bg.mp3',
            'crash'             => '/assets/audio/games/crash_bg.mp3',
            'olympus'           => '/assets/audio/games/olympus_bg.mp3',
            'western-vault'     => '/assets/audio/games/western_vault_bg.mp3',
            'boxing-king'       => '/assets/audio/games/boxing_king_bg.mp3',
            'fortune-gems-2'    => '/assets/audio/games/fortune_gems_2_bg.mp3',
            'abyss-of-glory'    => '/assets/audio/games/abyss_of_glory_bg.mp3',
            'heads-or-tails'    => '/assets/audio/games/heads_or_tails_bg.mp3',
            'under-and-over-7'  => '/assets/audio/games/under_and_over_7_bg.mp3',
            'lucky-joker-100'   => '/assets/audio/games/lucky_joker_100_bg.mp3',
            'bonbon-bonanza'    => '/assets/audio/games/bonbon_bonanza_bg.mp3',
            'big-bass-splash'   => '/assets/audio/games/big_bass_splash_bg.mp3',
            'the-emirate'       => '/assets/audio/games/the_emirate_bg.mp3',
            'royal-emirates'    => '/assets/audio/games/royal_emirates_bg.mp3',
            'indian-poker'      => '/assets/audio/games/indian_poker_bg.mp3',
            'card-games-21'     => '/assets/audio/games/card_games_21_bg.mp3',
            'roman-slot'        => '/assets/audio/games/roman_slot_bg.mp3',
            'easter-slot'       => '/assets/audio/games/easter_slot_bg.mp3',
            'juice-slots'       => '/assets/audio/games/juice_slots_bg.mp3',
            'crystal'           => '/assets/audio/games/crystal_bg.mp3',
            'burning-hot'       => '/assets/audio/games/burning_hot_bg.mp3',
            'wingo'             => '/assets/audio/games/wingo_bg.mp3',
            'k3'                => '/assets/audio/games/k3_bg.mp3',
            'trxwingo'          => '/assets/audio/games/trxwingo_bg.mp3',
            'super-ace-deluxe'  => '/assets/audio/games/super_ace_deluxe_bg.mp3',
            'mega-ace'          => '/assets/audio/games/mega_ace_bg.mp3',
            'ali-baba'          => '/assets/audio/games/ali_baba_bg.mp3',
            'golden-empire'     => '/assets/audio/games/golden_empire_bg.mp3',
            'fortune-gems'      => '/assets/audio/games/fortune_gems_bg.mp3',
            'temple-of-fortune' => '/assets/audio/games/temple_of_fortune_bg.mp3',
            'treasure-climb'    => '/assets/audio/games/treasure_climb_bg.mp3',
            'gems-mines'        => '/assets/audio/games/gems_mines_bg.mp3',
            'elves-kingdom'     => '/assets/audio/games/elves_kingdom_bg.mp3',
        ];

        foreach ($gameAudioMapping as $slug => $audioFile) {
            Setting::updateOrCreate(['key' => "game_bg_music_{$slug}"], ['value' => $audioFile]);
        }

        Setting::updateOrCreate(['key' => 'game_bg_music'], ['value' => '/assets/audio/games/helicopterx_bg.mp3']);
        Setting::updateOrCreate(['key' => 'game_countdown_sound'], ['value' => '/assets/audio/games/countdown_helicopterx.mp3']);
        Setting::updateOrCreate(['key' => 'lottery_bg_music'], ['value' => '/assets/audio/games/lottery_bg.mp3']);
    }
}

