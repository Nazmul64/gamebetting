<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. প্রতিটি গেমের রিয়েল-টাইম হেলথ ও মেট্রিক্স
        Schema::create('casino_game_registries', function (Blueprint $table) {
            $table->id();
            $table->string('game_key')->unique(); // e.g., 'olympus_gold', 'boxing_king', 'western_vault', 'aviator_crash'
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->decimal('total_real_deposit_volume', 18, 2)->default(0.00); // মোট আসল ডিপোজিট
            $table->decimal('total_real_withdraw_volume', 18, 2)->default(0.00); // মোট আসল উইথড্র
            $table->decimal('total_real_bets', 18, 2)->default(0.00); // মোট খেলা আসল বেট
            $table->decimal('total_real_payouts', 18, 2)->default(0.00); // ইউজারদের দেওয়া পেআউট
            $table->decimal('net_house_profit', 18, 2)->default(0.00); // এডমিনের নিট লাভ
            $table->integer('active_real_players_count')->default(0); // এই মুহূর্তে কতজন আসল প্লেয়ার আছে
            $table->enum('health_status', ['healthy', 'balanced', 'critical_loss'])->default('healthy');
            $table->timestamps();
        });

        // ২. ইউজারদের লাইভ অ্যাক্টিভিটি ট্র্যাকার (রিয়েল ইউজার কাউন্ট রাখার জন্য)
        Schema::create('casino_game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('game_key');
            $table->boolean('is_demo')->default(false); // ডেমো ট্র্যাকার ফিল্টার করার জন্য
            $table->timestamp('last_action_at');
            $table->timestamps();

            $table->unique(['user_id', 'game_key']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('casino_game_sessions');
        Schema::dropIfExists('casino_game_registries');
    }
};
