<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'heads_tails_settings',
            'abyss_settings',
            'western_vault_settings',
            'boxing_king_settings',
            'lucky_joker_settings',
            'fortune_gems_settings',
            'bonbon_settings',
            'big_bass_settings',
            'emirate_settings',
            'royal_emirates_settings',
            'under_and_over7_settings',
            'indian_poker_settings',
            'card_games21_settings',
            'roman_slots_settings',
            'crystal_settings',
            'burning_hot_settings',
            'easter_slots_settings',
            'juice_slots_settings',
            'wingo_settings',
            'trx_wingo_settings',
            'k3_settings',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'bg_music')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->string('bg_music')->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'heads_tails_settings',
            'abyss_settings',
            'indian_poker_settings',
            'card_games21_settings',
            'roman_slots_settings',
            'crystal_settings',
            'burning_hot_settings',
            'easter_slots_settings',
            'juice_slots_settings',
            'wingo_settings',
            'trx_wingo_settings',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'bg_music')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->dropColumn('bg_music');
                });
            }
        }
    }
};
