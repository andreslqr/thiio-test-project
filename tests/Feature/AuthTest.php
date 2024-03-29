<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Concerns\InteractsWithJWTAuthentication;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use InteractsWithJWTAuthentication;

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
            'password' => $this->faker()->password(minLength: 8),
        ]);

        $response->assertStatus(401)
                ->assertJsonStructure([
                    'message'
                ]);
    }

    public function test_a_logged_user_can_refresh_access_token(): void
    {
        $user = User::factory()->create([
            'email' => $this->faker()->email(),
            'password' => $this->faker()->password(minLength: 8)
        ]);

        $response = $this->actingAs($user)
                        ->postJson('/auth/refresh');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'access_token',
                    'token_type',
                    'expires_in'
                ]);
    }

    public function test_a_guest_can_not_refresh_access_token(): void
    {
        $response = $this->postJson('/auth/refresh');

        $response->assertStatus(401)
                ->assertJsonStructure([
                    'message'
                ]);
    }


    public function test_a_user_can_logout(): void
    {
        $user = User::factory()->create([
            'email' => $this->faker()->email(),
            'password' => $this->faker()->password(minLength: 8)
        ]);

        $response = $this->actingAs($user)
                        ->postJson('/auth/logout');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message'
                ]);

        $this->postJson('/auth/logout')
            ->assertStatus(401);
    }

  
    public function test_a_guest_can_registered(): void
    {
        $name = $this->faker()->name();
        $email = $this->faker()->email();
        $password = $this->faker()->password(minLength: 8) . '5a#A';

        $response = $this->postJson('/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'name',
                        'email',
                        'id'
                    ]
                ])
                ->assertJsonMissing([
                    'data' => [
                        'password'
                    ]
                ]);


        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }

    public function test_a_guest_can_not_registered_twice()
    {
        $name = $this->faker()->name();
        $email = $this->faker()->email();
        $password = $this->faker()->password(minLength: 8) . '5a#A';

        $response = $this->postJson('/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(201);

        $response = $this->postJson('/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrorFor('email');
    }
}
