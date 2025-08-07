<?php

use App\Models\Announcement;
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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content')->nullable();
            $table->enum('type', [Announcement::INFO, Announcement::TIMER]);
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->string('image')->nullable();
            $table->string('link_url')->nullable();
            $table->smallInteger('position')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
