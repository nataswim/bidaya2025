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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informations générales
            $table->string('discipline')->nullable(); // ex: Course à pied, Natation
            $table->string('title'); // Titre de l'activité
            $table->string('objective')->nullable(); // Objectif de l'activité
            $table->enum('type', ['entrainement', 'rendez-vous', 'stage', 'competition', 'autres'])->default('entrainement');
            $table->string('color', 7)->default('#007bff'); // Couleur selon le type
            
            // Date et lieu
            $table->date('event_date');
            $table->time('event_time');
            $table->string('location')->nullable();
            
            // Détails planification
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            $table->text('material')->nullable(); // Matériel nécessaire
            $table->string('planned_duration')->nullable(); // Durée prévue (ex: 1h30)
            $table->string('planned_distance')->nullable(); // Distance prévue (ex: 10km)
            
            // Liaison à un contenu
            $table->string('linkable_type')->nullable(); // Workout, Plan, etc.
            $table->unsignedBigInteger('linkable_id')->nullable();
            
            // Statut de l'événement
            $table->enum('status', ['planned', 'completed', 'cancelled'])->default('planned');
            
            // Données post-activité (finalisation)
            $table->integer('effort_feeling')->nullable(); // 1-10
            $table->enum('objective_achieved', ['not_achieved', 'achieved', 'exceeded'])->nullable();
            $table->string('actual_duration')->nullable(); // Durée réelle
            $table->string('actual_distance')->nullable(); // Distance réelle
            $table->enum('weather_conditions', ['sunny', 'cloudy', 'rainy', 'windy', 'cold', 'hot'])->nullable();
            $table->text('pain_discomfort')->nullable(); // Douleurs/Gênes
            
            $table->timestamps();
            
            // Index
            $table->index(['user_id', 'event_date']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};