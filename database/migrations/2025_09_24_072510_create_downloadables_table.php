<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('downloadables', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 200)->index();
            $table->enum('format', ['pdf', 'epub', 'mp4', 'zip', 'doc', 'docx'])->index();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('file_path', 500);
            $table->string('file_size', 50)->nullable(); // Taille du fichier (ex: "2.5 MB")
            $table->string('cover_image')->nullable();
            
            // CatÃ©gorie
            $table->foreignId('download_category_id')->constrained('download_categories')->cascadeOnDelete();
            
            // Permissions d'accÃ¨s
            $table->enum('user_permission', ['public', 'visitor', 'user'])->default('public')->index();
            
            // Statistiques
            $table->unsignedInteger('download_count')->default(0)->index();
            $table->unsignedInteger('order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->boolean('is_featured')->default(false)->index();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('created_by_name', 150)->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['status', 'user_permission', 'deleted_at']);
            $table->index(['download_category_id', 'status', 'order']);
            $table->index(['is_featured', 'status']);
            $table->unique(['slug', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downloadables');
    }
};