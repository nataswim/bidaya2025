<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ebook_files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom d'affichage
            $table->string('file_name'); // Nom du fichier physique
            $table->string('original_name'); // Nom original uploadé
            $table->string('format'); // pdf, epub, mp4, zip, doc, docx
            $table->string('mime_type');
            $table->string('path'); // Chemin relatif depuis storage/app/ebooks
            $table->unsignedBigInteger('size'); // Taille en octets
            $table->text('description')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamp('used_at')->nullable(); // Dernière utilisation
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('format');
            $table->index('used_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebook_files');
    }
};