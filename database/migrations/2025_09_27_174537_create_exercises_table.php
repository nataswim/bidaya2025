<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercices', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('image')->nullable(); // URL vers media
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance', 'special'])->default('debutant');
            $table->json('muscles_cibles')->nullable(); // ["biceps", "triceps", ...]
            $table->text('consignes_securite')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('type_exercice', ['cardio', 'force', 'flexibilite', 'equilibre'])->default('force');
            $table->boolean('is_active')->default(true);
            $table->integer('ordre')->default(0);
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['niveau', 'type_exercice', 'is_active']);
            $table->index(['is_active', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercices');
    }
};