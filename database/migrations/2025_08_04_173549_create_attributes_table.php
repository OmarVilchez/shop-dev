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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: Tamaño, Color, Talla
            $table->string('slug')->unique(); // Ej: tamano, color, talla
            $table->text('description')->nullable(); // Descripción opcional
            $table->unsignedBigInteger('field_type_id');
            $table->boolean('is_variantable')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('field_type_id')->references('id')->on('field_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
