<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('card_games21_settings')) {
            Schema::create('card_games21_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Card Games 21');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(50000.00);
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                $table->decimal('win_multiplier', 5, 2)->default(2.00);
                
                // Admin Profit & RTP controls
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30);
                $table->integer('admin_profit_percentage')->default(70);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('card_games21_bets')) {
            Schema::create('card_games21_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('multiplier', 5, 2)->default(2.00);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->decimal('admin_profit', 12, 2)->default(0.00);
                $table->json('player_cards')->nullable();
                $table->json('dealer_cards')->nullable();
                $table->json('remaining_deck')->nullable();
                $table->tinyInteger('player_score')->default(0);
                $table->tinyInteger('dealer_score')->default(0);
                $table->enum('status', ['pending', 'won', 'lost', 'draw', 'busted'])->default('pending');
                $table->string('result_message')->nullable();
                $table->boolean('is_demo')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('card_games21_transactions')) {
            Schema::create('card_games21_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('card_games21_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win', 'refund_draw']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('card_games21_transactions');
        Schema::dropIfExists('card_games21_bets');
        Schema::dropIfExists('card_games21_settings');
    }
};
