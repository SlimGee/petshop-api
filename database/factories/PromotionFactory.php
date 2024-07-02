<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->sentence,
            'metadata' => [
                'valid_from' => $this->faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d H:i:s'),
                'valid_to' => $this->faker->dateTimeBetween('+1 week', '+2 week')->format('Y-m-d H:i:s'),
                'image' => $this->faker->uuid,
            ],
        ];
    }
}
