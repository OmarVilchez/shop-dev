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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade'); // Color, Talla, etc.
            $table->string('value'); // "Rojo", "Verde Melón", etc.
            $table->string('slug')->nullable(); // "rojo", "verde-melon"
            $table->string('image')->nullable(); // Ej: "/storage/colors/verde-melon.png"
            $table->integer('position')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
