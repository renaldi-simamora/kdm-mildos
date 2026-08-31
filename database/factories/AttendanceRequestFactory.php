<?php

namespace Database\Factories;

use App\Models\AttendanceRequest;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttendanceRequest>
 */
class AttendanceRequestFactory extends Factory
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
            'request_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'clock_in' => fake()->time('H:i'),
            'clock_out' => fake()->optional()->time('H:i'),
            'requested_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['In Review', 'Approved', 'Rejected']),
        ];
    }
}
