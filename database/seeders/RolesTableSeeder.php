<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'Admin', 'slug' => 'admin', 'display_name' => 'Administrateur', 'level' => 1, 'is_default' => false],
            ['name' => 'Editor', 'slug' => 'editor', 'display_name' => 'Éditeur', 'level' => 2, 'is_default' => false],
            ['name' => 'User', 'slug' => 'user', 'display_name' => 'Utilisateur', 'level' => 3, 'is_default' => true],
        ]);
    }
}
