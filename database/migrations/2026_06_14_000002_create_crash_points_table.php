<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the crash_points table to store admin-defined crash multipliers in sequence.
     */
    public function up(): void
    {
        Schema::create('crash_points', function (Blueprint $table) {
            $table->id();
            $table->decimal('point', 8, 2)->comment('Crash multiplier value e.g. 1.5, 2.2, 10.0');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('sort_order')->default(0)->comment('Sequence order for crash rounds');
            $table->timestamps();
        });

        // Also create a game_state table to track current sequence index
        Schema::create('game_state', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crash_points');
        Schema::dropIfExists('game_state');
    }
};
