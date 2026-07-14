<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PermissionMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_permission_protected_route(): void
    {
        Route::middleware(['web', 'auth', 'permission:users.view'])
            ->get('/test-permission-route', fn () => response('OK'));

        $response = $this->get('/test-permission-route');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_without_permission_gets_forbidden_response(): void
    {
        Route::middleware(['web', 'auth', 'permission:users.view'])
            ->get('/test-permission-route', fn () => response('OK'));

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/test-permission-route');

        $response->assertForbidden();
    }

    public function test_authenticated_user_with_permission_can_access_protected_route(): void
    {
        Route::middleware(['web', 'auth', 'permission:users.view'])
            ->get('/test-permission-route', fn () => response('OK'));

        $permission = Permission::create([
            'name' => 'users.view',
        ]);

        $role = Role::create([
            'name' => 'Administrator',
        ]);

        $role->permissions()->attach($permission);

        $user = User::factory()->create([
            'role' => 'Administrator',
        ]);

        $user->roles()->attach($role);

        $response = $this->actingAs($user)->get('/test-permission-route');

        $response->assertOk();
        $response->assertSee('OK');
    }
}