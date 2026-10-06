<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('juice_slots_settings')) {
            Schema::create('juice_slots_settings', function (Blueprint $table) {
                $table->id();
                $table->string('control_mode')->default('house_profit'); // house_profit, manual, rtp, random
                $table->decimal('house_profit_percentage', 5, 2)->default(70.00);
                $table->decimal('rtp_percentage', 5, 2)->default(30.00);
                $table->decimal('win_chance_percentage', 5, 2)->default(30.00);
                $table->decimal('min_bet', 16, 2)->default(10.00);
                $table->decimal('max_bet', 16, 2)->default(50000.00);
                $table->decimal('max_payout_per_spin', 16, 2)->default(1000000.00);
                $table->boolean('is_active')->default(true);
                $table->json('custom_paytable')->nullable();
                $table->timestamps();
            });

            DB::table('juice_slots_settings')->insert([
                'control_mode' => 'house_profit',
                'house_profit_percentage' => 70.00,
                'rtp_percentage' => 30.00,
                'win_chance_percentage' => 30.00,
                'min_bet' => 10.00,
                'max_bet' => 50000.00,
                'max_payout_per_spin' => 1000000.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        if (!Schema::hasTable('juice_slots_spins')) {
            Schema::create('juice_slots_spins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->decimal('bet_amount', 16, 2);
                $table->decimal('win_amount', 16, 2)->default(0.00);
                $table->decimal('multiplier', 10, 2)->default(0.00);
                $table->json('grid_matrix');
                $table->json('winning_lines')->nullable();
                $table->string('status')->default('completed'); // completed, refunded
                $table->boolean('is_demo')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('juice_slots_transactions')) {
            Schema::create('juice_slots_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('spin_id')->nullable()->constrained('juice_slots_spins')->onDelete('set null');
                $table->string('type'); // bet_debit, win_credit, refund
                $table->decimal('amount', 16, 2);
                $table->decimal('balance_before', 16, 2);
                $table->decimal('balance_after', 16, 2);
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('juice_slots_transactions');
        Schema::dropIfExists('juice_slots_spins');
        Schema::dropIfExists('juice_slots_settings');
    }
};
