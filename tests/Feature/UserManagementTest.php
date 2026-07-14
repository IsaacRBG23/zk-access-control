<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_permission_cannot_access_users_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_user_with_permission_can_access_users_index(): void
    {
        $user = $this->createUserWithPermissions(['users.view']);

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertOk();
    }

    public function test_user_with_permission_can_create_user(): void
    {
        $admin = $this->createUserWithPermissions(['users.create']);

        $role = Role::create([
            'name' => 'User',
        ]);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Created User',
            'email' => 'created@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'User',
            'roles' => [$role->id],
        ]);

        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Created User',
            'email' => 'created@example.com',
            'role' => 'User',
        ]);

        $createdUser = User::where('email', 'created@example.com')->firstOrFail();

        $this->assertTrue($createdUser->roles()->where('roles.id', $role->id)->exists());
    }

    private function createUserWithPermissions(array $permissions): User
    {
        $role = Role::create([
            'name' => 'Test Role',
        ]);

        foreach ($permissions as $permissionName) {
            $permission = Permission::create([
                'name' => $permissionName,
            ]);

            $role->permissions()->attach($permission);
        }

        $user = User::factory()->create([
            'role' => $role->name,
        ]);

        $user->roles()->attach($role);

        return $user;
    }
}