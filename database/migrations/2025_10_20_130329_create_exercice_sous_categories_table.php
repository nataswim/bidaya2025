<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Créer la table des sous-catégories d'exercices
     */
    public function up(): void
    {
        Schema::create('exercice_sous_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('slug', 191)->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            
            // Relation avec la catégorie parente
            $table->foreignId('exercice_category_id')->constrained('exercice_categories')->cascadeOnDelete();
            
            // Champs SEO
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            
            // Traçabilité
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour performances
            $table->index('is_active');
            $table->index('sort_order');
            $table->index('exercice_category_id');
            $table->unique(['slug', 'deleted_at']);
        });
    }

    /**
     * Annuler les migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('exercice_sous_categories');
    }
};