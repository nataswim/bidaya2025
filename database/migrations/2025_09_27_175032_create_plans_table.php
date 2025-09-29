<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance', 'special'])->default('debutant');
            $table->integer('duree_semaines')->nullable(); // Durée totale prévue
            $table->enum('objectif', ['force', 'endurance', 'perte_poids', 'prise_masse', 'recuperation', 'mixte'])->default('mixte');
            $table->text('prerequis')->nullable(); // Prérequis pour suivre ce plan
            $table->text('conseils_generaux')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_public')->default(true); // Visible par tous les users
            $table->boolean('is_featured')->default(false); // Plan mis en avant
            $table->boolean('is_active')->default(true);
            $table->integer('ordre')->default(0);
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['niveau', 'objectif', 'is_public', 'is_active']);
            $table->index(['is_featured', 'is_public', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};