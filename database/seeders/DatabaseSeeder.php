<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ordre qui respecte les dépendances (FK)
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolePermissionTableSeeder::class,

            UsersTableSeeder::class,

            CategoriesTableSeeder::class,
            TagsTableSeeder::class,
            PostsTableSeeder::class,
            TaggablesTableSeeder::class,
        ]);
    }
}
