<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/sales')->assertRedirect('/login');
    }

    public function test_user_can_log_in_with_valid_credentials(): void
    {
        $user = User::factory()->create(['local' => 'Rabat']);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_signup_creates_a_user_and_logs_them_in(): void
    {
        $this->post('/postsignup', [
            'name' => 'Sara',
            'email' => 'sara@example.com',
            'password' => 'secret123',
            'local' => 'Marrakech',
        ])->assertRedirect('/dashboard');

        $user = User::where('email', 'sara@example.com')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame('secret123', $user->password);
    }
}
