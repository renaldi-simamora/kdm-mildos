<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\OffTime;
use App\Models\OffTimeType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HrmModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_off_time_types(): void
    {
        $user = User::factory()->create();
        $type = OffTimeType::create([
            'name' => 'Cuti Tahunan',
            'max_off_times' => 6,
            'interval_type' => 'Yearly',
            'superadmin_approval' => true,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->get(route('off-time-types.index'));

        $response->assertOk();
        $response->assertSee('Cuti Tahunan');
        $response->assertSee('Yearly');
        $response->assertSee('Active');
    }

    public function test_authenticated_user_can_create_off_time_type(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('off-time-types.store'), [
            'name' => 'Cuti Melahirkan',
            'max_off_times' => 90,
            'interval_type' => 'Yearly',
            'superadmin_approval' => 1,
            'status' => 'Active',
        ]);

        $response->assertRedirect(route('off-time-types.index'));
        $this->assertDatabaseHas('off_time_types', ['name' => 'Cuti Melahirkan']);
    }

    public function test_authenticated_user_can_view_off_times_and_create_page(): void
    {
        $user = User::factory()->create();
        $emp = Employee::factory()->create(['name' => 'Budi Pratama']);
        $type = OffTimeType::create([
            'name' => 'Sakit',
            'max_off_times' => 1,
            'interval_type' => 'Monthly',
            'superadmin_approval' => true,
            'status' => 'Active',
        ]);

        OffTime::create([
            'employee_id' => $emp->id,
            'off_time_type_id' => $type->id,
            'recurrence_type' => 'None',
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-02',
            'reason' => 'Demam flu',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($user)->get(route('off-times.index'));
        $response->assertOk();
        $response->assertSee('Budi Pratama');
        $response->assertSee('Sakit');
        $response->assertSee('Pending');

        $createResponse = $this->actingAs($user)->get(route('off-times.create'));
        $createResponse->assertOk();
        $createResponse->assertSee('Budi Pratama');
    }

    public function test_authenticated_user_can_store_off_time(): void
    {
        $user = User::factory()->create();
        $emp = Employee::factory()->create(['name' => 'Siti Nurhaliza', 'location' => 'Mildos Pamulang']);
        $type = OffTimeType::create([
            'name' => 'Izin',
            'max_off_times' => 1,
            'interval_type' => 'Monthly',
            'superadmin_approval' => true,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->post(route('off-times.store'), [
            'employee_id' => $emp->id,
            'off_time_category_id' => $type->id,
            'location' => 'Mildos Pamulang',
            'recurrence_type' => 'None',
            'start_date' => '2026-09-05',
            'end_date' => '2026-09-05',
            'reason' => 'Urusan keluarga',
            'status' => 'Pending',
        ]);

        $response->assertRedirect(route('off-times.index'));
        $this->assertDatabaseHas('off_times', [
            'employee_id' => $emp->id,
            'reason' => 'Urusan keluarga',
        ]);
    }

    public function test_authenticated_user_can_view_attendances_and_reports(): void
    {
        $user = User::factory()->create();
        $emp = Employee::factory()->create(['name' => 'Heni Hermiyati', 'department' => 'MILDOS RETAIL']);

        Attendance::create([
            'employee_id' => $emp->id,
            'employee_name' => 'Heni Hermiyati',
            'location' => 'Mildos Pamulang',
            'shift' => 'Retail : Siang',
            'date' => '2026-08-31',
            'status' => 'Present',
            'clock_in' => '2026-08-31 13:07:16',
            'overtime_hours' => 2,
        ]);

        // Attendance index
        $indexResponse = $this->actingAs($user)->get(route('attendances.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Heni Hermiyati');
        $indexResponse->assertSee('Mildos Pamulang');
        $indexResponse->assertSee('Retail : Siang');

        // Reports
        $reportsResponse = $this->actingAs($user)->get(route('attendances.reports'));
        $reportsResponse->assertOk();
        $reportsResponse->assertSee('Heni Hermiyati');
        $reportsResponse->assertSee('MILDOS RETAIL');
    }
}
