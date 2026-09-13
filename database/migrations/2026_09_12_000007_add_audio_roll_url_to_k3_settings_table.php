<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('k3_settings', 'audio_roll_url')) {
            Schema::table('k3_settings', function (Blueprint $table) {
                $table->string('audio_roll_url')->nullable()->after('audio_win_url');
            });
        }
    }

    public function down(): void {
        if (Schema::hasColumn('k3_settings', 'audio_roll_url')) {
            Schema::table('k3_settings', function (Blueprint $table) {
                $table->dropColumn('audio_roll_url');
            });
        }
    }
};
