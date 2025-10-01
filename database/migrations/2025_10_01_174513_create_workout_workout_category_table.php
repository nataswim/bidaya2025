<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_workout_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained('workouts')->cascadeOnDelete();
            $table->foreignId('workout_category_id')->constrained('workout_categories')->cascadeOnDelete();
            $table->integer('order_number')->default(0);
            $table->timestamps();
            
            $table->unique(['workout_id', 'workout_category_id'], 'workout_category_unique');
            $table->unique(['workout_category_id', 'order_number'], 'category_order_unique');
            
            $table->index('workout_id');
            $table->index('workout_category_id');
            $table->index('order_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_workout_category');
    }
};