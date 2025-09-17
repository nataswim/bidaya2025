<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    public function run(): void
    {
        Tag::insert([
            ['name' => 'Laravel', 'slug' => 'laravel', 'status' => 'active'],
            ['name' => 'PHP', 'slug' => 'php', 'status' => 'active'],
        ]);
    }
}
