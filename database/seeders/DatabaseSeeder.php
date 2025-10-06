<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ordre qui respecte les dependances (FK)
        $this->call([
             WorkoutMultiFormeSeeder::class,   
             //WorkoutVitesseSeeder::class,        // Workouts V-001 à V-025 (Catégorie 7)
            //WorkoutAeroBaseSeeder::class,       // Workouts AB-001 à AB-025 (Catégorie 8)
            //WorkoutSeuilSeeder::class,          // Workouts S-001 à S-025 (Catégorie 9)
            //WorkoutBaseSeeder::class,           // Workouts B-001 à B-025 (Catégorie 10)
            //WorkoutIntermediaireSeeder::class,
            //WorkoutAvanceSeeder::class,
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