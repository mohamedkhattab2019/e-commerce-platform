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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');    // Foreign key to orders
            $table->string('payment_method');          // Payment method (e.g., Credit Card, PayPal)
            $table->string('transaction_id')->nullable(); // Transaction ID
            $table->decimal('amount', 10, 2);          // Payment amount
            $table->string('status')->default('pending'); // Payment status
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
