<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $manager = Role::create(['name' => 'Manager']);
        $agent = Role::create(['name' => 'Agent']);
        $clint = Role::create(['name' => 'Member']);
        $superAdmin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
        ]);
        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
        ]);
        $manager->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
        ]);
        $agent->givePermissionTo([
            'create-member',
            'edit-member',
            'delete-member',
        ]);

    }
}