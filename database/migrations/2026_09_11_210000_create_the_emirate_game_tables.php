<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. গেম কনফিগারেশন ও অডিও সেটিংস
        Schema::create('emirate_settings', function (Blueprint $table) {
            $table->id();
            $table->string('game_name')->default('The Emirate');
            $table->decimal('min_bet', 12, 2)->default(5.00);
            $table->decimal('max_bet', 12, 2)->default(5000.00);
            $table->integer('demo_spin_limit')->default(3); // ৩-৪ স্পিনের পর ডিপোজিট লক
            $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
            
            // এডমিন প্রফিট ও উইন রেট
            $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
            $table->integer('win_chance_percentage')->default(30); // ৩০% উইন রেট
            
            // অডিও পাথ
            $table->string('bg_music')->nullable();
            $table->string('spin_sound')->nullable();
            $table->string('win_sound')->nullable();
            $table->string('scatter_sound')->nullable();
            $table->timestamps();
        });

        // ২. প্রতিটি স্পিনের অডিট হিস্ট্রি
        Schema::create('emirate_spins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('is_demo')->default(false);
            $table->decimal('bet_amount', 12, 2);
            $table->decimal('win_amount', 12, 2)->default(0.00);
            $table->decimal('admin_profit', 12, 2)->default(0.00);
            $table->json('grid_matrix'); // ৫x৩ গ্রিড
            $table->json('winning_lines')->nullable(); // উইনিং লাইন ও সেল পজিশন
            $table->boolean('is_scatter_win')->default(false);
            $table->boolean('is_win')->default(false);
            $table->timestamps();
        });

        // ৩. ওয়ালেট লেজার ট্র্যাকিং
        Schema::create('emirate_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('spin_id')->constrained('emirate_spins')->onDelete('cascade');
            $table->enum('type', ['debit_bet', 'credit_win']);
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_before', 12, 2);
            $table->decimal('balance_after', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('emirate_transactions');
        Schema::dropIfExists('emirate_spins');
        Schema::dropIfExists('emirate_settings');
    }
};
