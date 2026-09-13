<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. K3 গ্লোবাল কনফিগারেশন
        if (!Schema::hasTable('k3_settings')) {
            Schema::create('k3_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('K3 Lottery');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(50000.00);
                $table->integer('demo_limit')->default(3);
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random', 'manual'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30);
                $table->boolean('bot_status')->default(true);
                $table->integer('bot_trigger_count')->default(5);
                $table->boolean('audio_countdown_enabled')->default(true);
                $table->string('audio_countdown_url')->nullable();
                $table->string('audio_win_url')->nullable();
                $table->timestamps();
            });
        }

        // ২. K3 রাউন্ড/পিরিয়ড টেবিল (১মি, ৩মি, ৫মি, ১০মি)
        if (!Schema::hasTable('k3_periods')) {
            Schema::create('k3_periods', function (Blueprint $table) {
                $table->id();
                $table->string('period_number')->unique(); // e.g. 20260912101020238
                $table->enum('time_type', ['1m', '3m', '5m', '10m'])->default('1m');
                $table->integer('dice_1')->nullable(); // 1 - 6
                $table->integer('dice_2')->nullable(); // 1 - 6
                $table->integer('dice_3')->nullable(); // 1 - 6
                $table->integer('total_sum')->nullable(); // 3 - 18
                $table->enum('size', ['big', 'small'])->nullable();
                $table->enum('parity', ['odd', 'even'])->nullable();
                $table->string('pattern')->nullable(); // '2_same', '3_same', 'different'
                
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

        // ৩. বেটের টিকিট
        if (!Schema::hasTable('k3_bets')) {
            Schema::create('k3_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('period_id')->constrained('k3_periods')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->boolean('is_bot')->default(false);
                $table->string('bot_name')->nullable();
                
                $table->enum('bet_type', ['total', 'size', 'parity', '2_same', '3_same', 'different']);
                $table->string('selected_value'); // '3'-'18', 'big', 'small', 'odd', 'even', etc.
                $table->decimal('unit_amount', 12, 2);
                $table->integer('multiplier')->default(1);
                $table->decimal('total_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
                $table->timestamps();
            });
        }

        // ৪. ওয়ালেট ট্রানজেকশন লেজার
        if (!Schema::hasTable('k3_transactions')) {
            Schema::create('k3_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('k3_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('k3_transactions');
        Schema::dropIfExists('k3_bets');
        Schema::dropIfExists('k3_periods');
        Schema::dropIfExists('k3_settings');
    }
};
