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
                'intro' => 'Découvrez notre nouveau blog dédié à la technologie et au développement.',
                'content' => 'Ceci est le premier article de notre blog. Nous y partagerons nos connaissances et expériences.',
                'category_id' => 1,
                'category_name' => 'Actualités',
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Introduction à Laravel 12',
                'slug' => 'introduction-laravel-12',
                'intro' => 'Découvrez les nouvelles fonctionnalités de Laravel 12.',
                'content' => 'Laravel 12 apporte de nombreuses améliorations...',
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