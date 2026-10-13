<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUsersSeeder extends Seeder
{
    /**
     * Akun demo untuk development/testing SAJA.
     * Jangan jalankan pada production.
     */
    public function run(): void
    {
        $users = [
            ['Superadmin', 'superadmin@example.com', UserRole::Superadmin],
            ['Admin Akademik', 'admin@example.com', UserRole::AdminAcademic],
            ['Dosen Demo', 'dosen@example.com', UserRole::Lecturer],
            ['Mahasiswa Demo', 'mahasiswa@example.com', UserRole::Student],
        ];

        foreach ($users as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => 'password',
                    'role' => $role,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
