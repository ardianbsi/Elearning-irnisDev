<?php

namespace App\Policies;

use App\Models\Faculty;
use App\Models\User;

class FacultyPolicy extends AcademicPolicy
{
    public function delete(User $user, Faculty $faculty): bool
    {
        // Jangan hapus fakultas yang masih punya prodi; gunakan nonaktif.
        return $this->manage($user) && $faculty->studyPrograms()->count() === 0;
    }
}
