<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $transaction->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
        }

        .header-info {
            width: 100%;
        }

        .header-info td {
            padding: 0;
            border: none;
            color: #6b7280;
        }

        .header-info .left {
            text-align: left;
            width: 50%;
        }

        .header-info .right {
            text-align: right;
            width: 50%;
        }

        .meta-info {
            width: 100%;
            margin: 20px 0;
            font-size: 13px;
            color: #4b5563;
        }

        .meta-info td {
            padding: 0;
            border: none;
        }

        .meta-info .left {
            width: 50%;
            text-align: left;
        }

        .meta-info .right {
            width: 50%;
            text-align: right;
        }

        .meta-info p {
            margin: 5px 0;
        }

        .meta-info .label {
            font-weight: 600;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table thead {
            background-color: #f3f4f6;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #e5e7eb;
            padding: 10px;
        }

        .items-table th {
            font-weight: 600;
            text-align: left;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        .totals {
            width: 100%;
            margin-top: 20px;
        }

        .totals td {
            padding: 5px 0;
            border: none;
        }

        .totals .spacer {
            width: 60%;
        }

        .totals .amounts {
            width: 40%;
        }

        .totals-table {
            width: 100%;
        }

        .totals-table td {
            padding: 8px 0;
            border: none;
        }

        .totals-table .label {
            text-align: left;
            color: #374151;
        }

        .totals-table .amount {
            text-align: right;
            color: #374151;
        }

        .total-row {
            border-top: 2px solid #333 !important;
            font-weight: bold;
            font-size: 16px;
        }

        .total-row td {
            padding-top: 15px !important;
        }

        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            margin-top: 30px;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Receipt</h1>
            <table class="header-info">
                <tr>
                    <td class="left">Transaction #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="right">Order #{{ str_pad($transaction->order->order_id, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
            </table>
        </div>

        <!-- Meta Info -->
        <table class="meta-info">
            <tr>
                <td class="left">
                    <p><span class="label">Customer:</span> {{ $transaction->user?->name ?? 'Guest' }}</p>
                    <p><span class="label">Email:</span> {{ $transaction->user?->email ?? '' }}</p>
                    <p><span class="label">Phone:</span> {{ $transaction->user?->phone ?? 'N/A' }}</p>
                </td>
                <td class="right">
                    <p><span class="label">Date:</span> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                    <p><span class="label">Payment Type:</span>
                        {{ ucfirst($transaction->payment->provider == 'cod' ? 'Cash on Delivery' : $transaction->payment->provider) }}
                    </p>
                </td>
            </tr>
        </table>

        <!-- Order Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-right">Price</th>
                    <th class="text-center">Variant</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->order->items as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td class="text-right">{{ number_format($item->price, 2) }}
                            {{ strtoupper($transaction->currency) }}
                        </td>
                        <td class="text-center">{{ $item->variant->title }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">
                            € {{ number_format($item->price * $item->quantity, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="totals">
            <tr>
                <td class="spacer"></td>
                <td class="amounts">
                    <table class="totals-table">
                        <tr>
                            <td class="label">Subtotal</td>
                            <td class="amount"> € {{ number_format($transaction->order->subtotal, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Discount</td>
                            <td class="amount">- € {{ number_format($transaction->order->discount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Shipping</td>
                            <td class="amount">€ {{ number_format($transaction->order->shipping, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tax {{ $systemSetting->tax }} % (Included)</td>
                            <td class="amount"> € {{ number_format($transaction->order->tax, 2) }}
                            </td>
                        </tr>
                        <tr class="total-row">
                            <td class="label">Total</td>
                            <td class="amount"> € {{ number_format($transaction->order->total, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with {{$systemSetting->system_name ?? 'Humble Underdog'}}!</p>
            <p>If you have any questions, contact {{$systemSetting->email ?? 'official@humbleunderdogs.com'}}</p>
        </div>
    </div>
</body>

</html>