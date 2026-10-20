<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_dialihkan_ke_login_saat_akses_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/dashboard/superadmin')->assertRedirect('/login');
        $this->get('/dashboard/admin')->assertRedirect('/login');
        $this->get('/dashboard/dosen')->assertRedirect('/login');
        $this->get('/dashboard/mahasiswa')->assertRedirect('/login');
    }

    public function test_setiap_role_hanya_bisa_akses_dashboardnya(): void
    {
        $matrix = [
            [UserRole::Superadmin, '/dashboard/superadmin', 200],
            [UserRole::Superadmin, '/dashboard/admin', 200],
            [UserRole::Superadmin, '/dashboard/dosen', 403],
            [UserRole::Superadmin, '/dashboard/mahasiswa', 403],
            [UserRole::AdminAcademic, '/dashboard/superadmin', 403],
            [UserRole::AdminAcademic, '/dashboard/admin', 200],
            [UserRole::AdminAcademic, '/dashboard/dosen', 403],
            [UserRole::AdminAcademic, '/dashboard/mahasiswa', 403],
            [UserRole::Lecturer, '/dashboard/superadmin', 403],
            [UserRole::Lecturer, '/dashboard/admin', 403],
            [UserRole::Lecturer, '/dashboard/dosen', 200],
            [UserRole::Lecturer, '/dashboard/mahasiswa', 403],
            [UserRole::Student, '/dashboard/superadmin', 403],
            [UserRole::Student, '/dashboard/admin', 403],
            [UserRole::Student, '/dashboard/dosen', 403],
            [UserRole::Student, '/dashboard/mahasiswa', 200],
        ];

        foreach ($matrix as [$role, $url, $expected]) {
            $user = User::factory()->role($role)->create();

            $this->actingAs($user)->get($url)->assertStatus($expected);
            auth()->logout();
        }
    }

    public function test_dashboard_umum_redirect_ke_dashboard_role(): void
    {
        $cases = [
            [UserRole::Superadmin, 'dashboard.superadmin'],
            [UserRole::AdminAcademic, 'dashboard.admin'],
            [UserRole::Lecturer, 'dashboard.lecturer'],
            [UserRole::Student, 'dashboard.student'],
        ];

        foreach ($cases as [$role, $route]) {
            $user = User::factory()->role($role)->create();

            $this->actingAs($user)->get('/dashboard')->assertRedirect(route($route));
        }
    }
}
