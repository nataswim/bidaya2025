<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    public function run(): void
    {
        Post::insert([
            [
                'name' => 'Bienvenue sur notre blog',
                'slug' => 'bienvenue-sur-notre-blog',
                'intro' => 'DÃ©couvrez notre nouveau blog dÃ©diÃ© Ã la technologie et au dÃ©veloppement.',
                'content' => 'Ceci est le premier article de notre blog. Nous y partagerons nos connaissances et expÃ©riences.',
                'category_id' => 1,
                'category_name' => 'ActualitÃ©s',
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Introduction Ã Laravel 12',
                'slug' => 'introduction-laravel-12',
                'intro' => 'DÃ©couvrez les nouvelles fonctionnalitÃ©s de Laravel 12.',
                'content' => 'Laravel 12 apporte de nombreuses amÃ©liorations...',
                'category_id' => 2,
                'category_name' => 'Tutoriels',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}