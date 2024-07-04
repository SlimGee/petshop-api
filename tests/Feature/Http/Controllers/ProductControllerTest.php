<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_all_products(): void
    {
        Product::factory(20)->create();

        $response = $this->getJson('/api/v1/products');
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'uuid',
                    'category_uuid',
                    'metadata',
                ],
            ],
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_can_create_new_products(): void
    {
        $data = Product::factory()->make()->toArray();
        $count = Product::count();

        $response = $this->authenticated()->postJson('/api/v1/products/create', $data);

        $response->assertCreated();

        $this->assertEquals($count + 1, Product::count());
    }

    public function test_show_single_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/v1/product/{$product->uuid}");

        $response->assertOk();

        $this->assertEquals($product->title, $response->json('data.title'));
    }

    public function test_can_update_product(): void
    {
        $product = Product::factory()->create();
        $data = Product::factory()->make()->toArray();

        $response = $this->authenticated()->putJson("/api/v1/product/{$product->uuid}", $data);

        $response->assertOk();

        $this->assertEquals($data['title'], $response->json('data.title'));
        $this->assertNotEquals($product->title, $response->json('data.title'));
    }

    public function test_can_delete_product(): void
    {
        $product = Product::factory()->create();
        $response = $this->authenticated()->deleteJson("/api/v1/product/{$product->uuid}");
        $response->assertNoContent();
        $this->assertSoftDeleted($product);
    }
}
