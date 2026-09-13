<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'block_reason')) {
                $table->string('block_reason')->nullable()->after('is_blocked');
            }
            if (!Schema::hasColumn('users', 'deposit_hold')) {
                $table->boolean('deposit_hold')->default(false)->after('block_reason');
            }
            if (!Schema::hasColumn('users', 'hold_reason')) {
                $table->string('hold_reason')->nullable()->after('deposit_hold');
            }
            if (!Schema::hasColumn('users', 'game_rig_mode')) {
                $table->enum('game_rig_mode', ['normal', 'always_win', 'always_lose'])->default('normal')->after('hold_reason');
            }
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['block_reason', 'deposit_hold', 'hold_reason', 'game_rig_mode']);
        });
    }
};
