<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Concerns\InteractsWithJWTAuthentication;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    Use InteractsWithJWTAuthentication;

    /**
     * A basic feature test example.
     */
    public function test_can_retrieve_users(): void
    {
        $user = User::factory()->create();

        User::factory()->count(30)->create();

        $response = $this->actingAs($user)
                        ->getJson('/v1/users');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'name',
                            'email'
                        ]
                    ],
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next'
                    ],
                    'meta' => [
                        'current_page',
                        'from',
                        'last_page',
                        'path',
                        'per_page',
                        'to',
                        'total'
                    ]
                ])
                ->assertJsonCount(15, 'data');
    }

    public function test_can_retrieve_users_by_filtering()
    {
        $user = User::factory()->create();

        User::factory()->count(30)->create();
        User::factory()->count(2)->create([
            'name' => 'wwwwwwwwww'
        ]);

        $this->actingAs($user)
            ->getJson('/v1/users?search=wwwwwwwwww')
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');

        $this->actingAs($user)
            ->getJson('/v1/users?per_page=30')
            ->assertJsonCount(30, 'data');
    }

    public function test_can_create_a_user(): void
    {
        $user = User::factory()->create();
        
        $name = $this->faker()->name();
        $email = $this->faker()->email();
        $password = $this->faker()->password(minLength: 8) . '5a#A';

        $response = $this->actingAs($user)
            ->postJson('/v1/users', [
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

    public function test_a_user_can_not_be_created_twice()
    {
        $user = User::factory()->create();

        $name = $this->faker()->name();
        $email = $this->faker()->email();
        $password = $this->faker()->password(minLength: 8) . '5a#A';

        $response = $this->actingAs($user)
            ->postJson('/v1/users', [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password
            ]);

        $response->assertStatus(201);

        $response = $this->actingAs($user)
            ->postJson('/v1/users', [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password
            ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrorFor('email');
    }

    public function test_can_retrieve_single_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->getJson("/v1/users/{$user->getKey()}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]);
    }

    public function test_can_not_retrieve_non_existent_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->getJson("/v1/users/2");

        $response->assertStatus(404);
    }

    public function test_a_user_can_be_deleted()
    {
        $user = User::factory()->create();

        $userForDelete = User::factory()->create();
        
        $response = $this->actingAs($user)
                        ->deleteJson("/v1/users/{$userForDelete->getKey()}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing($userForDelete, $userForDelete->toArray());
    }

    public function test_a_user_can_not_be_deleted_twice()
    {
        $user = User::factory()->create();

        $userForDelete = User::factory()->create();

        $response = $this->actingAs($user)
                        ->deleteJson("/v1/users/{$userForDelete->getKey()}");

        $response = $this->actingAs($user)
                        ->deleteJson("/v1/users/{$userForDelete->getKey()}");

        $response->assertStatus(404);
    }

    public function test_a_user_can_not_delete_itself()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->deleteJson("/v1/users/{$user->getKey()}");

        $response->assertStatus(403);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $userForUpdate = User::factory()->create();

        $name = $this->faker()->name();

        $response = $this->actingAs($user)
                        ->putJson("/v1/users/{$userForUpdate->getKey()}", [
                            'name' => $name,
                            'email' => $this->faker()->email()
                        ]);
                

        $response->assertStatus(200)
                        ->assertJsonStructure([
                            'data' => [
                                'name',
                                'email'
                            ]
                        ])
                        ->assertJsonPath('data.name', $name);

        $this->assertDatabaseHas($user, [
            'id' => $userForUpdate->getKey(),
            'name' => $name
        ]);
    }
}
