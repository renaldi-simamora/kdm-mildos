<?php

namespace Database\Factories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department' => $this->faker->randomElement([
                'MILDOS RETAIL', 'GYMZONE', 'VALE', 'JRI PABRIK', 'NUUM PARFUM',
                'MILDOS DISTRI', 'HRD', 'FINANCE',
            ]),
            'name' => $this->faker->words(3, true),
            'start_time' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '12:00:00']),
            'end_time' => $this->faker->randomElement(['17:00:00', '18:00:00', '20:00:00', '22:00:00']),
            'early_tolerance_minutes' => $this->faker->randomElement([0, 15, 30, 60, 120, 200]),
            'late_tolerance_minutes' => $this->faker->randomElement([0, 15, 30]),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
        ];
    }

    public function active(): static
    {
        return $this->state(['status' => 'Active']);
    }

    public function inactive(): static
    {
        return $this->state(['status' => 'Inactive']);
    }
}
