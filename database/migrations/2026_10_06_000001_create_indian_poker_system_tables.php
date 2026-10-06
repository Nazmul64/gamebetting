<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('indian_poker_settings')) {
            Schema::create('indian_poker_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Indian Poker');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(50000.00);
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                
                // Multipliers
                $table->decimal('pair_multiplier', 8, 2)->default(1.00);
                $table->decimal('flush_multiplier', 8, 2)->default(5.00);
                $table->decimal('straight_multiplier', 8, 2)->default(10.00);
                $table->decimal('three_multiplier', 8, 2)->default(50.00);
                $table->decimal('sf_multiplier', 8, 2)->default(75.00);
                
                // Admin Profit & RTP controls
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30);
                $table->integer('admin_profit_percentage')->default(70);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('indian_poker_bets')) {
            Schema::create('indian_poker_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('multiplier', 8, 2)->default(0.00);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->decimal('admin_profit', 12, 2)->default(0.00);
                $table->string('card1', 10)->nullable();
                $table->string('card2', 10)->nullable();
                $table->string('card3', 10)->nullable();
                $table->string('hand_type', 30)->nullable();
                $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
                $table->boolean('is_demo')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('indian_poker_transactions')) {
            Schema::create('indian_poker_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('indian_poker_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('indian_poker_transactions');
        Schema::dropIfExists('indian_poker_bets');
        Schema::dropIfExists('indian_poker_settings');
    }
};
