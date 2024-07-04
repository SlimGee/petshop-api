<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderController extends Controller
{
    public function index(): JsonResource
    {
        $orders = auth()->user()->orders()->paginate();

        return OrderResource::collection($orders);
    }
}
