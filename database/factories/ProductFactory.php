<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'category_uuid' => Category::factory()->create()->uuid,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'description' => $this->faker->paragraph,
            'metadata' => [
                'brand' => Brand::factory()->create()->uuid,
                'image' => $this->faker->uuid(),
            ],
        ];
    }
}
