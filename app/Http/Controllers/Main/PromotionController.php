<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionController extends Controller
{
    public function index(): JsonResource
    {
        $promotion = Promotion::paginate(10);

        return PromotionResource::collection($promotion);
    }
}
