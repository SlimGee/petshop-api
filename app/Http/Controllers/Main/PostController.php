<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function index(): JsonResource
    {
        $posts = Post::paginate(10);

        return PostResource::collection($posts);
    }

    public function show(Post $post): JsonResource
    {
        return new PostResource($post);
    }
}
