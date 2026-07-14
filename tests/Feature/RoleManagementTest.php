<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_permission_cannot_access_roles_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('roles.index'));

        $response->assertForbidden();
    }

    public function test_user_with_permission_can_access_roles_index(): void
    {
        $user = $this->createUserWithPermissions(['roles.view']);

        $response = $this->actingAs($user)->get(route('roles.index'));

        $response->assertOk();
    }

    public function test_user_with_permission_can_create_role(): void
    {
        $admin = $this->createUserWithPermissions(['roles.create']);

        $permission = Permission::create([
            'name' => 'users.view',
        ]);

        $response = $this->actingAs($admin)->post(route('roles.store'), [
            'name' => 'Supervisor',
            'permissions' => [$permission->id],
        ]);

        $response->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'Supervisor',
        ]);

        $role = Role::where('name', 'Supervisor')->firstOrFail();

        $this->assertTrue(
            $role->permissions()->where('permissions.id', $permission->id)->exists()
        );
    }

    public function test_default_system_role_cannot_be_deleted(): void
    {
        $admin = $this->createUserWithPermissions(['roles.delete']);

        $role = Role::create([
            'name' => 'Administrator',
        ]);

        $response = $this->actingAs($admin)->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'Administrator',
        ]);
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