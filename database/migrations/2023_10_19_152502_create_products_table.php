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
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_qty');
            $table->string('product_tags')->nullable();
            $table->string('weight')->nullable();
            $table->string('selling_price');
            $table->string('discount_price')->nullable();
            $table->text('short_des');
            $table->text('long_des');
            $table->integer('show_slider')->nullable();
            $table->integer('week_deals')->nullable();
            $table->integer('special_offer')->nullable();
            $table->integer('new_products')->nullable();
            $table->integer('discount_products')->nullable();
            $table->integer('status')->default(0); 
            $table->timestamps();
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
