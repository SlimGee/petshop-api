<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_all_orders(): void
    {
        $this->artisan('db:seed OrderStatusSeeder');

        Order::factory(20)->create([
            'order_status_id' => OrderStatus::all()->random()->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->authenticated()->get('/api/v1/orders');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_can_show_order(): void
    {
        $this->artisan('db:seed OrderStatusSeeder');

        $order = Order::factory()->create([
            'order_status_id' => OrderStatus::all()->random()->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->authenticated()->get("/api/v1/orders/{$order->uuid}");
        $response->assertStatus(200);
        $this->assertEquals($order->uuid, $response->json('data.uuid'));
    }

    public function test_can_create_new_order(): void
    {
        $this->artisan('db:seed OrderStatusSeeder');
        $order = Order::factory()->make([
            'order_status_id' => OrderStatus::all()->random()->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $count = Order::count();

        $response = $this
            ->authenticated()
            ->post('/api/v1/orders/create', $order->toArray());
        $response->assertStatus(201);

        $this->assertEquals($order->products, $response->json('data.products'));
        $this->assertEquals($count + 1, Order::count());
    }

    public function test_can_update_order(): void
    {
        $this->artisan('db:seed OrderStatusSeeder');
        $statuses = OrderStatus::all();

        $order = Order::factory()->create([
            'order_status_id' => $statuses->random()->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $statuses->filter(fn($status) => $status->id !== $order->order_status_id);

        $response = $this
            ->authenticated()
            ->put("/api/v1/orders/{$order->uuid}", [
                ...$order->toArray(),
                'order_status_id' => $statuses->random()->id,
            ]);

        $response->assertStatus(200);

        $this->assertEquals($order->uuid, $response->json('data.uuid'));
        $this->assertNotEquals($order->order_status_id, $response->json('data.order_status_id'));
    }

    public function test_can_delete_order(): void
    {
        $this->artisan('db:seed OrderStatusSeeder');

        $order = Order::factory()->create([
            'order_status_id' => OrderStatus::all()->random()->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->authenticated()->delete("/api/v1/orders/{$order->uuid}");
        $response->assertStatus(204);

        $this->assertModelMissing($order);
    }
}
