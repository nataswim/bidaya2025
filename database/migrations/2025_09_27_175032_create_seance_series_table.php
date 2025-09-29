<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seance_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seance_id')->constrained('seances')->cascadeOnDelete();
            $table->foreignId('serie_id')->constrained('series')->cascadeOnDelete();
            $table->integer('ordre'); // Ordre de la série dans la séance
            $table->integer('nombre_series')->default(1); // Combien de fois répéter cette série
            $table->text('notes')->nullable(); // Notes spécifiques pour cette série dans cette séance
            $table->timestamps();
            
            $table->unique(['seance_id', 'serie_id']);
            $table->index(['seance_id', 'ordre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seance_series');
    }
};