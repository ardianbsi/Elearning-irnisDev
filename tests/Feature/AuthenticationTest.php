<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_login_dapat_diakses_guest(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Masuk');
    }

    public function test_user_dapat_login_dan_diarahkan_ke_dashboard_sesuai_role(): void
    {
        $cases = [
            [UserRole::Superadmin, 'dashboard.superadmin'],
            [UserRole::AdminAcademic, 'dashboard.admin'],
            [UserRole::Lecturer, 'dashboard.lecturer'],
            [UserRole::Student, 'dashboard.student'],
        ];

        foreach ($cases as [$role, $route]) {
            $user = User::factory()->role($role)->create();

            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

            $response->assertRedirect(route($route));
            $this->assertAuthenticatedAs($user);
            $this->post('/logout');
        }
    }

    public function test_login_gagal_dengan_kredensial_salah(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'salah-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_akun_nonaktif_ditolak_login(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_dapat_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
