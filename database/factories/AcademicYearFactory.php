<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->year();

        return [
            'code' => $start.'/'.($start + 1),
            'name' => 'Tahun Akademik '.$start.'/'.($start + 1),
            'starts_at' => ($start).'-08-01',
            'ends_at' => ($start + 1).'-07-31',
            'is_active' => true,
        ];
    }
}
