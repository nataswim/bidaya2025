<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 🇬🇧 Run the migrations - Add sous_category to fiches
     * 🇫🇷 Exécuter les migrations - Ajouter sous_category aux fiches
     */
    public function up(): void
    {
        Schema::table('fiches', function (Blueprint $table) {
            // 🇬🇧 Add sub-category relationship / 🇫🇷 Ajouter la relation sous-catégorie
            $table->foreignId('fiches_sous_category_id')
                  ->nullable()
                  ->after('fiches_category_id')
                  ->constrained('fiches_sous_categories')
                  ->nullOnDelete();
            
            // 🇬🇧 Index for performance / 🇫🇷 Index pour les performances
            $table->index('fiches_sous_category_id');
        });
    }

    /**
     * 🇬🇧 Reverse the migrations
     * 🇫🇷 Annuler les migrations
     */
    public function down(): void
    {
        Schema::table('fiches', function (Blueprint $table) {
            $table->dropForeign(['fiches_sous_category_id']);
            $table->dropIndex(['fiches_sous_category_id']);
            $table->dropColumn('fiches_sous_category_id');
        });
    }
};