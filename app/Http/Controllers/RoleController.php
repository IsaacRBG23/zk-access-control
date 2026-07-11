<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index(): Response
    {
        $roles = Role::query()
            ->withCount(['users', 'permissions'])
            ->orderBy('name')
            ->paginate(10)
            ->through(fn (Role $role) => [
                'id' => $role->id,
                'name' => $role->name,
                'users_count' => $role->users_count,
                'permissions_count' => $role->permissions_count,
                'created_at' => $role->created_at?->format('Y-m-d H:i:s'),
            ]);

        return Inertia::render('roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): Response
    {
        return Inertia::render('roles/Create', [
            'permissions' => $this->permissionOptions(),
        ]);
    }

    /**
     * Store a newly created role.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $permissionIds = $validated['permissions'] ?? [];

        unset($validated['permissions']);

        $role = Role::create($validated);

        $role->permissions()->sync($permissionIds);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): Response
    {
        $role->load('permissions:id,name');

        return Inertia::render('roles/Edit', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('id')->values(),
            ],
            'permissions' => $this->permissionOptions(),
        ]);
    }

    /**
     * Update the specified role.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $validated = $request->validated();

        $permissionIds = $validated['permissions'] ?? [];

        unset($validated['permissions']);

        $role->update($validated);

        $role->permissions()->sync($permissionIds);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        abort_unless(
            request()->user()?->hasPermission('roles.delete'),
            403,
            'You do not have permission to delete roles.'
        );

        if (in_array($role->name, ['Administrator', 'Manager', 'User'], true)) {
            return redirect()
                ->route('roles.index')
                ->with('error', 'Default system roles cannot be deleted.');
        }

        if ($role->users()->exists()) {
            return redirect()
                ->route('roles.index')
                ->with('error', 'Roles assigned to users cannot be deleted.');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Get available permission options.
     *
     * @return array<int, array{id: int, name: string}>
     */
    private function permissionOptions(): array
    {
        return Permission::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Permission $permission) => [
                'id' => $permission->id,
                'name' => $permission->name,
            ])
            ->all();
    }
}   