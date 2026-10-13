<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pastikan user login memiliki salah satu role yang diizinkan.
 * Dipakai sebagai: ->middleware('role:superadmin,admin_academic')
 */
class EnsureRole
{
    /**
     * @param  string  ...$roles  Nilai enum UserRole yang diizinkan.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $allowed = array_map(fn (string $role) => UserRole::tryFrom($role), $roles);
        $allowed = array_filter($allowed);

        if (! $user->is_active || ! in_array($user->role, $allowed, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
