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
        Schema::create('frequent_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_question_id');
            $table->string('name');
            $table->text('description');
            $table->smallInteger('position')->default(0);
            $table->foreign('section_question_id')->references('id')->on('section_questions');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequent_questions');
    }
};
