<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    <!-- Invoice -->
    <div class="px-4 my-4 mx-auto w-full sm:px-6 sm:my-10 lg:px-8">
        <!-- Grid -->
        <div class="flex justify-between items-center pb-5 mb-5 border-b border-gray-200 dark:border-neutral-700">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-neutral-200">Invoice </h2>
            </div>
            <!-- Col -->

            <!-- Col -->
        </div>
        <!-- End Grid -->

        <!-- Grid -->
        <div class="grid gap-3 md:grid-cols-2">
            <div>
                <div class="grid space-y-3">
                    <dl class="grid gap-x-3 text-sm sm:flex">
                        <dt class="text-gray-500 min-w-36 max-w-[200px] dark:text-neutral-500">
                            Billed to:
                        </dt>
                        <dd class="text-gray-800 dark:text-neutral-200">
                            <a class="inline-flex gap-x-1.5 items-center font-medium text-blue-600 dark:text-blue-500 hover:underline decoration-2"
                                href="#">
                                {{ $order->user->email }}
                            </a>
                        </dd>
                    </dl>

                    <dl class="grid gap-x-3 text-sm sm:flex">
                        <dt class="text-gray-500 min-w-36 max-w-[200px] dark:text-neutral-500">
                            Billing details:
                        </dt>
                        <dd class="font-medium text-gray-800 dark:text-neutral-200">
                            <span class="block font-semibold">{{ $order->user->name }}</span>
                            <address class="not-italic font-normal">
                                {{ $order->address['billing'] }}
                            </address>
                        </dd>
                    </dl>

                    <dl class="grid gap-x-3 text-sm sm:flex">
                        <dt class="text-gray-500 min-w-36 max-w-[200px] dark:text-neutral-500">
                            Shipping details:
                        </dt>
                        <dd class="font-medium text-gray-800 dark:text-neutral-200">
                            <span class="block font-semibold">Sara Williams</span>
                            <address class="not-italic font-normal">
                                {{ $order->address['shipping'] }}
                            </address>
                        </dd>
                    </dl>
                </div>
            </div>
            <!-- Col -->

            <div>
                <div class="grid space-y-3">
                    <dl class="grid gap-x-3 text-sm sm:flex">
                        <dt class="text-gray-500 min-w-36 max-w-[200px] dark:text-neutral-500">
                            Invoice number:
                        </dt>
                        <dd class="font-medium text-gray-800 dark:text-neutral-200">
                            {{ strtoupper($order->uuid) }}
                        </dd>
                    </dl>


                    <dl class="grid gap-x-3 text-sm sm:flex">
                        <dt class="text-gray-500 min-w-36 max-w-[200px] dark:text-neutral-500">
                            Date of creation:
                        </dt>
                        <dd class="font-medium text-gray-800 dark:text-neutral-200">
                            {{ $order->created_at->format('M d, Y') }}
                        </dd>
                    </dl>

                    <dl class="grid gap-x-3 text-sm sm:flex">
                        <dt class="text-gray-500 min-w-36 max-w-[200px] dark:text-neutral-500">
                            Payment details:
                        </dt>
                        <dd class="font-medium text-gray-800 dark:text-neutral-200">
                            <span class="block font-semibold">{{ $order->payment->type->value }}</span>
                            @foreach ($order->payment->details as $key => $value)
                                <span class="block">{{ $key }}: {{ $value }}</span>
                            @endforeach
                        </dd>
                    </dl>
                </div>
            </div>
            <!-- Col -->
        </div>
        <!-- End Grid -->

        <!-- Table -->
        <div class="p-4 mt-6 space-y-4 rounded-lg border border-gray-200 dark:border-neutral-700">
            <div class="hidden sm:grid sm:grid-cols-12">
                <div class="text-xs font-medium text-gray-500 uppercase sm:col-span-4 dark:text-neutral-500">UUID</div>
                <div class="text-xs font-medium text-gray-500 uppercase sm:col-span-5 dark:text-neutral-500">Item</div>
                <div class="text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">Qty</div>
                <div class="text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">Unit Price
                </div>
                <div class="text-xs font-medium text-gray-500 uppercase text-end dark:text-neutral-500">Total Price
                </div>
            </div>

            <div class="hidden border-b border-gray-200 sm:block dark:border-neutral-700"></div>
            @foreach ($order->products as $item)
                <div class="grid grid-cols-3 gap-2 sm:grid-cols-12">
                    <div class="col-span-full sm:col-span-4">
                        <h5 class="text-xs font-medium text-gray-500 uppercase sm:hidden dark:text-neutral-500">UUID
                        </h5>
                        <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $item['product']['uuid'] }}</p>
                    </div>

                    <div class="col-span-full sm:col-span-5">
                        <h5 class="text-xs font-medium text-gray-500 uppercase sm:hidden dark:text-neutral-500">Item
                        </h5>
                        <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $item['product']['title'] }}</p>
                    </div>
                    <div>
                        <h5 class="text-xs font-medium text-gray-500 uppercase sm:hidden dark:text-neutral-500">Qty</h5>
                        <p class="text-gray-800 dark:text-neutral-200">{{ $item['quantity'] }}</p>
                    </div>
                    <div>
                        <h5 class="text-xs font-medium text-gray-500 uppercase sm:hidden dark:text-neutral-500">Unit
                            Price
                        </h5>
                        <p class="text-gray-800 dark:text-neutral-200">${{ $item['product']['price'] }}</p>
                    </div>
                    <div>
                        <h5 class="text-xs font-medium text-gray-500 uppercase sm:hidden dark:text-neutral-500">Total
                            Price
                        </h5>
                        <p class="text-gray-800 sm:text-end dark:text-neutral-200">
                            ${{ $item['product']['price'] * $item['quantity'] }}</p>
                    </div>
                </div>
                <div class="border-b border-gray-200 sm:hidden dark:border-neutral-700"></div>
            @endforeach

        </div>
        <!-- End Table -->

        <!-- Flex -->
        <div class="flex mt-8 sm:justify-end">
            <div class="space-y-2 w-full max-w-2xl sm:text-end">
                <!-- Grid -->
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-1 sm:gap-2">
                    <dl class="grid gap-x-3 text-sm sm:grid-cols-5">
                        <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Subotal:</dt>
                        <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                            ${{ $order->amount }}
                        </dd>
                    </dl>

                    <dl class="grid gap-x-3 text-sm sm:grid-cols-5">
                        <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Delivery Fee:</dt>
                        <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                            ${{ $order->delivery_fee ?? 0 }}
                        </dd>
                    </dl>


                    <dl class="grid gap-x-3 text-sm sm:grid-cols-5">
                        <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Total:</dt>
                        <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                            ${{ $order->amount + ($order->delivery_fee ?? 0) }}
                        </dd>
                    </dl>
                </div>
                <!-- End Grid -->
            </div>
        </div>
        <!-- End Flex -->
    </div>
    <!-- End Invoice -->
</body>

</html>
