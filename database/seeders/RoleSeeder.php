<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's roles and assign default permissions.
     */
    public function run(): void
    {
        $administrator = Role::firstOrCreate([
            'name' => 'Administrator',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'Manager',
        ]);

        Role::firstOrCreate([
            'name' => 'User',
        ]);

        $administrator->permissions()->sync(
            Permission::query()->pluck('id')->all()
        );

        $managerPermissions = Permission::query()
            ->whereIn('name', [
                'users.view',
                'users.create',
                'users.update',
                'roles.view',
                'permissions.view',
            ])
            ->pluck('id')
            ->all();

        $manager->permissions()->sync($managerPermissions);
    }
}