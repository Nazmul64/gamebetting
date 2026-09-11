<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. গেম কনফিগারেশন, আরটিপি ও অডিও সেটিংস
        if (!Schema::hasTable('lucky_joker_settings')) {
            Schema::create('lucky_joker_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Lucky Joker 100');
                $table->decimal('min_bet', 12, 2)->default(10.00);
                $table->decimal('max_bet', 12, 2)->default(5000.00);
                $table->integer('demo_spin_limit')->default(3); // ৩-৪ বার খেলার পর ডিপোজিট লক
                $table->decimal('demo_default_balance', 12, 2)->default(10000.00);
                
                // এডমিন প্রফিট ও আরটিপি কন্ট্রোল
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30); // ৩০% উইন রেট
                
                // অডিও পাথ
                $table->string('bg_music')->nullable();
                $table->string('spin_sound')->nullable();
                $table->string('win_sound')->nullable();
                $table->string('joker_laugh_sound')->nullable();
                $table->timestamps();
            });
        }

        // ২. প্রতিটি স্পিনের অডিট লগ
        if (!Schema::hasTable('lucky_joker_spins')) {
            Schema::create('lucky_joker_spins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->decimal('admin_profit', 12, 2)->default(0.00);
                $table->json('grid_matrix'); // ৫x৪ গ্রিড আউটপুট
                $table->json('winning_lines')->nullable(); // উইনিং পে-লাইনের ডাটা
                $table->boolean('has_expanding_wild')->default(false);
                $table->timestamps();
            });
        }

        // ৩. ওয়ালেট লেজার ট্র্যাকিং
        if (!Schema::hasTable('lucky_joker_transactions')) {
            Schema::create('lucky_joker_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('spin_id')->constrained('lucky_joker_spins')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('lucky_joker_transactions');
        Schema::dropIfExists('lucky_joker_spins');
        Schema::dropIfExists('lucky_joker_settings');
    }
};
