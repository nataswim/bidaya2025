<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercice_exercice_sous_category', function (Blueprint $table) {
            $table->id();
            
            // Colonnes avec foreign keys NOMMÉES explicitement (noms courts)
            $table->unsignedBigInteger('exercice_id');
            $table->unsignedBigInteger('exercice_sous_category_id');
            
            $table->integer('ordre')->default(0);
            $table->timestamps();
            
            // Foreign keys avec noms courts explicites
            $table->foreign('exercice_id', 'ex_scat_exercice_fk')
                  ->references('id')
                  ->on('exercices')
                  ->cascadeOnDelete();
            
            $table->foreign('exercice_sous_category_id', 'ex_scat_sous_cat_fk')
                  ->references('id')
                  ->on('exercice_sous_categories')
                  ->cascadeOnDelete();
            
            // Index pour performances
            $table->index('exercice_id', 'ex_scat_exercice_idx');
            $table->index('exercice_sous_category_id', 'ex_scat_sous_cat_idx');
            
            // Unique avec nom court
            $table->unique(['exercice_id', 'exercice_sous_category_id'], 'ex_scat_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercice_exercice_sous_category');
    }
};