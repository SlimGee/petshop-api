<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_all_brands(): void
    {
        Brand::factory(20)->create();

        $response = $this->getJson('/api/v1/brands');

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

        $response->assertStatus(200);
    }

    public function test_can_create_new_brands(): void
    {
        $count = Brand::count();

        $response = $this->authenticated()->postJson('/api/v1/brand/create', [
            'title' => $this->faker->word,
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

        $this->assertEquals($count + 1, Brand::count());
    }

    public function test_can_show_single_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->getJson("/api/v1/brand/{$brand->uuid}");

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

        $this->assertEquals($brand->title, $response['data']['title']);
    }

    public function test_can_update_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->authenticated()->patchJson("/api/v1/brand/{$brand->uuid}", [
            'title' => $this->faker->word,
        ]);

        $response->assertOk();

        $this->assertNotEquals($brand->title, $response['data']['title']);
    }

    public function test_can_delete_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->authenticated()->deleteJson("/api/v1/brand/{$brand->uuid}");

        $response->assertNoContent();

        $this->assertModelMissing($brand);
    }
}
