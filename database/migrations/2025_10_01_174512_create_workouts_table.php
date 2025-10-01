<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->text('short_description');
            $table->longText('long_description')->nullable();
            $table->integer('total')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('deleted_at');
            $table->unique(['slug', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};