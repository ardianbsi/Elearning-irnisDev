<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->role(UserRole::Student),
            'study_program_id' => StudyProgram::factory(),
            'nim' => fake()->unique()->numerify('##########'),
            'cohort' => (string) fake()->numberBetween(2021, 2026),
            'is_active' => true,
        ];
    }
}
