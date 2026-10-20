<?php

namespace App\Policies;

use App\Models\User;

class AcademicPolicy
{
    /**
     * Hanya admin (superadmin/admin akademik) yang boleh CRUD master data.
     * Superadmin lolos otomatis via Gate::before.
     */
    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewAny(User $user): bool
    {
        return $this->manage($user);
    }

    public function view(User $user): bool
    {
        return $this->manage($user);
    }

    public function create(User $user): bool
    {
        return $this->manage($user);
    }

    public function update(User $user): bool
    {
        return $this->manage($user);
    }

    public function toggleActive(User $user): bool
    {
        return $this->manage($user);
    }
}
