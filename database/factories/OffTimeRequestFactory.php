<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\OffTimeRequest;
use App\Models\OffTimeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OffTimeRequest>
 */
class OffTimeRequestFactory extends Factory
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
            'off_time_type_id' => OffTimeType::factory(),
            'department' => fake()->randomElement(['Engineering', 'Marketing', 'HR', 'Finance', 'Operations']),
            'start_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'end_date' => fake()->optional()->dateTimeBetween('now', '+1 month'),
            'requested_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['In Review', 'Approved', 'Rejected']),
        ];
    }
}
