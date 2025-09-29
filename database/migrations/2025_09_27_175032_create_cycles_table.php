<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cycles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('duree_semaines')->nullable(); // Durée prévue en semaines
            $table->enum('objectif', ['force', 'endurance', 'perte_poids', 'prise_masse', 'recuperation', 'mixte'])->default('mixte');
            $table->text('conseils')->nullable(); // Conseils généraux pour le cycle
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('ordre')->default(0);
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['objectif', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cycles');
    }
};