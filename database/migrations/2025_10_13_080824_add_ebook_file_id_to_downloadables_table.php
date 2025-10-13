<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('downloadables', function (Blueprint $table) {
            // Ajouter la colonne ebook_file_id
            $table->unsignedBigInteger('ebook_file_id')->nullable()->after('id');
            
            // Rendre file_path nullable car on peut utiliser ebook_file_id
            $table->string('file_path')->nullable()->change();
            
            // Clé étrangère vers ebook_files
            $table->foreign('ebook_file_id')
                  ->references('id')
                  ->on('ebook_files')
                  ->onDelete('set null');
            
            $table->index('ebook_file_id');
        });
    }

    public function down(): void
    {
        Schema::table('downloadables', function (Blueprint $table) {
            $table->dropForeign(['ebook_file_id']);
            $table->dropColumn('ebook_file_id');
            
            // Remettre file_path en non-nullable
            $table->string('file_path')->nullable(false)->change();
        });
    }
};