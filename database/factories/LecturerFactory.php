<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lecturer>
 */
class LecturerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->role(UserRole::Lecturer),
            'faculty_id' => Faculty::factory(),
            'nip' => fake()->unique()->numerify('##################'),
            'position' => fake()->randomElement(['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar']),
            'is_active' => true,
        ];
    }
}
