<?php

namespace Tests\Feature\Http\Controllers\Main;

use App\Models\Post;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_posts(): void
    {
        Post::factory(20)->create();

        $response = $this->getJson('/api/v1/main/blog');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'uuid',
                    'slug',
                    'content',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_can_show_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/v1/main/blog/{$post->uuid}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'uuid',
                'slug',
                'content',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
