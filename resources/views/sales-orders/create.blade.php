<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Sales Order
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('sales-orders.store') }}">
                        @csrf
                        <div id="items-container">
                            <div class="item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Product</label>
                                    <select name="items[0][product_id]" required class="border rounded w-full py-2 px-3">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} (Stock: {{ $product->quantity }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                                    <input type="number" name="items[0][quantity]" min="1" value="1" required class="border rounded w-full py-2 px-3">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Unit Price</label>
                                    <input type="text" class="unit-price border rounded w-full py-2 px-3 bg-gray-100" readonly>
                                </div>
                                <div class="flex items-end">
                                    <button type="button" class="remove-item bg-red-500 text-white px-4 py-2 rounded h-10 w-full">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="button" id="add-item" class="bg-gray-500 text-white px-4 py-2 rounded">
                                Add Product
                            </button>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('items-container');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4';
            div.innerHTML = `
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Product</label>
                    <select name="items[${index}][product_id]" required class="product-select border rounded w-full py-2 px-3">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (Stock: {{ $product->quantity }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                    <input type="number" name="items[${index}][quantity]" min="1" value="1" required class="border rounded w-full py-2 px-3">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Unit Price</label>
                    <input type="text" class="unit-price border rounded w-full py-2 px-3 bg-gray-100" readonly>
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-item bg-red-500 text-white px-4 py-2 rounded h-10 w-full">
                        Remove
                    </button>
                </div>
            `;
            container.appendChild(div);
            
            // Add event listener to new product select
            div.querySelector('.product-select').addEventListener('change', function() {
                const price = this.options[this.selectedIndex]?.dataset.price || '0.00';
                this.closest('.item').querySelector('.unit-price').value = '$' + parseFloat(price).toFixed(2);
            });
        });

        // Add event listeners to existing product selects
        document.querySelectorAll('.item select').forEach(select => {
            select.addEventListener('change', function() {
                const price = this.options[this.selectedIndex]?.dataset.price || '0.00';
                this.closest('.item').querySelector('.unit-price').value = '$' + parseFloat(price).toFixed(2);
            });
            
            // Trigger change event to populate initial price
            if(select.value) {
                select.dispatchEvent(new Event('change'));
            }
        });

        // Remove item functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                if(document.querySelectorAll('.item').length > 1) {
                    e.target.closest('.item').remove();
                } else {
                    alert('You need at least one product in the order');
                }
            }
        });
    </script>
</x-app-layout>