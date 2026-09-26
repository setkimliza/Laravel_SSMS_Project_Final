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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('OrderID');
            $table->unsignedBigInteger('UserID');
            $table->decimal('TotalAmount', 12, 2);
            $table->dateTime('OrderDate');
            $table->string('Status')->default('Completed');
            $table->string('payment_method')->default('Cash on Delivery');
            $table->text('shipping_address')->nullable();
            $table->text('customer_notes')->nullable();
            $table->timestamps();

            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
