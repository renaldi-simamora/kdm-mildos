<?php

namespace Database\Factories;

use App\Models\OffTimeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OffTimeType>
 */
class OffTimeTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Annual Leave', 'Sick Leave', 'Personal Leave', 'Maternity Leave', 'Paternity Leave']),
            'max_off_times' => fake()->numberBetween(3, 30),
            'interval_type' => fake()->randomElement(['Monthly', 'Yearly']),
            'superadmin_approval' => fake()->boolean(),
            'status' => fake()->randomElement(['Active', 'Inactive']),
        ];
    }
}
