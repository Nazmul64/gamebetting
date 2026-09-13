<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. গেম কনফিগারেশন, জ্যাকপট ও অডিও সেটিংস
        if (!Schema::hasTable('royal_emirates_settings')) {
            Schema::create('royal_emirates_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Royal Emirates Hold and Spin');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(5000.00);
                $table->integer('demo_spin_limit')->default(3); // ৩-৪ বার পর ডিপোজিট লক
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                
                // জ্যাকপট মাল্টিপ্লায়ার
                $table->decimal('mini_multiplier', 8, 2)->default(10.00);
                $table->decimal('minor_multiplier', 8, 2)->default(25.00);
                $table->decimal('mega_multiplier', 8, 2)->default(50.00);
                $table->decimal('grand_multiplier', 8, 2)->default(5000.00);

                // এডমিন প্রফিট কন্ট্রোল
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(32); // উইন রেট

                // অডিও পাথ
                $table->string('bg_music')->nullable();
                $table->string('spin_sound')->nullable();
                $table->string('win_sound')->nullable();
                $table->string('coin_drop_sound')->nullable();
                $table->string('hold_spin_trigger_sound')->nullable();
                $table->timestamps();
            });
        }

        // ২. প্রতিটি স্পিনের হিস্ট্রি ও জ্যাকপট লগ
        if (!Schema::hasTable('royal_emirates_spins')) {
            Schema::create('royal_emirates_spins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->decimal('admin_profit', 12, 2)->default(0.00);
                $table->json('grid_matrix'); // ৫x৩ গ্রিড
                $table->json('coin_values')->nullable(); // কয়েনগুলোতে টাকার ভ্যালু
                $table->string('jackpot_won')->nullable(); // 'MINI', 'MINOR', 'MEGA', 'GRAND'
                $table->boolean('triggered_hold_spin')->default(false);
                $table->boolean('is_win')->default(false);
                $table->timestamps();
            });
        }

        // ৩. ওয়ালেট লেজার ট্র্যাকিং
        if (!Schema::hasTable('royal_emirates_transactions')) {
            Schema::create('royal_emirates_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('spin_id')->constrained('royal_emirates_spins')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('royal_emirates_transactions');
        Schema::dropIfExists('royal_emirates_spins');
        Schema::dropIfExists('royal_emirates_settings');
    }
};
