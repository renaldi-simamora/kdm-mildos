<?php

namespace Database\Factories;

use App\Models\FaceEnrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FaceEnrollment>
 */
class FaceEnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department' => fake()->randomElement(['JRI PABRIK', 'VALE', 'MILDOS RETAIL', 'INTERNSHIP', 'MILDOS DISTRI']),
            'employee_name' => fake()->name(),
            'status' => fake()->randomElement(['Pending', 'Approved']),
            'notes' => fake()->sentence(),
        ];
    }
}
