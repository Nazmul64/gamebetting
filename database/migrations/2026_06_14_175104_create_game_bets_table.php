<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('round_id', 50)->index();          // e.g. "RC-123456"
            $table->decimal('bet_amount', 15, 2);
            $table->decimal('cashout_odds', 8, 4)->nullable(); // null = crashed
            $table->decimal('crash_point', 8, 4)->nullable();  // what the round crashed at
            $table->decimal('winnings', 15, 2)->default(0.00); // 0 = lost
            $table->enum('result', ['win', 'lose', 'pending'])->default('pending');
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_bets');
    }
};
