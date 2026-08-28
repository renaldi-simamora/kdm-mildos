<?php

namespace Tests\Feature;

use App\Models\FaceEnrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaceEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_face_enrollments(): void
    {
        $response = $this->get(route('face-enrollments.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_face_enrollments_list(): void
    {
        $user = User::factory()->create();

        FaceEnrollment::factory()->create([
            'department' => 'JRI PABRIK',
            'employee_name' => 'Rukman Fadli Nulhakim',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($user)->get(route('face-enrollments.index'));

        $response->assertOk();
        $response->assertSee('JRI PABRIK');
        $response->assertSee('Rukman Fadli Nulhakim');
        $response->assertSee('Pending');
    }

    public function test_user_can_search_face_enrollments(): void
    {
        $user = User::factory()->create();

        FaceEnrollment::factory()->create([
            'department' => 'JRI PABRIK',
            'employee_name' => 'Rukman Fadli Nulhakim',
            'status' => 'Pending',
        ]);

        FaceEnrollment::factory()->create([
            'department' => 'VALE',
            'employee_name' => 'Nova Silvana',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($user)->get(route('face-enrollments.index', ['search' => 'Nova']));

        $response->assertOk();
        $response->assertSee('Nova Silvana');
        $response->assertDontSee('Rukman Fadli Nulhakim');
    }

    public function test_user_can_update_face_enrollment_status(): void
    {
        $user = User::factory()->create();

        $enrollment = FaceEnrollment::factory()->create([
            'employee_name' => 'Rukman Fadli Nulhakim',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($user)->patch(route('face-enrollments.update-status', $enrollment), [
            'status' => 'Approved',
        ]);

        $response->assertRedirect(route('face-enrollments.index'));
        $this->assertDatabaseHas('face_enrollments', [
            'id' => $enrollment->id,
            'status' => 'Approved',
        ]);
    }
}
