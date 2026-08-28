<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────
    // Guest scenarios
    // ─────────────────────────────────────────────

    #[Test]
    public function guest_visiting_root_sees_landing_page(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        // Landing page contains Login link to /login
        $response->assertSee(route('login'));
    }

    #[Test]
    public function guest_visiting_dashboard_is_redirected_to_login(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function guest_visiting_login_sees_login_page(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    // ─────────────────────────────────────────────
    // Login scenarios
    // ─────────────────────────────────────────────

    #[Test]
    public function valid_credentials_redirect_to_dashboard(): void
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function invalid_credentials_stay_on_login_with_error(): void
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post(route('login'), [
            'username' => 'testuser',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect(); // stays on /login
        $response->assertSessionHasErrors(['username']);
        $this->assertGuest();
    }

    #[Test]
    public function missing_credentials_show_validation_errors(): void
    {
        $response = $this->post(route('login'), []);

        $response->assertSessionHasErrors(['username', 'password']);
        $this->assertGuest();
    }

    // ─────────────────────────────────────────────
    // Authenticated scenarios
    // ─────────────────────────────────────────────

    #[Test]
    public function authenticated_user_visiting_root_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function authenticated_user_visiting_login_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create();

        // Breeze wraps /login in 'guest' middleware which redirects auth users to /dashboard
        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
    }

    // ─────────────────────────────────────────────
    // Logout scenarios
    // ─────────────────────────────────────────────

    #[Test]
    public function logout_invalidates_session_and_redirects_to_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    #[Test]
    public function after_logout_user_cannot_access_dashboard(): void
    {
        $user = User::factory()->create();

        // Login, then logout
        $this->actingAs($user)->post(route('logout'));

        // Now try to access dashboard as guest
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }
}
