<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Créer la table pivot pour les contenus multiples par unité
     */
    public function up(): void
    {
        Schema::create('catalogue_unit_contents', function (Blueprint $table) {
            $table->id();
            
            // Relation avec l'unité
            $table->foreignId('catalogue_unit_id')
                  ->constrained('catalogue_units')
                  ->cascadeOnDelete();
            
            // Relation polymorphe vers le contenu
            $table->string('contentable_type');
            $table->unsignedBigInteger('contentable_id');
            
            // Ordre d'affichage du contenu dans l'unité
            $table->integer('order')->default(0);
            
            // Métadonnées optionnelles
            $table->string('custom_title')->nullable(); // Titre alternatif pour ce contexte
            $table->text('custom_description')->nullable(); // Description spécifique
            $table->integer('duration_minutes')->nullable(); // Durée estimée
            $table->boolean('is_required')->default(true); // Obligatoire ou optionnel
            $table->boolean('is_active')->default(true);
            
            // Traçabilité
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            
            // Index pour les performances
            $table->index(['contentable_type', 'contentable_id']);
            $table->index(['catalogue_unit_id', 'order']);
            $table->index('is_active');
            
            // Contrainte unique : un même contenu ne peut être lié qu'une fois à une unité
            $table->unique(['catalogue_unit_id', 'contentable_type', 'contentable_id'], 'unique_unit_content');
        });
    }

    /**
     * Annuler la migration
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogue_unit_contents');
    }
};