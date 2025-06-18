@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div>
    <h1 class="text-3xl font-bold text-gray-900">Staff Management</h1>
    <p class="text-gray-600 mt-2">Monitor staff performance and fee distribution</p>
  </div>

  <!-- Staff Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @foreach ($staff as $member)
      @php
        $staffTransactions = $transactions->where('staff_id', $member->id);
        $totalRevenue = $staffTransactions->sum('total');

        $thisMonth = now()->month;
        $thisYear = now()->year;
        $monthlyTransactions = $staffTransactions->filter(function ($t) use ($thisMonth, $thisYear) {
            return \Carbon\Carbon::parse($t->date)->month === $thisMonth && \Carbon\Carbon::parse($t->date)->year === $thisYear;
        });
        $monthlyRevenue = $monthlyTransactions->sum('total');
      @endphp

      <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
        <div class="flex items-start justify-between mb-6">
          <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M16 14a4 4 0 00-8 0m8 0v4a4 4 0 01-8 0v-4m8 0a4 4 0 01-8 0" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900">{{ $member->name }}</h3>
              <p class="text-gray-500">Staff ID: {{ $member->id }}</p>
            </div>
          </div>
          <div class="text-right">
            <div class="text-lg font-bold text-green-600">
              {{ currency($member->total_fees) }}
            </div>
            <p class="text-sm text-gray-500">Total Fees Earned</p>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div class="p-4 bg-blue-50 rounded-lg">
            <div class="flex items-center space-x-2 mb-2">
              <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8 7V3m8 4V3M5 11h14M5 19h14M5 15h14" />
              </svg>
              <span class="text-sm font-medium text-blue-800">All Time</span>
            </div>
            <div class="text-2xl font-bold text-blue-900">{{ $staffTransactions->count() }}</div>
            <p class="text-xs text-blue-600">Total Transactions</p>
          </div>

          <div class="p-4 bg-green-50 rounded-lg">
            <div class="flex items-center space-x-2 mb-2">
              <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 17l6-6 4 4 8-8" />
              </svg>
              <span class="text-sm font-medium text-green-800">This Month</span>
            </div>
            <div class="text-2xl font-bold text-green-900">{{ $monthlyTransactions->count() }}</div>
            <p class="text-xs text-green-600">Monthly Transactions</p>
          </div>
        </div>

        <!-- Revenue Breakdown -->
        <div class="space-y-3">
          <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <span class="text-sm font-medium text-gray-700">Total Revenue Generated</span>
            <span class="font-bold text-gray-900">{{ currency($totalRevenue) }}</span>
          </div>

          <div class="flex items-center justify-between p-3 bg-teal-50 rounded-lg">
            <span class="text-sm font-medium text-teal-700">Monthly Revenue</span>
            <span class="font-bold text-teal-900">{{ currency($monthlyRevenue) }}</span>
          </div>
        </div>

        <!-- Performance Indicator -->
        <div class="mt-4 p-3 bg-gradient-to-r from-blue-50 to-teal-50 rounded-lg">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
              <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 8c1.104 0 2-.896 2-2s-.896-2-2-2s-2 .896-2 2s.896 2 2 2zm0 2c-2.21 0-4 1.79-4 4v2h8v-2c0-2.21-1.79-4-4-4z" />
              </svg>
              <span class="text-sm font-medium text-blue-800">Performance</span>
            </div>
            <span class="text-sm font-bold {{ $monthlyTransactions->count() > 0 ? 'text-green-600' : 'text-red-600' }}">
              {{ $monthlyTransactions->count() > 0 ? 'Active' : 'Inactive' }}
            </span>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Summary Card -->
  <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Staff Summary</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="text-center">
        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $staff->count() }}</div>
        <p class="text-gray-600">Total Staff Members</p>
      </div>
      <div class="text-center">
        <div class="text-3xl font-bold text-green-600 mb-2">
          {{ currency($staff->sum('total_fees')) }}
        </div>
        <p class="text-gray-600">Total Fees Distributed</p>
      </div>
      <div class="text-center">
        <div class="text-3xl font-bold text-teal-600 mb-2">
          {{ $transactions->count() }}
        </div>
        <p class="text-gray-600">Total Transactions Processed</p>
      </div>
    </div>
  </div>
</div>
@endsection
