<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance', 'special'])->default('debutant');
            $table->integer('duree_estimee_minutes')->nullable(); // Durée estimée de la séance
            $table->enum('type_seance', ['force', 'cardio', 'mixte', 'recuperation'])->default('mixte');
            $table->text('materiel_requis')->nullable(); // Matériel nécessaire
            $table->text('echauffement')->nullable(); // Instructions d'échauffement
            $table->text('retour_calme')->nullable(); // Instructions de retour au calme
            $table->string('image')->nullable(); // Image de la séance
            $table->boolean('is_active')->default(true);
            $table->integer('ordre')->default(0);
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['niveau', 'type_seance', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};