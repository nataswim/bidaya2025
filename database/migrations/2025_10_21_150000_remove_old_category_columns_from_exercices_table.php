<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifier que les colonnes existent avant de les supprimer
        if (Schema::hasColumn('exercices', 'exercice_category_id')) {
            Schema::table('exercices', function (Blueprint $table) {
                $table->dropForeign(['exercice_category_id']);
                $table->dropIndex(['exercice_category_id']);
                $table->dropColumn('exercice_category_id');
            });
        }
        
        if (Schema::hasColumn('exercices', 'exercice_sous_category_id')) {
            Schema::table('exercices', function (Blueprint $table) {
                $table->dropForeign(['exercice_sous_category_id']);
                $table->dropIndex(['exercice_sous_category_id']);
                $table->dropColumn('exercice_sous_category_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('exercices', function (Blueprint $table) {
            $table->foreignId('exercice_category_id')->nullable()->constrained('exercice_categories')->nullOnDelete();
            $table->foreignId('exercice_sous_category_id')->nullable()->constrained('exercice_sous_categories')->nullOnDelete();
            $table->index('exercice_category_id');
            $table->index('exercice_sous_category_id');
        });
    }
};