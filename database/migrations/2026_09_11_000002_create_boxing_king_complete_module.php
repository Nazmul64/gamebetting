<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. মডিউল সেটিংস, এডমিন প্রফিট মার্জিন ও অডিও ফাইল
        Schema::create('boxing_king_settings', function (Blueprint $table) {
            $table->id();
            $table->string('game_name')->default('Boxing King');
            $table->decimal('min_bet', 10, 2)->default(3.00);
            $table->decimal('max_bet', 10, 2)->default(10000.00);
            $table->integer('demo_spin_limit')->default(3); // ২ বা ৩ স্পিন পর ডিপোজিট পপআপ
            $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
            
            // উইন কন্ট্রোল
            $table->integer('win_chance_percentage')->default(30); // এডমিন যত % দিতে চায়
            $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
            
            // সাউন্ড ফাইল পাথ
            $table->string('bg_music')->nullable();
            $table->string('spin_sound')->nullable();
            $table->string('win_sound')->nullable();
            $table->string('fire_burn_sound')->nullable(); // আগুন জ্বলার ও পাঞ্চের সাউন্ড
            $table->timestamps();
        });

        // ২. স্পিন ট্রানজেকশন ও অডিট হিস্ট্রি
        Schema::create('boxing_king_spins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('is_demo')->default(false);
            $table->decimal('bet_amount', 12, 2);
            $table->decimal('win_amount', 12, 2)->default(0.00);
            $table->decimal('admin_profit', 12, 2)->default(0.00);
            $table->json('grid_result'); // ৫x৩ গ্রিডের আউটপুট
            $table->json('winning_cells')->nullable(); // যে সেলগুলোতে আগুন জ্বলবে [[0,0], [0,1], [0,2]]
            $table->boolean('is_win')->default(false);
            $table->timestamps();
        });

        // ৩. ইউজারের মূল ওয়ালেট লেজার
        Schema::create('boxing_king_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('spin_id')->constrained('boxing_king_spins')->onDelete('cascade');
            $table->enum('type', ['debit_bet', 'credit_win']);
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_before', 12, 2);
            $table->decimal('balance_after', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('boxing_king_transactions');
        Schema::dropIfExists('boxing_king_spins');
        Schema::dropIfExists('boxing_king_settings');
    }
};
