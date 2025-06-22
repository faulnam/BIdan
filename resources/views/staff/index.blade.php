@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Staff Management</h1>
            <p class="text-gray-600 mt-2">Monitor staff performance and fee distribution</p>
        </div>

        <!-- Staff Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($staff as $member)
                @php
                    $staffTransactions = $transactions->where('staff_id', $member->id);
                    $totalRevenue = $staffTransactions->sum('total');
                    $monthlyTransactions = $staffTransactions->filter(function($t) {
                        return \Carbon\Carbon::parse($t->date)->isCurrentMonth();
                    });
                    $monthlyRevenue = $monthlyTransactions->sum('total');
                    $totalTransactions = $staffTransactions->count();
                    $monthlyCount = $monthlyTransactions->count();
                @endphp

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full">
                                <i data-lucide="user" class="h-8 w-8 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $member->name }}</h3>
                                <p class="text-gray-500">Staff ID: {{ $member->id }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-green-600">
                                Rp{{ number_format($member->total_fees, 0, ',', '.') }}
                            </div>
                            <p class="text-sm text-gray-500">Total Fees Earned</p>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center space-x-2 mb-2">
                                <i data-lucide="calendar" class="h-5 w-5 text-blue-600"></i>
                                <span class="text-sm font-medium text-blue-800">All Time</span>
                            </div>
                            <div class="text-2xl font-bold text-blue-900">{{ $totalTransactions }}</div>
                            <p class="text-xs text-blue-600">Total Transactions</p>
                        </div>

                        <div class="p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center space-x-2 mb-2">
                                <i data-lucide="trending-up" class="h-5 w-5 text-green-600"></i>
                                <span class="text-sm font-medium text-green-800">This Month</span>
                            </div>
                            <div class="text-2xl font-bold text-green-900">{{ $monthlyCount }}</div>
                            <p class="text-xs text-green-600">Monthly Transactions</p>
                        </div>
                    </div>

                    <!-- Revenue Breakdown -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Total Revenue Generated</span>
                            <span class="font-bold text-gray-900">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-teal-50 rounded-lg">
                            <span class="text-sm font-medium text-teal-700">Monthly Revenue</span>
                            <span class="font-bold text-teal-900">Rp{{ number_format($monthlyRevenue, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Performance -->
                    <div class="mt-4 p-3 bg-gradient-to-r from-blue-50 to-teal-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="dollar-sign" class="h-4 w-4 text-blue-600"></i>
                                <span class="text-sm font-medium text-blue-800">Performance</span>
                            </div>
                            <span class="text-sm font-bold {{ $monthlyCount > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $monthlyCount > 0 ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Staff Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $staff->count() }}</div>
                    <p class="text-gray-600">Total Staff Members</p>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-600 mb-2">
                        Rp{{ number_format($staff->sum('total_fees'), 0, ',', '.') }}
                    </div>
                    <p class="text-gray-600">Total Fees Distributed</p>
                </div>
                <div>
                    <div class="text-3xl font-bold text-teal-600 mb-2">{{ $transactions->count() }}</div>
                    <p class="text-gray-600">Total Transactions Processed</p>
                </div>
            </div>
        </div>
    </div>
@endsection
