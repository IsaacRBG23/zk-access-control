<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'metrics' => [
                'users' => User::count(),
                'roles' => Role::count(),
                'permissions' => Permission::count(),
            ],
        ]);
    }
}