<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Type de source vidéo
            $table->enum('type', ['upload', 'url', 'youtube', 'vimeo', 'dailymotion'])->default('upload');
            
            // Pour les uploads
            $table->string('file_path')->nullable();
            $table->string('file_size')->nullable();
            $table->string('mime_type')->nullable();
            
            // Pour les URLs externes
            $table->string('external_url')->nullable();
            $table->string('external_id')->nullable();
            
            // Métadonnées
            $table->string('thumbnail')->nullable();
            $table->integer('duration')->nullable(); // en secondes
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            
            // Visibilité et publication
            $table->enum('visibility', ['public', 'authenticated'])->default('public');
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            
            // Statistiques
            $table->integer('views_count')->default(0);
            
            // Tracking
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('created_by_name')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index('type');
            $table->index('visibility');
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('views_count');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};