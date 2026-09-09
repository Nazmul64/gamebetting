<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Olympus Slot Configurations
        Schema::create('olympus_configs', function (Blueprint $table) {
            $table->id();
            $table->string('game_name')->default('Olympus Gold');
            $table->string('game_status')->default('active'); // active, maintenance
            $table->boolean('demo_enabled')->default(true);
            $table->boolean('real_enabled')->default(true);
            $table->integer('demo_play_limit')->default(1); // 1, 2, 3, 5, 10 or 0 for unlimited
            $table->decimal('demo_starting_balance', 12, 2)->default(10000.00);
            $table->boolean('login_popup_enabled')->default(true);
            
            // Bet configurations
            $table->decimal('min_bet', 10, 2)->default(1.00);
            $table->decimal('max_bet', 10, 2)->default(5000.00);
            $table->decimal('default_bet', 10, 2)->default(2.00);
            $table->decimal('buy_free_spins_multiplier', 8, 2)->default(100.00); // 100x bet
            $table->decimal('double_chance_ante_pct', 8, 2)->default(25.00); // 25% extra bet

            // Gameplay & RTP settings
            $table->decimal('rtp_percentage', 5, 2)->default(96.50);
            $table->string('volatility')->default('high'); // low, medium, high
            $table->integer('required_scatters_for_free_spins')->default(4);
            $table->integer('free_spins_count')->default(10);
            $table->integer('max_multiplier')->default(500);

            // Dynamic JSON rules
            $table->json('paytable_json')->nullable();
            $table->json('multipliers_json')->nullable();
            $table->json('bet_options_json')->nullable();

            $table->timestamps();
        });

        // 2. Olympus Round History & Logs
        Schema::create('olympus_rounds', function (Blueprint $table) {
            $table->id();
            $table->string('round_id', 64)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('session_id', 64)->nullable();
            $table->enum('mode', ['demo', 'real'])->default('real');
            
            $table->decimal('bet_amount', 12, 2)->default(0.00);
            $table->decimal('total_deducted', 12, 2)->default(0.00);
            $table->boolean('is_double_chance')->default(false);
            $table->boolean('is_buy_feature')->default(false);

            // Server RNG Result Data
            $table->json('grid_symbols'); // 6x5 matrix
            $table->json('winning_shapes')->nullable();
            $table->integer('scatter_count')->default(0);
            $table->boolean('triggered_free_spins')->default(false);
            $table->json('multiplier_symbols')->nullable();
            $table->integer('total_multiplier')->default(0);

            // Payout calculation
            $table->decimal('base_win', 12, 2)->default(0.00);
            $table->decimal('final_win', 12, 2)->default(0.00);
            $table->decimal('net_profit', 12, 2)->default(0.00);
            
            $table->decimal('balance_before', 12, 2)->default(0.00);
            $table->decimal('balance_after', 12, 2)->default(0.00);

            $table->string('idempotency_key', 64)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('status', 20)->default('completed');

            $table->timestamps();
        });

        // 3. Admin Configuration Audit Logs
        Schema::create('olympus_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('setting_key', 100);
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olympus_audit_logs');
        Schema::dropIfExists('olympus_rounds');
        Schema::dropIfExists('olympus_configs');
    }
};
