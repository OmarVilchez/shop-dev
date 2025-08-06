<?php

use App\Models\QuantitySkuPrice;
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
        Schema::create('quantity_sku_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_keeping_unit_id');
            $table->unsignedBigInteger('quantity_id')->nullable();
            $table->enum('apply_to', [QuantitySkuPrice::PRODUCT, QuantitySkuPrice::QUANTITY])->default(QuantitySkuPrice::QUANTITY);
            $table->decimal('cost_price', 14, 2)->default(0);
            $table->decimal('markup', 14, 2)->default(0);
            $table->decimal('base_price', 14, 2)->default(0);
            $table->foreign('quantity_id')->references('id')->on('quantities');
            $table->foreign('stock_keeping_unit_id')->references('id')->on('stock_keeping_units');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantity_sku_prices');
    }
};
