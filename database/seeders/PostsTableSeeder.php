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
                'content' => 'Ceci est le premier article.',
                'category_id' => 1,
                'status' => 'published'
            ]
        ]);
    }
}
