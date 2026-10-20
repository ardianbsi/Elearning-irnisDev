<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Semester>
 */
class SemesterFactory extends Factory
{
    public function definition(): array
    {
        $term = fake()->randomElement(['ganjil', 'genap']);

        return [
            'academic_year_id' => AcademicYear::factory(),
            'term_code' => $term,
            'name' => 'Semester '.ucfirst($term),
            'starts_at' => $term === 'ganjil' ? '2025-08-01' : '2026-02-01',
            'ends_at' => $term === 'ganjil' ? '2026-01-31' : '2026-07-31',
            'is_active' => true,
        ];
    }
}
