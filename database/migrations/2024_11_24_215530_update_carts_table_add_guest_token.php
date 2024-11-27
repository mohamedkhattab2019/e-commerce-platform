<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCartsTableAddGuestToken extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Add a nullable guest_token column
            $table->string('guest_token')->nullable()->index();

            // Allow user_id to be nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Add a unique constraint to prevent duplication for the same product for the same guest or user
            $table->unique(['user_id', 'guest_token', 'product_id'], 'cart_unique_user_guest_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Remove the guest_token column
            $table->dropColumn('guest_token');

            // Revert user_id to non-nullable if needed (optional)
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            // Drop the unique constraint
            $table->dropUnique('cart_unique_user_guest_product');
        });
    }
}
