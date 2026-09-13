<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. TrxWinGo Global Settings
        if (!Schema::hasTable('trx_wingo_settings')) {
            Schema::create('trx_wingo_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('TrxWinGo');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(50000.00);
                $table->integer('demo_limit')->default(3);
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random', 'manual'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30);
                $table->integer('next_force_number')->nullable();
                $table->boolean('bot_status')->default(true);
                $table->integer('bot_trigger_count')->default(5);
                $table->longText('how_to_play_rules')->nullable();
                $table->timestamps();
            });
        }

        // 2. TrxWinGo Periods and Blockchain Tracking
        if (!Schema::hasTable('trx_wingo_periods')) {
            Schema::create('trx_wingo_periods', function (Blueprint $table) {
                $table->id();
                $table->string('period_number')->unique();
                $table->enum('time_type', ['1m', '3m', '5m'])->default('1m');
                
                // TRON Blockchain Simulation Data
                $table->unsignedBigInteger('block_height')->default(86198252);
                $table->string('block_time')->default('08:30:00');
                $table->string('hash_value')->default('pending');
                $table->json('hash_tail_chars')->nullable();
                
                // Results
                $table->integer('winning_number')->nullable();
                $table->string('winning_color')->nullable();
                $table->enum('winning_size', ['big', 'small'])->nullable();
                
                $table->decimal('total_real_bets', 18, 2)->default(0.00);
                $table->decimal('total_payout', 18, 2)->default(0.00);
                $table->decimal('admin_profit', 18, 2)->default(0.00);

                $table->enum('status', ['betting', 'locked', 'completed'])->default('betting');
                $table->dateTime('starts_at')->nullable();
                $table->dateTime('ends_at')->nullable();
                $table->timestamps();

                $table->index(['time_type', 'status']);
            });
        }

        // 3. TrxWinGo Bets
        if (!Schema::hasTable('trx_wingo_bets')) {
            Schema::create('trx_wingo_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('period_id')->constrained('trx_wingo_periods')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->boolean('is_bot')->default(false);
                $table->string('bot_name')->nullable();
                
                $table->enum('bet_type', ['color', 'number', 'size']);
                $table->string('selected_value'); // green, red, violet, 0-9, big, small
                $table->decimal('unit_amount', 12, 2);
                $table->integer('multiplier')->default(1);
                $table->decimal('total_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
                $table->timestamps();
            });
        }

        // 4. Wallet Transaction Ledger
        if (!Schema::hasTable('trx_wingo_transactions')) {
            Schema::create('trx_wingo_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('trx_wingo_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('trx_wingo_transactions');
        Schema::dropIfExists('trx_wingo_bets');
        Schema::dropIfExists('trx_wingo_periods');
        Schema::dropIfExists('trx_wingo_settings');
    }
};
