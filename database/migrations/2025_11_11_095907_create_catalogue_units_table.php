<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 🇬🇧 Run the migrations - Create catalogue units table
     * 🇫🇷 Exécuter les migrations - Créer la table des unités du catalogue
     */
    public function up(): void
    {
        Schema::create('catalogue_units', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            
            // 🇬🇧 Module relationship / 🇫🇷 Relation avec le module
            $table->foreignId('catalogue_module_id')->constrained('catalogue_modules')->cascadeOnDelete();
            
            // 🇬🇧 Polymorphic relationship to content / 🇫🇷 Relation polymorphique vers le contenu
            $table->string('unitable_type')->nullable();
            $table->unsignedBigInteger('unitable_id')->nullable();
            
            // 🇬🇧 Audit trail / 🇫🇷 Traçabilité
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // 🇬🇧 Indexes for performance / 🇫🇷 Index pour les performances
            $table->index('is_active');
            $table->index('order');
            $table->index('catalogue_module_id');
            $table->index(['unitable_type', 'unitable_id']);
            $table->index(['is_active', 'deleted_at']);
            $table->unique(['slug', 'catalogue_module_id', 'deleted_at']);
        });
    }

    /**
     * 🇬🇧 Reverse the migrations
     * 🇫🇷 Annuler les migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogue_units');
    }
};