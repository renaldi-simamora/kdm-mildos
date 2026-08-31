<?php

namespace Tests\Feature;

use App\Models\AttendanceRequest;
use App\Models\ChangeShiftRequest;
use App\Models\OffTimeRequest;
use App\Models\OvertimeRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormRequestsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    // ─── Off Time Requests ─────────────────────────────────────────────────────

    public function test_off_time_requests_index_returns_200(): void
    {
        $this->actingAs($this->user)
            ->get(route('off-time-requests.index'))
            ->assertOk()
            ->assertViewIs('form-requests.off-time-requests.index');
    }

    public function test_off_time_requests_index_with_filters_returns_200(): void
    {
        $this->actingAs($this->user)
            ->get(route('off-time-requests.index', ['status' => 'Approved', 'search' => 'test']))
            ->assertOk();
    }

    public function test_off_time_request_status_update_writes_to_db(): void
    {
        $offTimeRequest = OffTimeRequest::factory()->create(['status' => 'In Review']);

        $this->actingAs($this->user)
            ->patch(route('off-time-requests.update-status', $offTimeRequest), ['status' => 'Approved'])
            ->assertRedirect();

        $this->assertDatabaseHas('off_time_requests', [
            'id' => $offTimeRequest->id,
            'status' => 'Approved',
        ]);
    }

    public function test_off_time_request_destroy_removes_record(): void
    {
        $offTimeRequest = OffTimeRequest::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('off-time-requests.destroy', $offTimeRequest))
            ->assertRedirect();

        $this->assertDatabaseMissing('off_time_requests', ['id' => $offTimeRequest->id]);
    }

    // ─── Attendance Requests ──────────────────────────────────────────────────

    public function test_attendance_requests_index_returns_200(): void
    {
        $this->actingAs($this->user)
            ->get(route('attendance-requests.index'))
            ->assertOk()
            ->assertViewIs('form-requests.attendance-requests.index');
    }

    public function test_attendance_requests_index_with_filters_returns_200(): void
    {
        $this->actingAs($this->user)
            ->get(route('attendance-requests.index', ['status' => 'Rejected', 'search' => 'john']))
            ->assertOk();
    }

    public function test_attendance_request_status_update_writes_to_db(): void
    {
        $attendanceRequest = AttendanceRequest::factory()->create(['status' => 'In Review']);

        $this->actingAs($this->user)
            ->patch(route('attendance-requests.update-status', $attendanceRequest), ['status' => 'Approved'])
            ->assertRedirect();

        $this->assertDatabaseHas('attendance_requests', [
            'id' => $attendanceRequest->id,
            'status' => 'Approved',
        ]);
    }

    public function test_attendance_request_destroy_removes_record(): void
    {
        $attendanceRequest = AttendanceRequest::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('attendance-requests.destroy', $attendanceRequest))
            ->assertRedirect();

        $this->assertDatabaseMissing('attendance_requests', ['id' => $attendanceRequest->id]);
    }

    // ─── Change Shift Requests ────────────────────────────────────────────────

    public function test_change_shift_requests_index_returns_200(): void
    {
        $this->actingAs($this->user)
            ->get(route('change-shift-requests.index'))
            ->assertOk()
            ->assertViewIs('form-requests.change-shift-requests.index');
    }

    public function test_change_shift_request_status_update_writes_to_db(): void
    {
        $changeShiftRequest = ChangeShiftRequest::factory()->create(['status' => 'In Review']);

        $this->actingAs($this->user)
            ->patch(route('change-shift-requests.update-status', $changeShiftRequest), ['status' => 'Approved'])
            ->assertRedirect();

        $this->assertDatabaseHas('change_shift_requests', [
            'id' => $changeShiftRequest->id,
            'status' => 'Approved',
        ]);
    }

    public function test_change_shift_request_destroy_removes_record(): void
    {
        $changeShiftRequest = ChangeShiftRequest::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('change-shift-requests.destroy', $changeShiftRequest))
            ->assertRedirect();

        $this->assertDatabaseMissing('change_shift_requests', ['id' => $changeShiftRequest->id]);
    }

    // ─── Overtime Requests ────────────────────────────────────────────────────

    public function test_overtime_requests_index_returns_200(): void
    {
        $this->actingAs($this->user)
            ->get(route('overtime-requests.index'))
            ->assertOk()
            ->assertViewIs('form-requests.overtime-requests.index');
    }

    public function test_overtime_requests_index_with_filters_returns_200(): void
    {
        $this->actingAs($this->user)
            ->get(route('overtime-requests.index', ['status' => 'In Review']))
            ->assertOk();
    }

    public function test_overtime_request_status_update_writes_to_db(): void
    {
        $overtimeRequest = OvertimeRequest::factory()->create(['status' => 'In Review']);

        $this->actingAs($this->user)
            ->patch(route('overtime-requests.update-status', $overtimeRequest), ['status' => 'Approved'])
            ->assertRedirect();

        $this->assertDatabaseHas('overtime_requests', [
            'id' => $overtimeRequest->id,
            'status' => 'Approved',
        ]);
    }

    public function test_overtime_request_destroy_removes_record(): void
    {
        $overtimeRequest = OvertimeRequest::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('overtime-requests.destroy', $overtimeRequest))
            ->assertRedirect();

        $this->assertDatabaseMissing('overtime_requests', ['id' => $overtimeRequest->id]);
    }

    // ─── Unauthenticated Redirects ────────────────────────────────────────────

    public function test_unauthenticated_user_redirected_from_off_time_requests(): void
    {
        $this->get(route('off-time-requests.index'))->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_redirected_from_attendance_requests(): void
    {
        $this->get(route('attendance-requests.index'))->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_redirected_from_change_shift_requests(): void
    {
        $this->get(route('change-shift-requests.index'))->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_redirected_from_overtime_requests(): void
    {
        $this->get(route('overtime-requests.index'))->assertRedirect(route('login'));
    }
}
