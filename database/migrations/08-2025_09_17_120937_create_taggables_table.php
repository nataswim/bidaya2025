<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Execute les migrations.
     */
    public function up(): void
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->id();

            // Relation avec tags
            $table->foreignId('tag_id')
                  ->constrained('tags')
                  ->cascadeOnDelete();

            // Colonnes morphables (permettent d'associer un tag A plusieurs modeles)
            $table->morphs('taggable'); // cree taggable_id (bigint) + taggable_type (string)

            // Empêcher les doublons
            $table->unique(['tag_id', 'taggable_id', 'taggable_type'], 'taggables_unique');
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
    }
};
