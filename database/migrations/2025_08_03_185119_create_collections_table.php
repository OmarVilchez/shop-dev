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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_collection_id');
            $table->string('name');
            $table->text('description');
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('img_desktop')->nullable();
            $table->string('img_mobile')->nullable();
            $table->smallInteger('position')->default(0);
            $table->boolean('active')->default(true);
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->foreign('type_collection_id')->references('id')->on('type_collections');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
