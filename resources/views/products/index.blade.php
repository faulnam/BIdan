@extends('layouts.app')

@section('title', 'Products - MediCare')

@section('content')
<div class="space-y-6">
    <!-- Add Product Form -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Add New Product</h2>
        <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter product name" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                <input type="number" name="stock" value="{{ old('stock') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter stock" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price</label>
                <input type="number" name="selling_price" value="{{ old('selling_price') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Rp" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cost Price</label>
                <input type="number" name="cost_price" value="{{ old('cost_price') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Rp" required>
            </div>
            <div class="md:col-span-2 lg:col-span-4">
                <button type="submit"
                        class="flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white px-6 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i data-lucide="plus" class="h-5 w-5"></i>
                    <span>Add Product</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Product Inventory</h1>
        <p class="text-gray-600 mt-2">Manage all available products in stock</p>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('products.index') }}" class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"></i>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search products by name..."
               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </form>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($products as $product)
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-teal-100 rounded-full">
                            <i data-lucide="package" class="h-6 w-6 text-teal-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                        </div>
                    </div>
                    @if(auth()->user()->isAdmin())
                        <div class="flex space-x-2">
                            <button onclick="editProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }}, {{ $product->selling_price }}, {{ $product->cost_price }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i data-lucide="edit-2" class="h-4 w-4"></i>
                            </button>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Selling Price:</span>
                        <span class="font-semibold text-green-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Cost Price:</span>
                        <span class="text-red-600">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Profit:</span>
                        <span class="text-blue-700">Rp {{ number_format($product->profit, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12">
                <i data-lucide="package-search" class="h-12 w-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-500">Add your first product using the form above</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Edit Product</h2>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" id="edit_name"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                <input type="number" name="stock" id="edit_stock"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price</label>
                <input type="number" name="selling_price" id="edit_selling_price"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cost Price</label>
                <input type="number" name="cost_price" id="edit_cost_price"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-lg hover:from-blue-700 hover:to-teal-700 transition-all">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();

    function editProduct(id, name, stock, selling_price, cost_price) {
        document.getElementById('editForm').action = `/products/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_selling_price').value = selling_price;
        document.getElementById('edit_cost_price').value = cost_price;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('editModal').addEventListener('click', function (e) {
        if (e.target === this) closeEditModal();
    });
</script>
@endsection
