<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrer les catégories existantes vers la table pivot
        DB::statement("
            INSERT INTO exercice_exercice_category (exercice_id, exercice_category_id, ordre, created_at, updated_at)
            SELECT id, exercice_category_id, 0, NOW(), NOW()
            FROM exercices
            WHERE exercice_category_id IS NOT NULL
        ");
        
        // Migrer les sous-catégories existantes vers la table pivot
        DB::statement("
            INSERT INTO exercice_exercice_sous_category (exercice_id, exercice_sous_category_id, ordre, created_at, updated_at)
            SELECT id, exercice_sous_category_id, 0, NOW(), NOW()
            FROM exercices
            WHERE exercice_sous_category_id IS NOT NULL
        ");
    }

    public function down(): void
    {
        // Vider les tables pivot
        DB::table('exercice_exercice_category')->truncate();
        DB::table('exercice_exercice_sous_category')->truncate();
    }
};