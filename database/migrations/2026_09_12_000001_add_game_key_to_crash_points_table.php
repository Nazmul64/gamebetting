<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('crash_points')) {
            Schema::table('crash_points', function (Blueprint $table) {
                if (!Schema::hasColumn('crash_points', 'game_key')) {
                    $table->string('game_key', 50)->default('helicopterx')->after('id')->index();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('crash_points')) {
            Schema::table('crash_points', function (Blueprint $table) {
                if (Schema::hasColumn('crash_points', 'game_key')) {
                    $table->dropColumn('game_key');
                }
            });
        }
    }
};
