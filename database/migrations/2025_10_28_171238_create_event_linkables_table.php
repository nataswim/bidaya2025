<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_linkables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('linkable_type'); // Workout ou Exercice
            $table->unsignedBigInteger('linkable_id');
            $table->integer('order')->default(0); // Pour l'ordre des exercices
            $table->timestamps();
            
            // Index pour performance
            $table->index(['event_id', 'linkable_type']);
            $table->index(['linkable_type', 'linkable_id']);
            
            // Index composite pour éviter les doublons
            $table->unique(['event_id', 'linkable_type', 'linkable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_linkables');
    }
};