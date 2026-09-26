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
        Schema::create('products', function (Blueprint $table) {
            $table->id('PID');
            $table->string('PName');
            $table->integer('Qty')->default(0);
            $table->integer('MinStock')->default(10);
            $table->decimal('Price', 10, 2);
            $table->date('ExpiredDate')->nullable();
            $table->unsignedBigInteger('CatID');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('CatID')->references('CatID')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
