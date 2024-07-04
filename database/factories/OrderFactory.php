<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'products' => collect(range(1, 5))
                ->map(fn () => [
                    'product' => Product::factory()->create()->uuid,
                    'quantity' => $this->faker->numberBetween(1, 10),
                ])
                ->toArray(),
            'address' => [
                'billing' => $this->faker->address,
                'shipping' => $this->faker->address,
            ],
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'payment_id' => Payment::factory(),
            'user_id' => User::factory(),
            'order_status_id' => OrderStatus::all()->random()->id,
        ];
    }
}
