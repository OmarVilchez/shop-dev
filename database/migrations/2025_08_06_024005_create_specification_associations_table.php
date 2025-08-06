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
        Schema::create('specification_associations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specification_id');
            $table->unsignedBigInteger('specification_value_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('stock_keeping_unit_id')->nullable();
            $table->foreign('specification_id')->references('id')->on('specifications');
            $table->foreign('specification_value_id')->references('id')->on('specification_values');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('stock_keeping_unit_id')->references('id')->on('stock_keeping_units');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_associations');
    }
};
