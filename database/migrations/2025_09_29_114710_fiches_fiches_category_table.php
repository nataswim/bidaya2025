<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 🇬🇧 Run the migrations - Create fiches_fiches_category pivot table
     * 🇫🇷 Exécuter les migrations - Créer la table pivot fiches_fiches_category
     */
    public function up(): void
    {
        Schema::create('fiches_fiches_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiche_id')->constrained('fiches')->onDelete('cascade'); // 🇬🇧 Fiche reference / 🇫🇷 Référence à la fiche
            $table->foreignId('fiches_category_id')->constrained('fiches_categories')->onDelete('cascade'); // 🇬🇧 Category reference / 🇫🇷 Référence à la catégorie
            $table->timestamps();
            
            // 🇬🇧 Unique constraint to prevent duplicates / 🇫🇷 Contrainte unique pour éviter les doublons
            $table->unique(['fiche_id', 'fiches_category_id'], 'fiche_category_unique');
            
            // 🇬🇧 Indexes for performance / 🇫🇷 Index pour les performances
            $table->index('fiche_id');
            $table->index('fiches_category_id');
        });
    }

    /**
     * 🇬🇧 Reverse the migrations
     * 🇫🇷 Annuler les migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('fiches_fiches_category');
    }
};