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
        Schema::create('sku_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_keeping_unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade');
            $table->foreignId('attribute_value_id')->constrained('attribute_values')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['stock_keeping_unit_id', 'attribute_id', 'attribute_value_id'], 'sku_attr_attrval_unique');

            //$table->unique(['stock_keeping_unit_id', 'attribute_id']); // 1 SKU solo puede tener 1 color, 1 talla, etc.
            //$table->unique(['stock_keeping_unit_id', 'attribute_value_id']); // 1 SKU solo puede tener 1 valor de atributo específico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sku_attribute_values');
    }
};
