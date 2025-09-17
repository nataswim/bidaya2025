<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Actualités', 'slug' => 'actualites', 'status' => 'active'],
            ['name' => 'Tutoriels', 'slug' => 'tutoriels', 'status' => 'active'],
        ]);
    }
}
