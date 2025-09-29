<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 🇬🇧 Run the migrations - Create fiches categories table
     * 🇫🇷 Exécuter les migrations - Créer la table des catégories de fiches
     */
    public function up(): void
    {
        Schema::create('fiches_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191); // 🇬🇧 Category name / 🇫🇷 Nom de la catégorie
            $table->string('slug', 191)->unique(); // 🇬🇧 URL slug / 🇫🇷 Slug pour URL
            $table->text('description')->nullable(); // 🇬🇧 Category description / 🇫🇷 Description de la catégorie
            $table->string('image')->nullable(); // 🇬🇧 Image path / 🇫🇷 Chemin de l'image
            $table->string('meta_title', 255)->nullable(); // 🇬🇧 SEO title / 🇫🇷 Titre SEO
            $table->text('meta_description')->nullable(); // 🇬🇧 SEO description / 🇫🇷 Description SEO
            $table->text('meta_keywords')->nullable(); // 🇬🇧 SEO keywords / 🇫🇷 Mots-clés SEO
            $table->boolean('is_active')->default(true); // 🇬🇧 Active status / 🇫🇷 Statut actif
            $table->integer('sort_order')->default(0); // 🇬🇧 Sort order / 🇫🇷 Ordre de tri
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // 🇬🇧 Creator / 🇫🇷 Créateur
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete(); // 🇬🇧 Updater / 🇫🇷 Modificateur
            $table->timestamps();
            $table->softDeletes(); // 🇬🇧 Soft delete / 🇫🇷 Suppression douce
            
            // 🇬🇧 Indexes for performance / 🇫🇷 Index pour les performances
            $table->index('is_active');
            $table->index('sort_order');
            $table->index(['is_active', 'deleted_at']);
        });
    }

    /**
     * 🇬🇧 Reverse the migrations
     * 🇫🇷 Annuler les migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('fiches_categories');
    }
};