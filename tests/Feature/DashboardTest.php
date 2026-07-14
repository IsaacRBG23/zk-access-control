<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
    }

    public function test_dashboard_displays_access_control_metrics(): void
    {
        $user = User::factory()->create();

        User::factory()->count(2)->create();

        Role::create([
            'name' => 'Supervisor',
        ]);

        Permission::create([
            'name' => 'reports.view',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();

        $response->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->where('metrics.users', 3)
            ->where('metrics.roles', 1)
            ->where('metrics.permissions', 1)
        );
    }
}