<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajouter les relations catégories aux exercices
     */
    public function up(): void
    {
        Schema::table('exercices', function (Blueprint $table) {
            // Relation avec catégorie (après image)
            $table->foreignId('exercice_category_id')
                  ->nullable()
                  ->after('image')
                  ->constrained('exercice_categories')
                  ->nullOnDelete();
            
            // Relation avec sous-catégorie
            $table->foreignId('exercice_sous_category_id')
                  ->nullable()
                  ->after('exercice_category_id')
                  ->constrained('exercice_sous_categories')
                  ->nullOnDelete();
            
            // Index pour performances
            $table->index('exercice_category_id');
            $table->index('exercice_sous_category_id');
        });
    }

    /**
     * Annuler les migrations
     */
    public function down(): void
    {
        Schema::table('exercices', function (Blueprint $table) {
            $table->dropForeign(['exercice_category_id']);
            $table->dropForeign(['exercice_sous_category_id']);
            $table->dropIndex(['exercice_category_id']);
            $table->dropIndex(['exercice_sous_category_id']);
            $table->dropColumn(['exercice_category_id', 'exercice_sous_category_id']);
        });
    }
};