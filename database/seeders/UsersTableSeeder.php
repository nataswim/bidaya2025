<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
    'name' => 'Super Admin', // ✅ AjoutÃ©
    'username' => 'admin',
    'first_name' => 'Super',
    'last_name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role_id' => 1,
    'status' => 'active'
]);

    }
}
