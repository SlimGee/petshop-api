<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

use function Spatie\LaravelPdf\Support\pdf;

class DownloadInvoiceController extends Controller
{
    public function __invoke(Order $order)
    {
        $order->products = $order->products->map(function ($product) {
            return [
                'product' => Product::whereUuid($product['product'])->first(),
                'quantity' => $product['quantity'],
            ];
        });

        return pdf()
            ->view('pdf.invoice', ['order' => $order])
            ->withBrowsershot(function ($browsershot) {
                $browsershot->noSandbox();
                $browsershot->scale(0.7);
            })
            ->name($order->uuid . '.pdf')
            ->download();
    }
}
