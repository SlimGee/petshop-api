<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use App\Services\Auth\Facades\JWT;
use Tests\TestCase;

class LoggedinUserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_users_can_be_athenticated(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/v1/user/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertArrayHasKey('token', $response->json('data'));

        $response->assertStatus(200);
    }

    public function test_users_can_not_be_athenticated_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/user/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_users_can_be_logged_out(): void
    {
        $user = User::factory()->create();

        $token = JWT::encode(['user_uuid' => $user->uuid]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/v1/user/logout');

        $response->assertNoContent();

        $this->assertFalse(JWT::validate($token));

    }
}
