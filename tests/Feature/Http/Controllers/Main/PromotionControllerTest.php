<?php

namespace Tests\Feature\Http\Controllers\Main;

use App\Models\Promotion;
use Tests\TestCase;

class PromotionControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_all_promotions(): void
    {
        Promotion::factory(10)->create();

        $response = $this->getJson(route('promotions.index'));

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'metadata',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $response->assertStatus(200);
    }
}
