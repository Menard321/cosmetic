<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #ORD-{{ 1000 + $order->id }}</title>
    <style>
        body { font-family: 'Inter', sans-serif; padding: 40px; color: #333; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #735c00; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #735c00; text-transform: uppercase; }
        .details { margin: 30px 0; display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin: 30px 0; }
        th { background: #f9f9f9; text-align: left; padding: 12px; border-bottom: 1px solid #ddd; text-transform: uppercase; font-size: 10px; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .total { text-align: right; font-size: 20px; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #735c00; color: white; border: none; border-radius: 8px; cursor: pointer;">Print Invoice</button>
    </div>

    <div class="header">
        <div>
            <div class="logo">Angels Beauty Tanzania</div>
            <p>Quality Cosmetics & Radiance</p>
        </div>
        <div style="text-align: right;">
            <h1 style="margin: 0; font-size: 20px;">INVOICE</h1>
            <p>#ORD-{{ 1000 + $order->id }}</p>
        </div>
    </div>

    <div class="details">
        <div>
            <h4 style="margin: 0 0 10px 0; color: #735c00;">BILL TO:</h4>
            <strong>{{ $order->customer_name ?? ($order->user->name ?? 'Guest') }}</strong><br>
            Phone: {{ $order->phone }}<br>
            Address: {{ $order->delivery_address }}
        </div>
        <div style="text-align: right;">
            <h4 style="margin: 0 0 10px 0; color: #735c00;">DATE:</h4>
            {{ $order->created_at->format('M d, Y') }}<br>
            <strong>Payment: {{ strtoupper($order->payment_method) }}</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Unit Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td><strong>{{ $item->product->name }}</strong><br><small>{{ $item->product->brand }}</small></td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">{{ number_format($item->price) }} TZS</td>
                <td style="text-align: right;">{{ number_format($item->price * $item->quantity) }} TZS</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        TOTAL: {{ number_format($order->total_amount) }} TZS
    </div>

    <div class="footer">
        <p>Thank you for choosing Angels Beauty. For any inquiries, call +255 74746 1380</p>
        <p>This is a computer-generated invoice from Angels Beauty Tanzania ERP System.</p>
    </div>
</body>
</html>
