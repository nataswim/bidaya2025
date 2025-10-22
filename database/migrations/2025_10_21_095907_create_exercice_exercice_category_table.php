<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercice_exercice_category', function (Blueprint $table) {
            $table->id();
            
            // Colonnes avec foreign keys NOMMÉES explicitement
            $table->unsignedBigInteger('exercice_id');
            $table->unsignedBigInteger('exercice_category_id');
            
            $table->integer('ordre')->default(0);
            $table->timestamps();
            
            // Foreign keys avec noms courts explicites
            $table->foreign('exercice_id', 'ex_cat_exercice_fk')
                  ->references('id')
                  ->on('exercices')
                  ->cascadeOnDelete();
            
            $table->foreign('exercice_category_id', 'ex_cat_category_fk')
                  ->references('id')
                  ->on('exercice_categories')
                  ->cascadeOnDelete();
            
            // Index pour performances
            $table->index('exercice_id', 'ex_cat_exercice_idx');
            $table->index('exercice_category_id', 'ex_cat_category_idx');
            
            // Unique avec nom court
            $table->unique(['exercice_id', 'exercice_category_id'], 'ex_cat_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercice_exercice_category');
    }
};