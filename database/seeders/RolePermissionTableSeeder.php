<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::where('slug', 'admin')->first();
        $permissions = Permission::all()->pluck('id');

        $admin->permissions()->sync($permissions);
    }
}
