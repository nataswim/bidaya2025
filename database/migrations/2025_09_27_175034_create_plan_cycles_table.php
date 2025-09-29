<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_cycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->foreignId('cycle_id')->constrained('cycles')->cascadeOnDelete();
            $table->integer('ordre'); // Ordre du cycle dans le plan
            $table->integer('semaine_debut')->default(1); // À quelle semaine du plan ce cycle commence
            $table->text('notes')->nullable(); // Notes spécifiques
            $table->timestamps();
            
            $table->unique(['plan_id', 'cycle_id']);
            $table->index(['plan_id', 'ordre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_cycles');
    }
};