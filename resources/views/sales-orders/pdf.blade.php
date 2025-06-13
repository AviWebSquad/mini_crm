<!DOCTYPE html>
<html>
<head>
    <title>Order #{{ $salesOrder->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tfoot { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Sales Order #{{ $salesOrder->id }}</h1>
    <p><strong>Date:</strong> {{ $salesOrder->created_at->format('Y-m-d') }}</p>
    <p><strong>Salesperson:</strong> {{ $salesOrder->user->name }}</p>
    <p><strong>Order Status:</strong> {{ $salesOrder->status }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesOrder->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->product->sku }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;">Grand Total:</td>
                <td>${{ number_format($salesOrder->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>