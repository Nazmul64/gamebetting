<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // গেম কনফিগারেশন, এডমিন অ্যালগরিদম ও মিডিয়া সেটিংস
        Schema::create('western_vault_settings', function (Blueprint $table) {
            $table->id();
            $table->string('game_name')->default('Western Vault');
            $table->decimal('min_bet', 12, 2)->default(10.00);
            $table->decimal('max_bet', 12, 2)->default(50000.00);
            $table->decimal('demo_initial_balance', 12, 2)->default(10000.00);
            $table->decimal('house_edge_percent', 5, 2)->default(5.00);
            $table->integer('win_chance_percentage')->default(35);
            $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
            
            // ডাইনামিক বট কনফিগারেশন
            $table->boolean('bot_status')->default(true);
            $table->integer('bot_trigger_player_count')->default(10);
            $table->decimal('bot_min_bet', 12, 2)->default(50.00);
            $table->decimal('bot_max_bet', 12, 2)->default(2000.00);

            $table->integer('round_duration')->default(25);

            // অডিও পাথ
            $table->string('bg_music')->nullable();
            $table->string('spin_sound')->nullable();
            $table->string('win_sound')->nullable();
            $table->timestamps();
        });

        // প্রতি রাউন্ডের ডাটা ও অডিট টেবিল
        Schema::create('western_vault_rounds', function (Blueprint $table) {
            $table->id();
            $table->string('round_id')->unique();
            $table->enum('winning_side', ['side_a', 'side_b'])->nullable();
            $table->json('grid_matrix')->nullable();
            
            $table->decimal('real_bets_total_a', 15, 2)->default(0.00);
            $table->decimal('real_bets_total_b', 15, 2)->default(0.00);
            $table->decimal('bot_bets_total_a', 15, 2)->default(0.00);
            $table->decimal('bot_bets_total_b', 15, 2)->default(0.00);
            
            $table->decimal('total_payout', 15, 2)->default(0.00);
            $table->decimal('admin_profit', 15, 2)->default(0.00);

            $table->enum('status', ['betting', 'processing', 'completed'])->default('betting');
            $table->timestamp('ends_at');
            $table->timestamps();
        });

        // বেটের হিসেব
        Schema::create('western_vault_bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('round_id')->constrained('western_vault_rounds')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('is_demo')->default(false);
            $table->boolean('is_bot')->default(false);
            $table->string('bot_name')->nullable();
            $table->enum('selected_side', ['side_a', 'side_b']);
            $table->decimal('bet_amount', 12, 2);
            $table->decimal('payout_multiplier', 5, 2)->default(1.95);
            $table->decimal('win_amount', 12, 2)->default(0.00);
            $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
            $table->timestamps();
        });

        // লেজার ও ব্যালেন্স ট্র্যাকিং
        Schema::create('western_vault_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bet_id')->nullable()->constrained('western_vault_bets')->onDelete('cascade');
            $table->enum('type', ['bet_placed', 'win_payout', 'refund']);
            $table->decimal('amount', 12, 2);
            $table->decimal('opening_balance', 12, 2);
            $table->decimal('closing_balance', 12, 2);
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('western_vault_transactions');
        Schema::dropIfExists('western_vault_bets');
        Schema::dropIfExists('western_vault_rounds');
        Schema::dropIfExists('western_vault_settings');
    }
};
