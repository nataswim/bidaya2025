<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ordre qui respecte les dependances (FK)
        $this->call([
            WorkoutIntermediaireSeeder::class,
            WorkoutAvanceSeeder::class,
            //WorkoutBatchSeeder::class,
            // RolesTableSeeder::class,
            // PermissionsTableSeeder::class,
            // RolePermissionTableSeeder::class,

            // UsersTableSeeder::class,

            // AJOUTER cette ligne :
            //SpatiePermissionSeeder::class,

            // CategoriesTableSeeder::class,
            // TagsTableSeeder::class,
            // PostsTableSeeder::class,
            // TaggablesTableSeeder::class,
        ]);
    }
}