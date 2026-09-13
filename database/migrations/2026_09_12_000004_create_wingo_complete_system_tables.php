<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. উইনগো গ্লোবাল কনফিগারেশন
        if (!Schema::hasTable('wingo_settings')) {
            Schema::create('wingo_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('WinGo');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(50000.00);
                $table->integer('demo_limit')->default(3);
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30);
                $table->boolean('bot_status')->default(true);
                $table->integer('bot_trigger_count')->default(5);
                $table->timestamps();
            });
        }

        // ২. পিরিয়ড ও রাউন্ড হিস্ট্রি টেবিল
        if (!Schema::hasTable('wingo_periods')) {
            Schema::create('wingo_periods', function (Blueprint $table) {
                $table->id();
                $table->string('period_number')->unique(); // e.g. 20260912100050685
                $table->enum('time_type', ['30s', '1m', '3m', '5m'])->default('30s');
                $table->integer('winning_number')->nullable(); // 0 - 9
                $table->string('winning_color')->nullable(); // 'green', 'red', 'violet', 'green_violet', 'red_violet'
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

        // ৩. বেটের রেকর্ড
        if (!Schema::hasTable('wingo_bets')) {
            Schema::create('wingo_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('period_id')->constrained('wingo_periods')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->boolean('is_bot')->default(false);
                $table->string('bot_name')->nullable();
                
                $table->enum('bet_type', ['color', 'number', 'size']);
                $table->string('selected_value'); // 'green', 'red', 'violet', '0'-'9', 'big', 'small'
                $table->decimal('unit_amount', 12, 2);
                $table->integer('multiplier')->default(1);
                $table->decimal('total_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
                $table->timestamps();
            });
        }

        // ৪. ওয়ালেট লেজার ট্র্যাকিং
        if (!Schema::hasTable('wingo_transactions')) {
            Schema::create('wingo_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('wingo_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('wingo_transactions');
        Schema::dropIfExists('wingo_bets');
        Schema::dropIfExists('wingo_periods');
        Schema::dropIfExists('wingo_settings');
    }
};
