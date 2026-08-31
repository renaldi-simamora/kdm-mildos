<?php

namespace Database\Factories;

use App\Models\ChangeShiftRequest;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChangeShiftRequest>
 */
class ChangeShiftRequestFactory extends Factory
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
            'delegate_employee_id' => fake()->optional(0.6)->passthrough(Employee::factory()),
            'shift_id' => null,
            'shift_to' => fake()->randomElement(['Morning', 'Afternoon', 'Night', 'Split']),
            'request_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'requested_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['In Review', 'Approved', 'Rejected']),
        ];
    }
}
