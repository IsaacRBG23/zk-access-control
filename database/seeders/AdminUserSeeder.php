<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default administrator user.
     */
    public function run(): void
    {
        $administratorRole = Role::query()
            ->where('name', 'Administrator')
            ->firstOrFail();

        $administrator = User::firstOrCreate(
            ['email' => 'admin@zk-access-control.test'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('Password123!'),
                'role' => 'Administrator',
                'email_verified_at' => now(),
            ]
        );

        $administrator->roles()->syncWithoutDetaching([
            $administratorRole->id,
        ]);
    }
}