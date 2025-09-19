<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class SpatiePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Synchroniser avec Spatie
        $roles = Role::all();
        foreach ($roles as $role) {
            $spatieRole = \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => $role->name,
                'guard_name' => 'web'
            ]);
        }

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $spatiePermission = \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permission->name,
                'guard_name' => 'web'
            ]);
        }

        // Assigner rôles aux utilisateurs
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->assignRole('Admin');
        }
    }
}