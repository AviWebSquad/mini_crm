<x-app-layout>
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-bold">Total Sales</h3>
            <p>${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-bold">Total Orders</h3>
            <p>{{ $totalOrders }}</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-bold">Low Stock</h3>
            <ul>
                @foreach($lowStock as $product)
                <li>{{ $product->name }} ({{ $product->quantity }})</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>