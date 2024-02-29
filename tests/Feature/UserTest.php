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
}
