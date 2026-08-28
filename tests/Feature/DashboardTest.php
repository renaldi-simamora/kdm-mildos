<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function authenticated_user_can_view_dashboard_with_all_metrics_including_blacklisted(): void
    {
        $user = User::factory()->create();

        // Create sample employees
        Employee::factory()->create(['status' => 'Active']);
        Employee::factory()->create(['status' => 'Resigned']);
        Employee::factory()->create(['status' => 'Blacklisted', 'name' => 'Ahmad Blacklisted']);
        Employee::factory()->create(['status' => 'Part Time']);
        Employee::factory()->create(['status' => 'Internship']);

        // Create sample attendance
        Attendance::factory()->create([
            'date' => now()->format('Y-m-d'),
            'status' => 'on_time',
        ]);

        // Create sample activity
        Activity::create([
            'employee_name' => 'Ahmad Blacklisted',
            'type' => 'blacklisted',
            'description' => 'Diblacklist - Pelanggaran Kontrak Kerja',
            'occurred_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Blacklisted Employees');
        $response->assertSee('Total Blacklisted');
        $response->assertSee('Ringkasan Kehadiran');
        $response->assertSee('Tren Kehadiran');
        $response->assertSee('Aktivitas Terbaru');
        $response->assertSee('Ahmad Blacklisted');
        $response->assertSee('Diblacklist - Pelanggaran Kontrak Kerja');
    }

    #[Test]
    public function dashboard_filters_attendance_by_inclusive_date_range(): void
    {
        $user = User::factory()->create();

        // Attendance on 2026-05-20
        Attendance::factory()->create(['date' => '2026-05-20', 'status' => 'on_time']);
        // Attendance on 2026-05-22
        Attendance::factory()->create(['date' => '2026-05-22', 'status' => 'late']);
        // Attendance on 2026-05-30 (outside range)
        Attendance::factory()->create(['date' => '2026-05-30', 'status' => 'absent']);

        $response = $this->actingAs($user)->get(route('dashboard', [
            'dates' => '2026-05-20 to 2026-05-25',
        ]));

        $response->assertOk();
        $response->assertSee('2026-05-20 to 2026-05-25');
        $response->assertViewHas('onTimeCount', 1);
        $response->assertViewHas('lateCount', 1);
        $response->assertViewHas('absentCount', 0);
        $response->assertViewHas('totalAttendance', 2);
    }

    #[Test]
    public function dashboard_calculates_single_date_attendance_metrics_accurately(): void
    {
        $user = User::factory()->create();

        Attendance::factory()->create(['date' => '2026-08-28', 'status' => 'on_time']);
        Attendance::factory()->create(['date' => '2026-08-28', 'status' => 'on_time']);
        Attendance::factory()->create(['date' => '2026-08-28', 'status' => 'absent']);

        $response = $this->actingAs($user)->get(route('dashboard', [
            'dates' => '2026-08-28',
        ]));

        $response->assertOk();
        $response->assertViewHas('onTimeCount', 2);
        $response->assertViewHas('absentCount', 1);
        $response->assertViewHas('totalAttendance', 3);
        $response->assertViewHas('onTimePercent', 66.7);
        $response->assertViewHas('absentPercent', 33.3);
    }

    #[Test]
    public function dashboard_provides_trend_and_employee_overview_arrays(): void
    {
        $user = User::factory()->create();

        Employee::factory()->create(['status' => 'Active', 'created_at' => now()->subMonths(2)]);
        Employee::factory()->create(['status' => 'Resigned', 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(1)]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('overviewMonths', function ($months) {
            return is_array($months) && count($months) === 6;
        });
        $response->assertViewHas('overviewActive', function ($active) {
            return is_array($active) && count($active) === 6;
        });
        $response->assertViewHas('overviewNew', function ($new) {
            return is_array($new) && count($new) === 6;
        });
        $response->assertViewHas('overviewResigned', function ($resigned) {
            return is_array($resigned) && count($resigned) === 6;
        });
        $response->assertViewHas('trendDays', function ($days) {
            return is_array($days) && count($days) >= 1;
        });
    }
}
