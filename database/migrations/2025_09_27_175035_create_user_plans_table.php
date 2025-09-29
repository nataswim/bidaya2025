<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->date('date_debut')->nullable(); // Quand l'utilisateur a commencé
            $table->date('date_fin_prevue')->nullable(); // Date de fin prévue
            $table->enum('statut', ['non_commence', 'en_cours', 'pause', 'termine', 'abandonne'])->default('non_commence');
            $table->integer('progression_pourcentage')->default(0); // % de progression
            $table->text('notes_utilisateur')->nullable(); // Notes personnelles
            $table->json('preferences')->nullable(); // Préférences spécifiques
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete(); // Qui a assigné
            $table->timestamps();
            
            $table->unique(['user_id', 'plan_id']);
            $table->index(['user_id', 'statut']);
            $table->index(['plan_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_plans');
    }
};