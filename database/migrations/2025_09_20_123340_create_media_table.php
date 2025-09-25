<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom d'affichage
            $table->string('file_name'); // Nom du fichier physique
            $table->string('original_name'); // Nom original du fichier uploade
            $table->string('mime_type');
            $table->string('path'); // Chemin relatif depuis storage/app/public
            $table->unsignedBigInteger('size'); // Taille en octets
            $table->json('metadata')->nullable(); // Dimensions, etc.
            $table->text('alt_text')->nullable(); // Texte alternatif pour l'accessibilite
            $table->text('description')->nullable();
            $table->unsignedBigInteger('media_category_id')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamp('used_at')->nullable(); // Derniere utilisation
            $table->timestamps();

            $table->foreign('media_category_id')->references('id')->on('media_categories')->onDelete('set null');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['media_category_id', 'created_at']);
            $table->index('mime_type');
            $table->index('used_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};