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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->float('amount',8,2);
            $table->text('notes')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('order_date');
            $table->string('order_month');
            $table->string('order_year');
            $table->string('return_date')->nullable();
            $table->integer('return_order')->default(null);
            $table->string('status'); 
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->timestamps();
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
