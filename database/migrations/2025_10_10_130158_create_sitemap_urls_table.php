<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sitemap_urls', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500)->unique();
            $table->enum('type', ['static', 'dynamic', 'manual'])->default('dynamic');
            $table->string('source', 50)->nullable(); // posts, fiches, exercices, plans, etc.
            $table->unsignedBigInteger('source_id')->nullable();
            $table->decimal('priority', 2, 1)->default(0.5); // 0.0 à 1.0
            $table->enum('changefreq', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])->default('weekly');
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_modified')->nullable();
            $table->timestamps();

            // Index pour performances
            $table->index(['type', 'is_approved', 'is_active']);
            $table->index(['source', 'source_id']);
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitemap_urls');
    }
};