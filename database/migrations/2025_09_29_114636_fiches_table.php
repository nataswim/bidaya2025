<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 🇬🇧 Run the migrations - Create fiches table
     * 🇫🇷 Exécuter les migrations - Créer la table des fiches
     */
    public function up(): void
    {
        Schema::create('fiches', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191); // 🇬🇧 Fiche title / 🇫🇷 Titre de la fiche
            $table->string('slug', 191)->unique(); // 🇬🇧 URL slug / 🇫🇷 Slug pour URL
            $table->text('short_description'); // 🇬🇧 Short description (always visible) / 🇫🇷 Description courte (toujours visible)
            $table->longText('long_description')->nullable(); // 🇬🇧 Long description / 🇫🇷 Description longue
            $table->string('image')->nullable(); // 🇬🇧 Featured image path / 🇫🇷 Chemin de l'image principale
            $table->string('visibility', 50)->default('public'); // 🇬🇧 Visibility (public/authenticated) / 🇫🇷 Visibilité (public/authentifié)
            $table->boolean('is_published')->default(false); // 🇬🇧 Publication status / 🇫🇷 Statut de publication
            $table->boolean('is_featured')->default(false); // 🇬🇧 Featured status / 🇫🇷 Statut mis en avant
            $table->integer('views_count')->default(0); // 🇬🇧 Views counter / 🇫🇷 Compteur de vues
            $table->integer('sort_order')->default(0); // 🇬🇧 Sort order / 🇫🇷 Ordre de tri
            
            // 🇬🇧 SEO fields / 🇫🇷 Champs SEO
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_og_image', 255)->nullable();
            $table->string('meta_og_url', 255)->nullable();
            
            // 🇬🇧 Audit trail / 🇫🇷 Traçabilité
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('created_by_name', 150)->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamp('published_at')->nullable(); // 🇬🇧 Publication date / 🇫🇷 Date de publication
            $table->timestamps();
            $table->softDeletes();
            
            // 🇬🇧 Indexes for performance / 🇫🇷 Index pour les performances
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('visibility');
            $table->index('sort_order');
            $table->index('published_at');
            $table->index(['is_published', 'published_at', 'deleted_at']);
            $table->index(['visibility', 'is_published', 'deleted_at']);
            $table->unique(['slug', 'deleted_at']);
        });
    }

    /**
     * 🇬🇧 Reverse the migrations
     * 🇫🇷 Annuler les migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('fiches');
    }
};