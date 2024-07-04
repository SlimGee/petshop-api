<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShipmentResource;
use App\Models\OrderStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ShipmentLocatorController extends Controller
{
    public function index(): JsonResource
    {
        $shipedStatus = OrderStatus::where('title', 'shipped')->firstOrFail();

        $builder = QueryBuilder::for($shipedStatus->orders())
            ->defaultSort('-created_at')
            ->allowedFilters([
                AllowedFilter::exact('user_id'),  // Add this line
                'uuid',
                AllowedFilter::scope('placed_between'),
            ]);

        if (!array_key_exists('placed_between', request()->query('filter', []))) {
            $builder->placedBetween(now()->subDays(30), now());
        }

        $orders = $builder->paginate();

        return ShipmentResource::collection($orders);
    }
}
