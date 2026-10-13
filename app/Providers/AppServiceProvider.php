<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Superadmin bypass semua Gate (kecuali Gate yang didefinisikan after).
        Gate::before(function (User $user) {
            if ($user->hasRole(UserRole::Superadmin)) {
                return true;
            }

            return null;
        });

        Gate::define('access-admin-area', fn (User $user) => $user->isAdmin());
        Gate::define('manage-academic', fn (User $user) => $user->isAdmin());
        Gate::define('teach-class', fn (User $user) => $user->hasRole(UserRole::Lecturer));
        Gate::define('study-class', fn (User $user) => $user->hasRole(UserRole::Student));
    }
}
