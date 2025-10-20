<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rendre les champs de classification optionnels dans toutes les tables d'entraînement
     */
    public function up(): void
    {
        // Table exercices
        Schema::table('exercices', function (Blueprint $table) {
            $table->string('niveau')->nullable()->change();
            $table->string('type_exercice')->nullable()->change();
            // muscles_cibles est déjà nullable
        });

        // Table seances
        Schema::table('seances', function (Blueprint $table) {
            $table->string('niveau')->nullable()->change();
            $table->string('type_seance')->nullable()->change();
        });

        // Table plans
        Schema::table('plans', function (Blueprint $table) {
            $table->string('niveau')->nullable()->change();
            $table->string('objectif')->nullable()->change();
        });

        // Table cycles
        Schema::table('cycles', function (Blueprint $table) {
            $table->string('objectif')->nullable()->change();
        });
    }

    /**
     * Restaurer les contraintes (sans données perdues)
     */
    public function down(): void
    {
        // Restaurer les valeurs par défaut pour les champs NULL
        DB::table('exercices')->whereNull('niveau')->update(['niveau' => 'debutant']);
        DB::table('exercices')->whereNull('type_exercice')->update(['type_exercice' => 'force']);
        
        DB::table('seances')->whereNull('niveau')->update(['niveau' => 'debutant']);
        DB::table('seances')->whereNull('type_seance')->update(['type_seance' => 'mixte']);
        
        DB::table('plans')->whereNull('niveau')->update(['niveau' => 'debutant']);
        DB::table('plans')->whereNull('objectif')->update(['objectif' => 'mixte']);
        
        DB::table('cycles')->whereNull('objectif')->update(['objectif' => 'mixte']);

        // Remettre les contraintes
        Schema::table('exercices', function (Blueprint $table) {
            $table->string('niveau')->nullable(false)->change();
            $table->string('type_exercice')->nullable(false)->change();
        });

        Schema::table('seances', function (Blueprint $table) {
            $table->string('niveau')->nullable(false)->change();
            $table->string('type_seance')->nullable(false)->change();
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->string('niveau')->nullable(false)->change();
            $table->string('objectif')->nullable(false)->change();
        });

        Schema::table('cycles', function (Blueprint $table) {
            $table->string('objectif')->nullable(false)->change();
        });
    }
};