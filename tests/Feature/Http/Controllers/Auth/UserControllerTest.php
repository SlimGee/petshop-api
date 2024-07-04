<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use App\Services\Auth\Facades\JWT;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_get_currently_loggedin_user(): void
    {
        $user = User::factory()->create();

        $token = JWT::encode(['user_uuid' => $user->uuid]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/v1/user');

        $response->assertStatus(200);

        $this->assertArrayHasKey('uuid', $response->json('data'));
        $this->assertEquals($user->uuid, $response->json('data.uuid'));
    }

    public function test_can_delete_user_account(): void
    {
        $user = User::factory()->create();
        $token = JWT::encode(['user_uuid' => $user->uuid]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->deleteJson('/api/v1/user');

        $response->assertNoContent();

        $this->assertModelMissing($user);
    }

    public function test_can_update_user_details(): void
    {
        $user = User::factory()->create();

        $token = JWT::encode(['user_uuid' => $user->uuid]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson('/api/v1/user', [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->e164PhoneNumber,
        ]);

        $response->assertOk();

        $this->assertNotEquals($user->first_name, $user->fresh()->first_name);
    }

    public function test_can_list_user_orders(): void
    {
        $user = User::factory()->create();

        $this->artisan('db:seed OrderStatusSeeder');

        Order::factory(10)->create([
            'order_status_id' => OrderStatus::all()->random()->id,
            'user_id' => $user->id,
        ]);

        $response = $this->authenticatedAs($user)->get('/api/v1/user/orders');

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'order_status_id',
                    'amount',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $response->assertJsonFragment([
            'user_id' => $user->id,
        ]);
    }
}
