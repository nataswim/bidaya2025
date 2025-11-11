<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 🇬🇧 Run the migrations - Create catalogue modules table
     * 🇫🇷 Exécuter les migrations - Créer la table des modules du catalogue
     */
    public function up(): void
    {
        Schema::create('catalogue_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            
            // 🇬🇧 Section relationship / 🇫🇷 Relation avec la section
            $table->foreignId('catalogue_section_id')->constrained('catalogue_sections')->cascadeOnDelete();
            
            // 🇬🇧 SEO fields / 🇫🇷 Champs SEO
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            // 🇬🇧 Audit trail / 🇫🇷 Traçabilité
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // 🇬🇧 Indexes for performance / 🇫🇷 Index pour les performances
            $table->index('is_active');
            $table->index('order');
            $table->index('catalogue_section_id');
            $table->index(['is_active', 'deleted_at']);
            $table->unique(['slug', 'catalogue_section_id', 'deleted_at']);
        });
    }

    /**
     * 🇬🇧 Reverse the migrations
     * 🇫🇷 Annuler les migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogue_modules');
    }
};