<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. ফরচুন জেমস ২ গেম কনফিগারেশন ও সাউন্ড সেটিংস
        if (!Schema::hasTable('fortune_gems_settings')) {
            Schema::create('fortune_gems_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Fortune Gems 2');
                $table->decimal('min_bet', 12, 2)->default(10.00);
                $table->decimal('max_bet', 12, 2)->default(5000.00);
                $table->integer('demo_spin_limit')->default(3); // ৩ স্পিন পর ডিপোজিট লক
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                
                // এডমিন কন্ট্রোল
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(35); // ইউজারের জয়ের গড় হার
                
                // অডিও পাথ
                $table->string('bg_music')->nullable();
                $table->string('spin_sound')->nullable();
                $table->string('win_sound')->nullable();
                $table->string('wheel_bonus_sound')->nullable();
                $table->timestamps();
            });
        }

        // ২. প্রতিটি স্পিনের হিস্ট্রি ও অডিট ট্র্যাকিং
        if (!Schema::hasTable('fortune_gems_spins')) {
            Schema::create('fortune_gems_spins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->decimal('admin_profit', 12, 2)->default(0.00);
                $table->json('grid_matrix'); // ৩x৩ গ্রিড
                $table->string('special_reel_symbol'); // e.g., '1x', '2x', '3x', '5x', 'WHEEL'
                $table->integer('multiplier')->default(1);
                $table->boolean('triggered_wheel')->default(false);
                $table->boolean('is_win')->default(false);
                $table->timestamps();
            });
        }

        // ৩. ওয়ালেট লেজার ট্র্যাকিং (ডাবল স্পেন্ড প্রটেকশন)
        if (!Schema::hasTable('fortune_gems_transactions')) {
            Schema::create('fortune_gems_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('spin_id')->constrained('fortune_gems_spins')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('fortune_gems_transactions');
        Schema::dropIfExists('fortune_gems_spins');
        Schema::dropIfExists('fortune_gems_settings');
    }
};
