<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->nullable()->index();
            $table->text('description')->nullable();
            $table->string('group_name', 100)->nullable()->index();
            $table->string('image', 255)->nullable();

            // Champs SEO
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Ordre et statut
            $table->unsignedInteger('order')->nullable()->index();
            $table->string('status', 50)->default('active')->index();

            // Audit (créateur, modificateur, suppression)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Index supplémentaires
            $table->index(['status', 'deleted_at']);
            $table->index(['group_name', 'status']);
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
