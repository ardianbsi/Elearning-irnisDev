<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('R-###')),
            'name' => 'Ruang '.fake()->unique()->bothify('Gedung ? Lantai #'),
            'capacity' => fake()->randomElement([20, 30, 40, 60]),
            'location' => 'Kampus Utama',
            'is_active' => true,
        ];
    }
}
