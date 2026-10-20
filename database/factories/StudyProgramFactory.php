<?php

namespace Database\Factories;

use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudyProgram>
 */
class StudyProgramFactory extends Factory
{
    public function definition(): array
    {
        return [
            'faculty_id' => Faculty::factory(),
            'code' => strtoupper(fake()->unique()->bothify('PS-####')),
            'name' => fake()->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Ilmu Hukum', 'Agroteknologi']),
            'degree' => fake()->randomElement(['D3', 'D4', 'S1', 'S2']),
            'is_active' => true,
        ];
    }
}
