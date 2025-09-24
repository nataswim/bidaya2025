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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 120)->unique()->index();
            $table->string('display_name', 100)->nullable();
            $table->text('description')->nullable();
            $table->integer('level')->default(0)->index();
            $table->boolean('is_default')->default(false)->index();
            $table->timestamps();

            // Index supplÃ©mentaire combinÃ©
            $table->index(['level', 'is_default']);
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
