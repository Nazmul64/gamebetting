<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. এডমিন কনফিগারেশন, কন্ট্রোল মোড ও অডিও সেটিংস
        if (!Schema::hasTable('abyss_settings')) {
            Schema::create('abyss_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Abyss of Glory');
                $table->decimal('min_bet', 12, 2)->default(0.40);
                $table->decimal('max_bet', 12, 2)->default(10000.00);
                $table->integer('demo_spin_limit')->default(3);
                $table->decimal('demo_initial_balance', 12, 2)->default(10000.00);
                
                // অ্যালগরিদম ও উইন কন্ট্রোল
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30);
                $table->decimal('payout_multiplier', 5, 2)->default(1.95);
                
                // বট সেটিংস
                $table->boolean('bot_status')->default(true);
                $table->integer('bot_trigger_count')->default(5);
                $table->decimal('bot_min_bet', 12, 2)->default(50.00);
                $table->decimal('bot_max_bet', 12, 2)->default(2000.00);
                $table->integer('round_duration_seconds')->default(25);

                // অডিও ট্র্যাক পাথ
                $table->string('bg_magic_music')->nullable();
                $table->string('spin_sound')->nullable();
                $table->string('win_sound')->nullable();
                $table->string('god_clash_sound')->nullable();
                $table->timestamps();
            });
        }

        // ২. রাউন্ড ও পুল ট্র্যাকিং (House Ledger)
        if (!Schema::hasTable('abyss_rounds')) {
            Schema::create('abyss_rounds', function (Blueprint $table) {
                $table->id();
                $table->string('round_id')->unique();
                $table->enum('winning_side', ['poseidon', 'anubis'])->nullable();
                $table->json('grid_matrix')->nullable(); // ৫x৩ গ্রিড ডেটা
                
                // ফাইন্যান্সিয়াল হিসেব
                $table->decimal('real_bets_poseidon', 18, 2)->default(0.00);
                $table->decimal('real_bets_anubis', 18, 2)->default(0.00);
                $table->decimal('bot_bets_poseidon', 18, 2)->default(0.00);
                $table->decimal('bot_bets_anubis', 18, 2)->default(0.00);
                
                $table->decimal('total_payout', 18, 2)->default(0.00);
                $table->decimal('admin_profit', 18, 2)->default(0.00);

                $table->enum('status', ['betting', 'processing', 'completed'])->default('betting');
                $table->timestamp('ends_at');
                $table->timestamps();
            });
        }

        // ৩. বেটের টিকিট
        if (!Schema::hasTable('abyss_bets')) {
            Schema::create('abyss_bets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('round_id')->constrained('abyss_rounds')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->boolean('is_bot')->default(false);
                $table->string('bot_name')->nullable();
                $table->enum('selected_side', ['poseidon', 'anubis']);
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
                $table->timestamps();
            });
        }

        // ৪. ওয়ালেট ট্রানজেকশন লেজার (Double-Spend Protection & Audit)
        if (!Schema::hasTable('abyss_transactions')) {
            Schema::create('abyss_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bet_id')->constrained('abyss_bets')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('abyss_transactions');
        Schema::dropIfExists('abyss_bets');
        Schema::dropIfExists('abyss_rounds');
        Schema::dropIfExists('abyss_settings');
    }
};
