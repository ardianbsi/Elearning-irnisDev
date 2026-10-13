<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_lupa_password_dapat_diakses(): void
    {
        $this->get('/lupa-password')->assertOk()->assertSee('Lupa kata sandi');
    }

    public function test_link_reset_dikirim_untuk_email_terdaftar(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/lupa-password', ['email' => $user->email]);

        $response->assertSessionHas('status');
    }

    public function test_email_tidak_terdaftar_ditolak(): void
    {
        $response = $this->post('/lupa-password', ['email' => 'tidak-ada@example.com']);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_dapat_direset_dengan_token_valid(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');

        // Password baru bisa dipakai login.
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password-baru-123',
        ]);
        $this->assertAuthenticated();
    }
}
