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
        Schema::create('quantity_sku_promotion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity_id')->nullable();
            $table->unsignedBigInteger('stock_keeping_unit_id');
            $table->unsignedBigInteger('promotion_id');
            $table->foreign('quantity_id')->references('id')->on('quantities');
            $table->foreign('stock_keeping_unit_id')->references('id')->on('stock_keeping_units');
            $table->foreign('promotion_id')->references('id')->on('promotions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantity_sku_promotion');
    }
};
