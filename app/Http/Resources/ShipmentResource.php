<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ShipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'category' => $this
                ->products
                ->map(function ($product) {
                    return Product::whereUuid($product['product'])->first()->category;
                })
                ->unique()
                ->pluck('title')
                ->join(', '),
            'customer' => new UserResource($this->user),
            'products' => $this->products,
            'address' => $this->address,
            'payment' => new PaymentResource($this->payment),
            'status' => new OrderStatusResource($this->status),
            'shipped_at' => $this->shipped_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
