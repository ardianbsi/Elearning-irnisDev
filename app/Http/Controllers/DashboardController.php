<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function superadmin(): View
    {
        return view('dashboard.superadmin');
    }

    public function admin(): View
    {
        return view('dashboard.admin');
    }

    public function lecturer(): View
    {
        return view('dashboard.lecturer');
    }

    public function student(): View
    {
        return view('dashboard.student');
    }

    /**
     * Redirect /dashboard ke dashboard sesuai role user login.
     */
    public function index(): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        $role = $user->role instanceof UserRole
            ? $user->role
            : UserRole::tryFrom((string) $user->role) ?? UserRole::Student;

        return redirect()->route($role->dashboardRoute());
    }
}
