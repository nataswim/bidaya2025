<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cycle_seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_id')->constrained('cycles')->cascadeOnDelete();
            $table->foreignId('seance_id')->constrained('seances')->cascadeOnDelete();
            $table->integer('ordre'); // Ordre de la séance dans le cycle
            $table->integer('jour_semaine')->nullable(); // 1=Lundi, 7=Dimanche
            $table->integer('semaine_cycle')->default(1); // Semaine du cycle (1, 2, 3...)
            $table->text('notes')->nullable(); // Notes spécifiques
            $table->timestamps();
            
            $table->unique(['cycle_id', 'seance_id']);
            $table->index(['cycle_id', 'ordre']);
            $table->index(['cycle_id', 'semaine_cycle', 'jour_semaine']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cycle_seances');
    }
};