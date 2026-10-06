<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('roman_slots_settings')) {
            Schema::create('roman_slots_settings', function (Blueprint $table) {
                $table->id();
                $table->string('game_name')->default('Roman Slots');
                $table->decimal('min_bet', 12, 2)->default(1.00);
                $table->decimal('max_bet', 12, 2)->default(5000.00);
                $table->decimal('demo_default_balance', 12, 2)->default(1000.00);
                
                // Admin Profit & RTP controls
                $table->enum('control_mode', ['house_profit', 'fixed_percentage', 'random'])->default('house_profit');
                $table->integer('win_chance_percentage')->default(30);
                $table->integer('admin_profit_percentage')->default(70);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('roman_slots_spins')) {
            Schema::create('roman_slots_spins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->decimal('bet_amount', 12, 2);
                $table->decimal('win_amount', 12, 2)->default(0.00);
                $table->decimal('admin_profit', 12, 2)->default(0.00);
                $table->json('grid_matrix')->nullable();
                $table->json('winning_lines')->nullable();
                $table->string('message')->nullable();
                $table->enum('status', ['won', 'lost'])->default('lost');
                $table->boolean('is_demo')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('roman_slots_transactions')) {
            Schema::create('roman_slots_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('spin_id')->constrained('roman_slots_spins')->onDelete('cascade');
                $table->enum('type', ['debit_spin', 'credit_win']);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('roman_slots_transactions');
        Schema::dropIfExists('roman_slots_spins');
        Schema::dropIfExists('roman_slots_settings');
    }
};
