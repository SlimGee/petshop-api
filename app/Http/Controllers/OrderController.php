<?php

namespace App\Http\Controllers;

use App\Enums\PaymentType;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $orders = Order::paginate();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): JsonResource
    {
        $payment = Payment::find($request->validated('payment_id'));

        $status = $payment->type == PaymentType::CASH_ON_DELIVERY
            ? OrderStatus::where('title', 'pending payment')->first()
            : OrderStatus::where('title', 'paid')->first();

        $order = auth()
            ->user()
            ->orders()
            ->create([
                ...$request->validated(),
                'order_status_id' => $status->id,
                'amount' => $request
                    ->safe()
                    ->collect('products')
                    ->map(fn($payload) => Product::where('uuid', $payload['product'])->first()->price * $payload['quantity'])
                    ->sum(),
            ]);

        return OrderResource::make($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResource
    {
        return OrderResource::make($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResource
    {
        $order->update($request->validated());

        return OrderResource::make($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): Response
    {
        $order->delete();

        return response()->noContent();
    }
}
