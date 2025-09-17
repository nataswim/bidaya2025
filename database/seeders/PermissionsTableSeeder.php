<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Permission::insert([
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'group' => 'users'],
            ['name' => 'Manage Posts', 'slug' => 'manage-posts', 'group' => 'posts'],
            ['name' => 'Manage Categories', 'slug' => 'manage-categories', 'group' => 'categories'],
        ]);
    }
}
