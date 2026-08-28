<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_employees(): void
    {
        $response = $this->get(route('employees.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_employee_list(): void
    {
        $user = User::factory()->create();

        Employee::factory()->create([
            'employee_code' => 'MLD0001',
            'name' => 'Deviana Puspita Sari',
            'job_title' => 'HRD',
            'department' => 'HRD',
        ]);

        $response = $this->actingAs($user)->get(route('employees.index'));

        $response->assertOk();
        $response->assertSee('MLD0001');
        $response->assertSee('Deviana Puspita Sari');
        $response->assertSee('HRD');
    }

    public function test_user_can_filter_employees_by_search_keyword(): void
    {
        $user = User::factory()->create();

        Employee::factory()->create([
            'employee_code' => 'MLD0001',
            'name' => 'Deviana Puspita Sari',
            'department' => 'HRD',
        ]);

        Employee::factory()->create([
            'employee_code' => 'MLD0002',
            'name' => 'Wahyu Aji Pamungkas',
            'department' => 'MILDOS RETAIL',
        ]);

        $response = $this->actingAs($user)->get(route('employees.index', ['search' => 'Wahyu']));

        $response->assertOk();
        $response->assertSee('Wahyu Aji Pamungkas');
        $response->assertDontSee('Deviana Puspita Sari');
    }

    public function test_user_can_filter_employees_by_department(): void
    {
        $user = User::factory()->create();

        Employee::factory()->create([
            'employee_code' => 'MLD0001',
            'name' => 'Deviana Puspita Sari',
            'department' => 'HRD',
        ]);

        Employee::factory()->create([
            'employee_code' => 'MLD0002',
            'name' => 'Wahyu Aji Pamungkas',
            'department' => 'MILDOS RETAIL',
        ]);

        $response = $this->actingAs($user)->get(route('employees.index', ['department' => 'HRD']));

        $response->assertOk();
        $response->assertSee('Deviana Puspita Sari');
        $response->assertDontSee('Wahyu Aji Pamungkas');
    }

    public function test_user_can_create_new_employee(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('employees.store'), [
            'employee_code' => 'MLD9999',
            'name' => 'New Test Employee',
            'email' => 'testemployee@mildos.test',
            'job_title' => 'Quality Assurance',
            'department' => 'TECH',
            'location' => 'Mildos Gading Serpong',
            'status' => 'Active',
        ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'employee_code' => 'MLD9999',
            'name' => 'New Test Employee',
            'email' => 'testemployee@mildos.test',
        ]);
    }
}
