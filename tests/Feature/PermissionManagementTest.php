<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_permission_cannot_access_permissions_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('permissions.index'));

        $response->assertForbidden();
    }

    public function test_user_with_permission_can_access_permissions_index(): void
    {
        $user = $this->createUserWithPermissions(['permissions.view']);

        $response = $this->actingAs($user)->get(route('permissions.index'));

        $response->assertOk();
    }

    public function test_user_with_permission_can_create_permission(): void
    {
        $user = $this->createUserWithPermissions(['permissions.create']);

        $response = $this->actingAs($user)->post(route('permissions.store'), [
            'name' => 'reports.view',
        ]);

        $response->assertRedirect(route('permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'name' => 'reports.view',
        ]);
    }

    public function test_permission_assigned_to_role_cannot_be_deleted(): void
    {
        $user = $this->createUserWithPermissions(['permissions.delete']);

        $permission = Permission::create([
            'name' => 'users.view',
        ]);

        $role = Role::create([
            'name' => 'Supervisor',
        ]);

        $role->permissions()->attach($permission);

        $response = $this->actingAs($user)
            ->delete(route('permissions.destroy', $permission));

        $response->assertRedirect(route('permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => 'users.view',
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