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
        // 1. Add referred_by to users
        if (!Schema::hasColumn('users', 'referred_by')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('referred_by')->nullable()->after('is_admin');
                $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
            });
        }

        // 2. Create settings table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 3. Create payment_gateways table
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('manual'); // manual, auto
            $table->string('logo')->nullable();
            $table->json('settings')->nullable(); // receiver details (receiver_number, etc.)
            $table->json('deposit_fields')->nullable(); // user input fields
            $table->string('methods')->default('both'); // withdraw, deposit, both
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });

        // 4. Create transactions table
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type'); // Deposit, Withdraw, Transfer Out, Transfer In, Referral Commission L1/L2/L3
            $table->string('gateway')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0.00);
            $table->string('status')->default('Completed'); // Completed, Pending, Failed
            $table->json('metadata')->nullable(); // to store submitted deposit form data (like transaction_id, screenshort)
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('payment_gateways');
        Schema::dropIfExists('settings');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn('referred_by');
        });
    }
};
