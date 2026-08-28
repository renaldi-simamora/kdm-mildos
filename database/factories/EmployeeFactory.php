<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $number = 1;

        return [
            'employee_code' => 'MLD'.str_pad((string) $number++, 4, '0', STR_PAD_LEFT),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'job_title' => fake()->jobTitle(),
            'department' => fake()->randomElement(['HRD', 'VALE', 'JRI PABRIK', 'MILDOS RETAIL', 'INTERNSHIP', 'MILDOS DISTRI']),
            'location' => 'Mildos Gading Serpong',
            'status' => fake()->randomElement(['Active', 'Active', 'Active', 'Resigned', 'Part Time', 'Internship']),
        ];
    }
}
