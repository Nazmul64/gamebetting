<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'user_code')) {
                $table->string('user_code', 10)->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'is_seller')) {
                $table->boolean('is_seller')->default(false)->after('is_admin');
            }
            if (!Schema::hasColumn('users', 'seller_photo')) {
                $table->string('seller_photo')->nullable()->after('is_seller');
            }
            if (!Schema::hasColumn('users', 'seller_phone')) {
                $table->string('seller_phone')->nullable()->after('seller_photo');
            }
            if (!Schema::hasColumn('users', 'seller_status')) {
                $table->enum('seller_status', ['active', 'inactive'])->default('active')->after('seller_phone');
            }
        });

        // Create seller_transfers table for ledger tracking
        if (!Schema::hasTable('seller_transfers')) {
            Schema::create('seller_transfers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
                $table->string('customer_user_code', 10);
                $table->decimal('amount', 14, 2);
                $table->decimal('seller_balance_before', 14, 2);
                $table->decimal('seller_balance_after', 14, 2);
                $table->decimal('customer_balance_before', 14, 2);
                $table->decimal('customer_balance_after', 14, 2);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Create seller_chat_messages table for customer-seller live communication
        if (!Schema::hasTable('seller_chat_messages')) {
            Schema::create('seller_chat_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
                $table->enum('sender_type', ['customer', 'seller']);
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        // Generate 10-digit unique user_code for all existing users
        $users = DB::table('users')->whereNull('user_code')->orWhere('user_code', '')->get();
        foreach ($users as $u) {
            $code = strval(1000000000 + $u->id);
            // Ensure unique
            while (DB::table('users')->where('user_code', $code)->exists()) {
                $code = strval(random_int(1000000000, 9999999999));
            }
            DB::table('users')->where('id', $u->id)->update(['user_code' => $code]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_chat_messages');
        Schema::dropIfExists('seller_transfers');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_code', 'is_seller', 'seller_photo', 'seller_phone', 'seller_status']);
        });
    }
};
