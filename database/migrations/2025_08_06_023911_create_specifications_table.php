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
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specification_group_id');
            $table->unsignedBigInteger('field_type_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('filter')->default(false);
            $table->boolean('required')->default(false);
            $table->boolean('product_detail')->default(true);
            $table->boolean('sku_detail')->default(false);
            $table->boolean('active')->default(true);
            $table->foreign('specification_group_id')->references('id')->on('specification_groups');
            $table->foreign('field_type_id')->references('id')->on('field_types');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifications');
    }
};
