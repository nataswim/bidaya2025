<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;

class TaggablesTableSeeder extends Seeder
{
    public function run(): void
    {
        $post = Post::first();
        $tag = Tag::first();

        if ($post && $tag) {
            $post->tags()->attach($tag->id);
        }
    }
}
