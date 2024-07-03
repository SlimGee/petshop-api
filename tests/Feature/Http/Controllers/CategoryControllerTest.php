<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_get_all_categories(): void
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'uuid',
                    'title',
                    'slug',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_can_create_new_category(): void
    {
        $response = $this->authenticated()->postJson('/api/v1/categories/create', [
            'title' => $this->faker->sentence,
        ]);

        $response->assertCreated();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'title',
                'slug',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_can_show_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/v1/categories/{$category->uuid}");

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'title',
                'slug',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->authenticated()->putJson("/api/v1/categories/{$category->uuid}", [
            'title' => $this->faker->sentence,
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'title',
                'slug',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertNotEquals($category->title, $response['data']['title']);
    }

    public function test_can_delete_category(): void
    {
        $category = Category::factory()->create();
        $response = $this->authenticated()->deleteJson("/api/v1/categories/{$category->uuid}");

        $response->assertNoContent();

        $this->assertModelMissing($category);
    }
}
