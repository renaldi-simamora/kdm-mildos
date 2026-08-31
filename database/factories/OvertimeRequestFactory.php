<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\OvertimeRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OvertimeRequest>
 */
class OvertimeRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'request_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'overtime_time' => fake()->time('H:i'),
            'total_hours' => fake()->randomFloat(1, 1, 8),
            'requested_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['In Review', 'Approved', 'Rejected']),
        ];
    }
}
