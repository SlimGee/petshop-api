<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\OrderStatus;
use Tests\TestCase;

class OrderStatusControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_all_order_statuses(): void
    {
        $this->artisan('db:seed OrderStatusSeeder');

        $response = $this->getJson('/api/v1/order-statuses');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'uuid',
                ],
            ],
        ]);
    }

    public function test_can_create_new_order_status(): void
    {
        $data = OrderStatus::factory()->make()->toArray();
        $count = OrderStatus::count();

        $response = $this->authenticated()->postJson('/api/v1/order-statuses/create', $data);

        $response->assertCreated();

        $this->assertEquals($count + 1, OrderStatus::count());
    }

    public function test_show_single_order_status(): void
    {
        $status = OrderStatus::factory()->create();

        $response = $this->getJson("/api/v1/order-status/{$status->uuid}");

        $response->assertOk();

        $this->assertEquals($status->title, $response->json('data.title'));
    }

    public function test_can_update_order_status(): void
    {
        $status = OrderStatus::factory()->create();
        $data = OrderStatus::factory()->make()->toArray();

        $response = $this->authenticated()->patchJson("/api/v1/order-status/{$status->uuid}", $data);

        $response->assertOk();

        $this->assertEquals($data['title'], $response->json('data.title'));
        $this->assertNotEquals($status->title, $status->fresh()->title);
    }

    public function test_can_delete_order_status(): void
    {
        $status = OrderStatus::factory()->create();

        $response = $this->authenticated()->deleteJson("/api/v1/order-status/{$status->uuid}");

        $response->assertNoContent();

        $this->assertModelMissing($status);
    }
}
