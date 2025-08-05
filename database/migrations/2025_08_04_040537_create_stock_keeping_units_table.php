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
        Schema::create('stock_keeping_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('internal_id')->nullable();
            $table->string('name');
            $table->string('trade_name')->nullable();
            $table->text('description')->nullable();
            $table->string('slug');
            $table->boolean('active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_keeping_units');
    }
};
