<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'vK9#mP2$nL5@xR8&pQ4*dZ7',
            'password_confirmation' => 'vK9#mP2$nL5@xR8&pQ4*dZ7',
        ];
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', $this->userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'role',
                    ],
                    'token',
                    'app_url',
                ],
                'status_code',
            ])
            ->assertJson([
                'status' => true,
                'message' => 'User registered successfully',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ]);
    }

    public function test_user_can_login()
    {
        $this->postJson('/api/register', $this->userData);

        $response = $this->postJson('/api/login', [
            'email' => 'john.doe@example.com',
            'password' => 'vK9#mP2$nL5@xR8&pQ4*dZ7',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'user',
                    'token',
                ],
                'status_code',
            ]);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }
}
