<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Migrer les contenus existants vers la nouvelle structure
     */
    public function up(): void
    {
        // Récupérer toutes les unités avec du contenu
        $units = DB::table('catalogue_units')
                   ->whereNotNull('unitable_type')
                   ->whereNotNull('unitable_id')
                   ->get();
        
        foreach ($units as $unit) {
            // Insérer dans la nouvelle table pivot
            DB::table('catalogue_unit_contents')->insert([
                'catalogue_unit_id' => $unit->id,
                'contentable_type' => $unit->unitable_type,
                'contentable_id' => $unit->unitable_id,
                'order' => 1,
                'is_required' => true,
                'is_active' => true,
                'created_by' => $unit->created_by,
                'updated_by' => $unit->updated_by,
                'created_at' => $unit->created_at,
                'updated_at' => $unit->updated_at,
            ]);
        }
        
        // Optionnel : supprimer les anciennes colonnes après vérification
        // Schema::table('catalogue_units', function (Blueprint $table) {
        //     $table->dropColumn(['unitable_type', 'unitable_id']);
        // });
    }

    /**
     * Annuler la migration
     */
    public function down(): void
    {
        // Vider la table pivot
        DB::table('catalogue_unit_contents')->truncate();
        
        // Si les colonnes ont été supprimées, les recréer
        // Schema::table('catalogue_units', function (Blueprint $table) {
        //     $table->string('unitable_type')->nullable();
        //     $table->unsignedBigInteger('unitable_id')->nullable();
        // });
    }
};