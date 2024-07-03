<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderStatusResource;
use App\Models\OrderStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $statuses = OrderStatus::paginate();

        return OrderStatusResource::collection($statuses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderStatusRequest $request): JsonResource
    {
        $status = OrderStatus::create($request->validated());

        return OrderStatusResource::make($status);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderStatus $orderStatus): JsonResource
    {
        return OrderStatusResource::make($orderStatus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderStatusRequest $request, OrderStatus $orderStatus): JsonResource
    {
        $orderStatus->update($request->validated());

        return OrderStatusResource::make($orderStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus): Response
    {
        $orderStatus->delete();

        return response()->noContent();
    }
}
