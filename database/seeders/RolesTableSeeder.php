<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'Admin', 
                'slug' => 'admin', 
                'display_name' => 'Administrateur', 
                'level' => 1, 
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Editor', 
                'slug' => 'editor', 
                'display_name' => 'Ã©diteur', 
                'level' => 2, 
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'User', 
                'slug' => 'user', 
                'display_name' => 'Utilisateur', 
                'level' => 3, 
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}