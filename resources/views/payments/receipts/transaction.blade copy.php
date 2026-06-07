<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $transaction->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans">
    <div class="max-w-3xl mx-auto bg-white rounded-lg p-8 mt-5">
        <!-- Header -->
        <div class="text-center border-b pb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Receipt</h1>
            <div class="flex justify-between">
                <p class="text-gray-500 inline">Transaction #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="text-gray-500 inline">Order
                    #{{ str_pad($transaction->order->order_id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>

        </div>

        <!-- Meta Info -->
        <div class="grid grid-cols-2 gap-4 my-6 text-sm text-gray-600">
            <div>
                <p><span class="font-semibold">Date:</span> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                {{-- <p><span class="font-semibold">Status:</span> {{ ucfirst($transaction->status) }}</p> --}}
            </div>
            <div class="text-right">
                <p><span class="font-semibold">Customer:</span> {{ $transaction->user?->name ?? 'Guest' }}</p>
                <p><span class="font-semibold">Payment Type:</span> {{ ucfirst($transaction->payment->provider) }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-200 p-2 text-left">Product</th>
                    <th class="border border-gray-200 p-2 text-right">Price</th>
                    <th class="border border-gray-200 p-2 text-right">Variant</th>
                    <th class="border border-gray-200 p-2 text-center">Qty</th>
                    <th class="border border-gray-200 p-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->order->items as $item)
                    <tr>
                        <td class="border border-gray-200 p-2">{{ $item->title }}</td>
                        <td class="border border-gray-200 p-2 text-right">{{ number_format($item->price, 2) }}
                            {{ strtoupper($transaction->currency) }}
                        </td>
                        <td class="border border-gray-200 p-2 text-center">{{ $item->variant->title }}</td>
                        <td class="border border-gray-200 p-2 text-center">{{ $item->quantity }}</td>
                        <td class="border border-gray-200 p-2 text-right">
                            {{ number_format($item->price * $item->quantity, 2) }} {{ strtoupper($transaction->currency) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="mt-6">
            <div class="flex justify-between text-gray-700">
                <span>Subtotal</span>
                <span>{{ number_format($transaction->order->subtotal, 2) }}
                    {{ strtoupper($transaction->currency) }}</span>
            </div>
            <div class="flex justify-between text-gray-700">
                <span>Discount</span>
                <span>-{{ number_format($transaction->order->discount, 2) }}
                    {{ strtoupper($transaction->currency) }}</span>
            </div>
            <div class="flex justify-between text-gray-700">
                <span>Shipping</span>
                <span>{{ number_format($transaction->order->shipping, 2) }}
                    {{ strtoupper($transaction->currency) }}</span>
            </div>
            <div class="flex justify-between text-gray-700">
                <span>Tax</span>
                <span>{{ number_format($transaction->order->tax, 2) }} {{ strtoupper($transaction->currency) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold mt-3 border-t pt-2">
                <span>Total</span>
                <span>{{ number_format($transaction->order->total, 2) }} {{ strtoupper($transaction->currency) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-500 text-xs mt-8">
            <p>Thank you for shopping with {{$systemSetting->system_name ?? 'Humble Underdog'}}!</p>
            <p>If you have any questions, contact {{$systemSetting->email ?? 'official@humbleunderdogs.com'}}</p>
        </div>
    </div>
</body>

</html>