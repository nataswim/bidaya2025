<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Actualités', 
                'slug' => 'actualites', 
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tutoriels', 
                'slug' => 'tutoriels', 
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}