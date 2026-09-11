<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. গেম কনফিগারেশন, উইন রেট ও অডিও
        if (!Schema::hasTable('heads_tails_settings')) {
            Schema::create('heads_tails_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Heads or Tails');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(10000.00);
                $table->integer('demo_toss_limit')->default(3);
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                
                // অ্যালগরিদম ও পে-আউট
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(35);
                $table->decimal('base_multiplier', 5, 2)->default(1.96);
                
                // বট সেটিংস
                $table->boolean('bot_status')->default(true);
                $table->integer('bot_trigger_count')->default(5);
                $table->decimal('bot_min_bet', 12, 2)->default(10.00);
                $table->decimal('bot_max_bet', 12, 2)->default(500.00);
                $table->integer('round_duration_seconds')->default(15);

                // অডিও পাথ
                $table->string('bg_sea_music')->nullable();
                $table->string('coin_flip_sound')->nullable();
                $table->string('win_sound')->nullable();
                $table->string('loss_sound')->nullable();
                $table->timestamps();
            });
        }

        // ২. রাউন্ড ও পুল হিসেব
        if (!Schema::hasTable('heads_tails_rounds')) {
            Schema::create('heads_tails_rounds', function (Blueprint $table) {
                $table->id();
                $table->string('round_id')->unique();
                $table->enum('winning_side', ['heads', 'tails'])->nullable();
                
                // ফাইন্যান্সিয়াল হিসেব (হাউজ লেজার)
                $table->decimal('real_bets_heads', 18, 2)->default(0.00);
                $table->decimal('real_bets_tails', 18, 2)->default(0.00);
                $table->decimal('bot_bets_heads', 18, 2)->default(0.00);
                $table->decimal('bot_bets_tails', 18, 2)->default(0.00);
                
                $table->decimal('total_payout', 18, 2)->default(0.00);
                $table->decimal('admin_profit', 18, 2)->default(0.00);

                $table->enum('status', ['betting', 'flipping', 'completed'])->default('betting');
                $table->timestamp('ends_at');
                $table->timestamps();
            });
        }

        // ৩. বেটের রেকর্ড
        if (!Schema::hasTable('heads_tails_bets')) {
            Schema::create('heads_tails_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('round_id')->constrained('heads_tails_rounds')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->boolean('is_bot')->default(false);
                $table->string('bot_name')->nullable();
                $table->enum('chosen_side', ['heads', 'tails']);
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
                $table->timestamps();
            });
        }

        // ৪. ওয়ালেট ট্রানজেকশন লেজার
        if (!Schema::hasTable('heads_tails_transactions')) {
            Schema::create('heads_tails_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('heads_tails_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('heads_tails_transactions');
        Schema::dropIfExists('heads_tails_bets');
        Schema::dropIfExists('heads_tails_rounds');
        Schema::dropIfExists('heads_tails_settings');
    }
};
