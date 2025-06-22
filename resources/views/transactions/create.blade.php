@extends('layouts.app')

@section('title', 'Add Transaction')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add Transaction</h1>
    </div>

    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
        @csrf

        <!-- Select Patient -->
        <div class="mb-4">
            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
            <select name="patient_id" id="patient_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">-- Choose Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Services Section -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Services</h2>
            <div class="space-y-2">
                @foreach($services as $service)
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" class="service-checkbox text-blue-500 border-gray-300 rounded"
                               data-type="service" data-id="{{ $service->id }}">
                        <label class="text-sm text-gray-700 w-1/3">
                            {{ $service->name }} (Rp{{ number_format($service->price) }})
                        </label>
                        <input type="number" min="1" value="1"
                               class="quantity-input hidden w-20 rounded border border-gray-300 px-2 py-1 text-sm"
                               data-quantity-id="service_{{ $service->id }}" placeholder="Qty">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Products Section -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Products</h2>
            <div class="space-y-2">
                @foreach($products as $product)
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" class="product-checkbox text-blue-500 border-gray-300 rounded"
                               data-type="product" data-id="{{ $product->id }}">
                        <label class="text-sm text-gray-700 w-1/3">
                            {{ $product->name }} (Rp{{ number_format($product->selling_price) }}, stock: {{ $product->stock }})
                        </label>
                        <input type="number" min="1" value="1"
                               class="quantity-input hidden w-20 rounded border border-gray-300 px-2 py-1 text-sm"
                               data-quantity-id="product_{{ $product->id }}" placeholder="Qty">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Dynamic items input container -->
        <div id="dynamic-items-container"></div>

        <!-- Buttons -->
        <div class="flex justify-between mt-6">
            <a href="{{ route('transactions.index') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-md">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back
            </a>
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">
                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Transaction
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.service-checkbox, .product-checkbox');
            const form = document.getElementById('transactionForm');
            const dynamicContainer = document.getElementById('dynamic-items-container');

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    const type = this.dataset.type;
                    const id = this.dataset.id;
                    const quantityInput = document.querySelector(`[data-quantity-id="${type}_${id}"]`);
                    quantityInput.classList.toggle('hidden', !this.checked);
                });
            });

            form.addEventListener('submit', function (e) {
                // Remove old inputs
                dynamicContainer.innerHTML = '';

                let itemIndex = 0;

                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        const type = cb.dataset.type;
                        const id = cb.dataset.id;
                        const quantity = document.querySelector(`[data-quantity-id="${type}_${id}"]`).value || 1;

                        // Create inputs for items[INDEX][type], [id], [quantity]
                        const typeInput = document.createElement('input');
                        typeInput.type = 'hidden';
                        typeInput.name = `items[${itemIndex}][type]`;
                        typeInput.value = type;

                        const idInput = document.createElement('input');
                        idInput.type = 'hidden';
                        idInput.name = `items[${itemIndex}][id]`;
                        idInput.value = id;

                        const qtyInput = document.createElement('input');
                        qtyInput.type = 'hidden';
                        qtyInput.name = `items[${itemIndex}][quantity]`;
                        qtyInput.value = quantity;

                        dynamicContainer.appendChild(typeInput);
                        dynamicContainer.appendChild(idInput);
                        dynamicContainer.appendChild(qtyInput);

                        itemIndex++;
                    }
                });
            });
        });
    </script>
@endsection
