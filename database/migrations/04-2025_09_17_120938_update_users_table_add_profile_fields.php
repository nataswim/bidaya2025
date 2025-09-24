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
        Schema::table('users', function (Blueprint $table) {
            // Profil utilisateur
            $table->string('username', 60)->nullable()->unique()->after('id');
            $table->string('first_name', 100)->nullable()->after('username');
            $table->string('last_name', 100)->nullable()->after('first_name');

            // Relation avec roles
            $table->foreignId('role_id')
                  ->nullable()
                  ->after('remember_token')
                  ->constrained('roles')
                  ->nullOnDelete();

            // Informations supplÃ©mentaires
            $table->string('avatar', 255)->nullable()->after('role_id');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('phone', 20)->nullable()->after('bio');
            $table->date('date_of_birth')->nullable()->after('phone');

            // Statut et connexion
            $table->string('status', 50)->default('active')->after('date_of_birth');
            $table->timestamp('last_login_at')->nullable()->after('status');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            $table->unsignedInteger('login_count')->default(0)->after('last_login_ip');

            // PrÃ©fÃ©rences
            $table->json('preferences')->nullable()->after('login_count');
            $table->string('locale', 5)->default('fr')->after('preferences');
            $table->string('timezone', 50)->default('Europe/Paris')->after('locale');

            // Soft delete
            $table->softDeletes();

            // Index
            $table->index('status');
            $table->index(['status', 'deleted_at']);
            $table->index('last_login_at');
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Suppression des colonnes ajoutÃ©es
            $table->dropColumn([
                'username',
                'first_name',
                'last_name',
                'role_id',
                'avatar',
                'bio',
                'phone',
                'date_of_birth',
                'status',
                'last_login_at',
                'last_login_ip',
                'login_count',
                'preferences',
                'locale',
                'timezone',
                'deleted_at'
            ]);
        });
    }
};
