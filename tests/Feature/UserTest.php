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
    public function test_can_get_a_list_of_users(): void
    {
        $user = User::factory()->create();

        $users = User::factory()->count(30)->create();

        $response = $this->actingAs($user)
                        ->get('/users');
        
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email'
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
                ]);
    }
}
