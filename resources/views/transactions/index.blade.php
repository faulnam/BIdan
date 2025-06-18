@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Transactions</h1>
      <p class="text-gray-600 mt-2">Manage patient transactions and billing</p>
    </div>
    <a href="{{ route('transactions.create') }}"
      class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
      {{-- Plus Icon SVG --}}
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      <span>New Transaction</span>
    </a>
  </div>

  <!-- Filters -->
  <form method="GET" class="flex flex-col sm:flex-row gap-4">
    <div class="relative flex-1">
      {{-- Search Icon SVG --}}
      <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
      </svg>
      <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Search by patient name or transaction ID..."
        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
    </div>
    <div class="relative">
      {{-- Filter Icon SVG --}}
      <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-5.414 5.414A1 1 0 0015 12v5a1 1 0 01-.447.894l-4 2.5A1 1 0 019 19v-7a1 1 0 00-.293-.707L3.293 6.707A1 1 0 013 6V4z" />
      </svg>
      <select name="filter"
        class="pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
        <option value="">All Time</option>
        <option value="today" @selected(request('filter') === 'today')>Today</option>
        <option value="week" @selected(request('filter') === 'week')>This Week</option>
        <option value="month" @selected(request('filter') === 'month')>This Month</option>
      </select>
    </div>
    <button type="submit" class="hidden">Search</button>
  </form>

  <!-- Transactions List -->
  <div class="space-y-4">
    @forelse ($transactions as $transaction)
    <div
      class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
      <div class="flex items-start justify-between mb-4">
        <div class="flex items-center space-x-4">
          <div class="p-2 bg-blue-100 rounded-full">
            {{-- File Text Icon SVG --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6M9 8h6m2 12H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z" />
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ $transaction->patient->name }}</h3>
            <p class="text-sm text-gray-500">ID: {{ $transaction->id }}</p>
            <p class="text-sm text-gray-500">
              Staff: {{ $transaction->staff->name ?? '—' }} • {{ $transaction->date->format('d/m/Y') }}
            </p>
          </div>
        </div>
        <div class="flex items-center space-x-2">
          <span
            class="px-3 py-1 rounded-full text-xs font-medium {{
              match($transaction->status) {
                'completed' => 'bg-green-100 text-green-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
                'cancelled' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800'
              }
            }}">
            {{ ucfirst($transaction->status) }}
          </span>
          <div class="flex space-x-1">
            <a href="{{ route('transactions.show', $transaction) }}"
              class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
              {{-- Eye Icon SVG --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </a>
            @can('update', $transaction)
            <a href="{{ route('transactions.edit', $transaction) }}"
              class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
              {{-- Edit Icon SVG --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
              </svg>
            </a>
            @endcan
            @can('delete', $transaction)
            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
              onsubmit="return confirm('Are you sure?');">
              @csrf @method('DELETE')
              <button type="submit"
                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                {{-- Trash Icon SVG --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </form>
            @endcan
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <h4 class="font-medium text-gray-900 mb-2">Items ({{ $transaction->items->count() }})</h4>
          <div class="space-y-1 text-sm text-gray-700">
            @foreach ($transaction->items->take(3) as $item)
            <div class="flex justify-between">
              <span>{{ $item->name }} x{{ $item->quantity }}</span>
              <span class="font-medium">{{ currency($item->total) }}</span>
            </div>
            @endforeach
            @if ($transaction->items->count() > 3)
            <p class="text-xs text-gray-500">+{{ $transaction->items->count() - 3 }} more items</p>
            @endif
          </div>
        </div>
        <div class="text-right">
          <div class="text-2xl font-bold text-gray-900 mb-1">
            {{ currency($transaction->total) }}
          </div>
          <p class="text-sm text-gray-500">Total Amount</p>
        </div>
      </div>
    </div>
    @empty
    <div class="text-center py-12">
      {{-- Empty File Icon SVG --}}
      <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6M9 8h6m2 12H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z" />
      </svg>
      <h3 class="text-lg font-medium text-gray-900 mb-2">No transactions found</h3>
      <p class="text-gray-500">Try adjusting your search or filters</p>
    </div>
    @endforelse
  </div>
</div>
@endsection
