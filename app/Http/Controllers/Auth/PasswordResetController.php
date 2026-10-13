<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Form lupa password.
     */
    public function request(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset (MAIL_MAILER=log secara default di dev).
     */
    public function sendEmail(Request $request): RedirectResponse
    {
        $request->validate(
            ['email' => ['required', 'email', 'max:255']],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
            ]
        );

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Tautan reset kata sandi telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Email tidak ditemukan.']);
    }

    /**
     * Form reset password via token.
     */
    public function reset(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Simpan password baru.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'token' => ['required'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'token.required' => 'Token reset tidak valid.',
                'email.required' => 'Email wajib diisi.',
                'password.required' => 'Kata sandi baru wajib diisi.',
                'password.min' => 'Kata sandi minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            ]
        );

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => $password, 'remember_token' => null]);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Kata sandi berhasil diubah. Silakan masuk.')
            : back()->withErrors(['email' => 'Token reset tidak valid atau kedaluwarsa.']);
    }
}
