<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Execute les migrations.
     */
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();

            // Cle etrangere vers roles
            $table->foreignId('role_id')
                  ->constrained('roles')
                  ->cascadeOnDelete();

            // Cle etrangere vers permissions
            $table->foreignId('permission_id')
                  ->constrained('permissions')
                  ->cascadeOnDelete();

            $table->timestamps();

            // Empêcher les doublons
            $table->unique(['role_id', 'permission_id']);
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
