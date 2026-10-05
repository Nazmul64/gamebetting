<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('under_and_over7_settings')) {
            Schema::create('under_and_over7_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Under and Over 7');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(50000.00);
                $table->decimal('over_multiplier', 5, 2)->default(2.30);
                $table->decimal('equal_multiplier', 5, 2)->default(5.80);
                $table->decimal('under_multiplier', 5, 2)->default(2.30);
                $table->decimal('demo_default_balance', 12, 2)->default(100.00);
                
                // Algorithm & Payout controls
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(45);
                
                // Audio paths
                $table->string('bg_music')->nullable();
                $table->string('dice_roll_sound')->nullable();
                $table->string('win_sound')->nullable();
                $table->string('loss_sound')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('under_and_over7_bets')) {
            Schema::create('under_and_over7_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->enum('bet_choice', ['under', 'equal', 'over']);
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('multiplier', 5, 2)->default(2.30);
                $table->tinyInteger('die1')->default(1);
                $table->tinyInteger('die2')->default(1);
                $table->tinyInteger('sum')->default(2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
                $table->boolean('is_demo')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('under_and_over7_transactions')) {
            Schema::create('under_and_over7_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('under_and_over7_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('under_and_over7_transactions');
        Schema::dropIfExists('under_and_over7_bets');
        Schema::dropIfExists('under_and_over7_settings');
    }
};
