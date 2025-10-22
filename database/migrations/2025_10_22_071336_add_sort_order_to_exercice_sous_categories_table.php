<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exercice_sous_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('exercice_sous_categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_active');
                $table->index('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('exercice_sous_categories', function (Blueprint $table) {
            if (Schema::hasColumn('exercice_sous_categories', 'sort_order')) {
                $table->dropIndex(['sort_order']);
                $table->dropColumn('sort_order');
            }
        });
    }
};