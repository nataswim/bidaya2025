<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_video', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['video_id', 'video_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_video');
    }
};