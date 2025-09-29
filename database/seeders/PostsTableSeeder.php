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
                'intro' => 'Decouvrez notre nouveau blog dedie A la technologie et au developpement.',
                'content' => 'Ceci est le premier article de notre blog. Nous y partagerons nos connaissances et experiences.',
                'category_id' => 1,
                'category_name' => 'Actualites',
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Introduction A Laravel 12',
                'slug' => 'introduction-laravel-12',
                'intro' => 'Decouvrez les nouvelles fonctionnalites de Laravel 12.',
                'content' => 'Laravel 12 apporte de nombreuses ameliorations...',
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