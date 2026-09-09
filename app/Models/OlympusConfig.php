<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlympusConfig extends Model
{
    use HasFactory;

    protected $table = 'olympus_configs';

    protected $fillable = [
        'game_name',
        'game_status',
        'demo_enabled',
        'real_enabled',
        'demo_play_limit',
        'demo_starting_balance',
        'login_popup_enabled',
        'min_bet',
        'max_bet',
        'default_bet',
        'buy_free_spins_multiplier',
        'double_chance_ante_pct',
        'rtp_percentage',
        'volatility',
        'required_scatters_for_free_spins',
        'free_spins_count',
        'max_multiplier',
        'paytable_json',
        'multipliers_json',
        'bet_options_json',
    ];

    protected $casts = [
        'demo_enabled'                     => 'boolean',
        'real_enabled'                     => 'boolean',
        'login_popup_enabled'             => 'boolean',
        'demo_play_limit'                 => 'integer',
        'demo_starting_balance'           => 'float',
        'min_bet'                         => 'float',
        'max_bet'                         => 'float',
        'default_bet'                     => 'float',
        'buy_free_spins_multiplier'       => 'float',
        'double_chance_ante_pct'          => 'float',
        'rtp_percentage'                  => 'float',
        'required_scatters_for_free_spins'=> 'integer',
        'free_spins_count'                => 'integer',
        'max_multiplier'                  => 'integer',
        'paytable_json'                   => 'array',
        'multipliers_json'                => 'array',
        'bet_options_json'                => 'array',
    ];

    /**
     * Get or create the active singleton Olympus game configuration.
     */
    public static function getActiveConfig(): self
    {
        $config = self::first();

        if (!$config) {
            $config = self::createDefaultConfig();
        }

        return $config;
    }

    /**
     * Create and return initial default configuration.
     */
    public static function createDefaultConfig(): self
    {
        $defaultPaytable = [
            // Shapes 1 to 3 (Low Tier Gems: Yellow, Green, Cyan)
            '1' => ['match_8_9' => 0.25, 'match_10_11' => 0.75, 'match_12_plus' => 2.00],
            '2' => ['match_8_9' => 0.40, 'match_10_11' => 0.90, 'match_12_plus' => 4.00],
            '3' => ['match_8_9' => 0.50, 'match_10_11' => 1.00, 'match_12_plus' => 5.00],
            
            // Shapes 4 to 6 (Mid Tier: Purple, Red, Blue)
            '4' => ['match_8_9' => 0.80, 'match_10_11' => 1.20, 'match_12_plus' => 8.00],
            '5' => ['match_8_9' => 1.00, 'match_10_11' => 1.50, 'match_12_plus' => 10.00],
            '6' => ['match_8_9' => 1.50, 'match_10_11' => 2.00, 'match_12_plus' => 12.00],

            // Shapes 7 to 9 (High Tier Artifacts: Chalice, Ring, Crown)
            '7' => ['match_8_9' => 1.50, 'match_10_11' => 5.00, 'match_12_plus' => 15.00],
            '8' => ['match_8_9' => 2.50, 'match_10_11' => 10.00, 'match_12_plus' => 25.00],
            '9' => ['match_8_9' => 10.00, 'match_10_11' => 25.00, 'match_12_plus' => 50.00],
            
            // Scatter (Zeus: 10.png)
            'scatter' => ['match_4' => 3.00, 'match_5' => 15.00, 'match_6' => 100.00]
        ];

        $defaultMultipliers = [
            ['label' => '2X',   'value' => 2,   'tone' => 'tone-orange', 'weight' => 50],
            ['label' => '5X',   'value' => 5,   'tone' => 'tone-purple', 'weight' => 25],
            ['label' => '10X',  'value' => 10,  'tone' => 'tone-pink',   'weight' => 12],
            ['label' => '25X',  'value' => 25,  'tone' => 'tone-blue',   'weight' => 7],
            ['label' => '50X',  'value' => 50,  'tone' => 'tone-blue',   'weight' => 3],
            ['label' => '100X', 'value' => 100, 'tone' => 'tone-red',    'weight' => 2],
            ['label' => '500X', 'value' => 500, 'tone' => 'tone-red',    'weight' => 1],
        ];

        $defaultBetOptions = [1.00, 2.00, 5.00, 10.00, 20.00, 50.00, 100.00, 200.00, 500.00];

        return self::create([
            'game_name'                        => 'Olympus Gold',
            'game_status'                      => 'active',
            'demo_enabled'                     => true,
            'real_enabled'                     => true,
            'demo_play_limit'                 => 1, // default 1 session
            'demo_starting_balance'           => 10000.00,
            'login_popup_enabled'             => true,
            'min_bet'                         => 1.00,
            'max_bet'                         => 5000.00,
            'default_bet'                     => 2.00,
            'buy_free_spins_multiplier'       => 100.00,
            'double_chance_ante_pct'          => 25.00,
            'rtp_percentage'                  => 96.50,
            'volatility'                      => 'high',
            'required_scatters_for_free_spins'=> 4,
            'free_spins_count'                => 10,
            'max_multiplier'                  => 500,
            'paytable_json'                   => $defaultPaytable,
            'multipliers_json'                => $defaultMultipliers,
            'bet_options_json'                => $defaultBetOptions,
        ]);
    }
}
