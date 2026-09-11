<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // ১. গেম কনফিগারেশন, অডিও ও কন্ট্রোল সেটিংস
        if (!Schema::hasTable('bonbon_settings')) {
            Schema::create('bonbon_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('BonBon Bonanza');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(5000.00);
                $table->integer('demo_spin_limit')->default(3); // ৩ বার পর ডিপোজিট লক
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                
                // এডমিন প্রফিট ও আরটিপি কন্ট্রোল
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(35); // ইউজারের জয়ের গড় হার
                
                // অডিও পাথ
                $table->string('bg_music')->nullable();
                $table->string('spin_sound')->nullable();
                $table->string('win_sound')->nullable();
                $table->string('tumble_blast_sound')->nullable();
                $table->timestamps();
            });
        }

        // ২. প্রতিটি স্পিনের অডিট লগ
        if (!Schema::hasTable('bonbon_spins')) {
            Schema::create('bonbon_spins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->boolean('is_demo')->default(false);
                $table->boolean('scatter_boost_enabled')->default(false);
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->decimal('admin_profit', 12, 2)->default(0.00);
                $table->json('grid_matrix'); // ৬x৫ গ্রিড
                $table->json('matched_symbols')->nullable(); // ৮+ মিলে যাওয়া সিম্বলের তালিকা
                $table->integer('tumble_count')->default(0);
                $table->boolean('is_win')->default(false);
                $table->timestamps();
            });
        }

        // ৩. ওয়ালেট লেজার ট্র্যাকিং (ডাবল স্পেন্ড প্রটেকশন)
        if (!Schema::hasTable('bonbon_transactions')) {
            Schema::create('bonbon_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('spin_id')->constrained('bonbon_spins')->onDelete('cascade');
                $table->enum('type', ['debit_bet', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('bonbon_transactions');
        Schema::dropIfExists('bonbon_spins');
        Schema::dropIfExists('bonbon_settings');
    }
};
