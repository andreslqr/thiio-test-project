<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_a_user_can_get_login_token(): void
    {
        $password = $this->faker()->password(minLength: 8);

        $user = User::factory()->create([
            'password' => $password
        ]);

        $response = $this->postJson('/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'access_token',
                    'token_type',
                    'expires_in'
                ]);

    }

    public function test_a_missing_field_fails_login_validation(): void
    {
        $response = $this->postJson('/auth/login', [
            'password' => $this->faker()->password(),
        ]);

        $response->assertStatus(422)
                ->assertInvalid([
                    'email',
                ]);
    }

    public function test_when_password_is_invalid_an_error_is_returned(): void
    {
        $user = User::factory()->create([
            'password' => 'admin123'
        ]);

        $response = $this->postJson('/auth/login', [
            'email' => $user->email,
            'password' => $this->faker()->password(),
        ]);

        $response->assertStatus(401)
                ->assertJsonStructure([
                    'message'
                ]);
    }
}
