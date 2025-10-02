<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table des carnets
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('content_type', 50); // 'posts', 'fiches', 'exercices', 'workouts', 'plans', 'downloadables'
            $table->string('color', 7)->default('#007bff');
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'content_type']);
            $table->index('is_favorite');
        });

        // Table pivot polymorphique pour les contenus
        Schema::create('notebook_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notebook_id')->constrained()->cascadeOnDelete();
            $table->morphs('notebookable'); // Crée automatiquement notebookable_type, notebookable_id ET l'index
            $table->integer('order')->default(0);
            $table->text('personal_note')->nullable();
            $table->timestamps();
            
            $table->index(['notebook_id', 'order']);
            // ❌ NE PAS ajouter : $table->index(['notebookable_type', 'notebookable_id']); (déjà créé par morphs())
            $table->unique(['notebook_id', 'notebookable_type', 'notebookable_id'], 'notebook_item_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notebook_items');
        Schema::dropIfExists('notebooks');
    }
};