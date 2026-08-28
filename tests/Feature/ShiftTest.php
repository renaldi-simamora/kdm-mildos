<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed a department-bearing employee so the departments dropdown works
        Employee::factory()->create(['department' => 'MILDOS RETAIL', 'status' => 'Active']);
    }

    #[Test]
    public function guest_is_redirected_to_login_when_accessing_shifts(): void
    {
        $response = $this->get(route('shifts.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function authenticated_user_can_view_shifts_index(): void
    {
        $user = User::factory()->create();
        Shift::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('shifts.index'));

        $response->assertOk();
        $response->assertSee('Shift Management');
        $response->assertSee('Create Shift');
    }

    #[Test]
    public function shifts_list_can_be_searched_by_name(): void
    {
        $user = User::factory()->create();
        Shift::factory()->create(['name' => 'Office Senin Jumat', 'department' => 'MILDOS RETAIL']);
        Shift::factory()->create(['name' => 'Shift Malam', 'department' => 'MILDOS RETAIL']);

        $response = $this->actingAs($user)->get(route('shifts.index', ['search' => 'Senin']));

        $response->assertOk();
        $response->assertSee('Office Senin Jumat');
        $response->assertDontSee('Shift Malam');
    }

    #[Test]
    public function authenticated_user_can_store_a_shift(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shifts.store'), [
            'department' => 'MILDOS RETAIL',
            'name' => 'Shift Test',
            'start_time' => '09:00',
            'end_time' => '18:00',
            'early_tolerance_minutes' => 30,
            'late_tolerance_minutes' => 15,
            'status' => 'Active',
        ]);

        $response->assertRedirect(route('shifts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('shifts', [
            'department' => 'MILDOS RETAIL',
            'name' => 'Shift Test',
            'status' => 'Active',
        ]);
    }

    #[Test]
    public function store_shift_fails_validation_with_missing_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shifts.store'), []);

        $response->assertSessionHasErrors(['department', 'name', 'start_time', 'end_time']);
    }

    #[Test]
    public function store_shift_fails_with_negative_tolerance(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shifts.store'), [
            'department' => 'MILDOS RETAIL',
            'name' => 'Bad Shift',
            'start_time' => '09:00',
            'end_time' => '18:00',
            'early_tolerance_minutes' => -5,
            'late_tolerance_minutes' => -10,
            'status' => 'Active',
        ]);

        $response->assertSessionHasErrors(['early_tolerance_minutes', 'late_tolerance_minutes']);
    }

    #[Test]
    public function authenticated_user_can_update_a_shift(): void
    {
        $user = User::factory()->create();
        $shift = Shift::factory()->create([
            'department' => 'MILDOS RETAIL',
            'name' => 'Old Name',
            'start_time' => '09:00:00',
            'end_time' => '18:00:00',
            'early_tolerance_minutes' => 30,
            'late_tolerance_minutes' => 15,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->put(route('shifts.update', $shift), [
            'department' => 'GYMZONE',
            'name' => 'Updated Name',
            'start_time' => '10:00',
            'end_time' => '20:00',
            'early_tolerance_minutes' => 60,
            'late_tolerance_minutes' => 30,
            'status' => 'Inactive',
        ]);

        $response->assertRedirect(route('shifts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('shifts', [
            'id' => $shift->id,
            'department' => 'GYMZONE',
            'name' => 'Updated Name',
            'status' => 'Inactive',
        ]);
    }

    #[Test]
    public function authenticated_user_can_delete_a_shift(): void
    {
        $user = User::factory()->create();
        $shift = Shift::factory()->create(['department' => 'MILDOS RETAIL']);

        $response = $this->actingAs($user)->delete(route('shifts.destroy', $shift));

        $response->assertRedirect(route('shifts.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('shifts', ['id' => $shift->id]);
    }

    #[Test]
    public function authenticated_user_can_toggle_shift_status(): void
    {
        $user = User::factory()->create();
        $shift = Shift::factory()->active()->create(['department' => 'MILDOS RETAIL']);

        $this->actingAs($user)->patch(route('shifts.update-status', $shift));

        $this->assertDatabaseHas('shifts', ['id' => $shift->id, 'status' => 'Inactive']);

        // Toggle back
        $this->actingAs($user)->patch(route('shifts.update-status', $shift));

        $this->assertDatabaseHas('shifts', ['id' => $shift->id, 'status' => 'Active']);
    }

    #[Test]
    public function root_route_redirects_authenticated_user_to_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function root_route_shows_landing_page_for_guests(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
    }
}
