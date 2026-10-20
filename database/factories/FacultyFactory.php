<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faculty>
 */
class FacultyFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Fakultas Teknik', 'Fakultas Ekonomi', 'Fakultas Hukum',
            'Fakultas Kedokteran', 'Fakultas Ilmu Komputer', 'Fakultas Pertanian',
        ]);

        return [
            'code' => strtoupper(fake()->unique()->lexify('F??')),
            'name' => $name,
            'is_active' => true,
        ];
    }
}
