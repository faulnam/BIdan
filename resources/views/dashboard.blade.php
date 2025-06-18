@extends('layouts.app')

@section('title', 'Dashboard - MediCare')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            Welcome back, {{ auth()->user()->name }}!
        </h1>
        <p class="text-gray-600 mt-2">
            Here's what's happening at your clinic today.
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Patients -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Patients</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_patients'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="users" class="h-6 w-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Today's Transactions -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Today's Transactions</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['today_transactions'] }}</p>
                    <p class="text-sm text-green-600 mt-1 flex items-center">
                        <i data-lucide="trending-up" class="h-4 w-4 mr-1"></i>
                        +12% from yesterday
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="calendar" class="h-6 w-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-lg">
                    <i data-lucide="dollar-sign" class="h-6 w-6 text-emerald-600"></i>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Low Stock Itemms</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['low_stock_products'] }}</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-lg">
                    <i data-lucide="alert-triangle" class="h-6 w-6 text-amber-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Services -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Services</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_services'] }}</p>
                </div>
                <div class="p-3 bg-teal-100 rounded-lg">
                    <i data-lucide="activity" class="h-6 w-6 text-teal-600"></i>
                </div>
            </div>
        </div>

        <!-- Products in Stock -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Products in Stock</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_products'] }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i data-lucide="package" class="h-6 w-6 text-purple-600"></i>
                </div>
            </div>
        </div>

        <!-- All Transactions -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">All Transactions</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_transactions'] }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <i data-lucide="file-text" class="h-6 w-6 text-indigo-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Transactions</h3>
            <div class="space-y-3">
                @forelse($recent_transactions as $transaction)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $transaction->patient->name }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->transaction_id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $transaction->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent transactions</p>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Alerts</h3>
            <div class="space-y-3">
                @forelse($low_stock_products as $product)
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg border border-amber-200">
                        <div>
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-amber-600">Low stock warning</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-amber-600">{{ $product->stock }} left</p>
                            <p class="text-xs text-gray-500">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <div class="flex justify-center mb-2">
                            <div class="p-2 bg-green-100 rounded-full">
                                <i data-lucide="package" class="h-6 w-6 text-green-600"></i>
                            </div>
                        </div>
                        <p class="text-green-600 font-medium">All products are well stocked!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection