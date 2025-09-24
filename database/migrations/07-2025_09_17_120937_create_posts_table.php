<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ExÃ©cute les migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 200)->nullable()->index();
            $table->text('intro')->nullable();
            $table->longText('content')->nullable();
            $table->string('type', 50)->nullable()->index();

            // Relation avec catÃ©gories
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('category_name', 150)->nullable();

            // Mise en avant et image
            $table->boolean('is_featured')->default(false)->index();
            $table->string('image', 255)->nullable();

            // Champs SEO
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_og_image', 255)->nullable();
            $table->string('meta_og_url', 255)->nullable();

            // Statistiques et ordre
            $table->unsignedInteger('hits')->default(0)->index();
            $table->unsignedInteger('order')->nullable();

            // Statut et modÃ©ration
            $table->string('status', 50)->default('published')->index();
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('moderated_at')->nullable();

            // Audit (crÃ©ateur, modificateur, suppression)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('created_by_name', 150)->nullable();
            $table->string('created_by_alias', 150)->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            // Publication
            $table->timestamp('published_at')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();

            // Index supplÃ©mentaires
            $table->index(['status', 'published_at', 'deleted_at']);
            $table->index(['type', 'status', 'deleted_at']);
            $table->index(['is_featured', 'status', 'published_at']);
            $table->unique(['slug', 'deleted_at']);
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
