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
        Schema::create('specification_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specification_id');
            $table->longText('name');
            $table->string('description')->nullable();
            $table->smallInteger('position')->default(0);
            $table->boolean('active')->default(true);
            $table->foreign('specification_id')->references('id')->on('specifications');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_values');
    }
};
