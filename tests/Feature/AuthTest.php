<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/graphql', [
            'query' => 'mutation {
                login(email: "test@example.com", password: "password") {
                    token
                    user {
                        id
                        email
                    }
                }
            }',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['login' => ['token', 'user' => ['id', 'email']]]]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/graphql', [
            'query' => 'mutation {
                logout {
                    message
                }
            }',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'logout' => [
                    'message' => 'Logged out',
                ],
            ],
        ]);
    }
}
