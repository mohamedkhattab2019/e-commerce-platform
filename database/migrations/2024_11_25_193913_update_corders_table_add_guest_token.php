<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('guest_token')->nullable()->after('user_id'); // Add guest_token column after user_id
            $table->unsignedBigInteger('user_id')->nullable()->change(); // Make user_id nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('guest_token'); // Remove guest_token column
            $table->unsignedBigInteger('user_id')->nullable(false)->change(); // Revert user_id to not nullable
        });
    }
};
