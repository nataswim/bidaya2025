<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercice_id')->constrained('exercices')->cascadeOnDelete();
            $table->string('nom')->nullable(); // Nom optionnel pour la série
            $table->integer('repetitions')->nullable(); // Nombre de répétitions
            $table->integer('duree_secondes')->nullable(); // Durée en secondes (pour cardio)
            $table->decimal('distance_metres', 8, 2)->nullable(); // Distance en mètres
            $table->decimal('poids_kg', 5, 2)->nullable(); // Poids en kg
            $table->integer('repos_secondes')->default(60); // Temps de repos après la série
            $table->text('consignes')->nullable(); // Consignes spécifiques pour cette série
            $table->integer('ordre')->default(0);
            $table->boolean('is_active')->default(true);
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['exercice_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};