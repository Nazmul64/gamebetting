<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('game_settings')) {
            Schema::create('game_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_key')->unique();
                $table->decimal('target_profit', 8, 2)->default(70.00);
                $table->decimal('user_win_rate', 8, 2)->default(30.00);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('bet_histories')) {
            Schema::create('bet_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('game_key');
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('multiplier', 8, 2)->default(0.00);
                $table->decimal('payout', 12, 2)->default(0.00);
                $table->json('result_data')->nullable();
                $table->string('status', 20)->default('loss');
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('bet_histories');
        Schema::dropIfExists('game_settings');
    }
};
