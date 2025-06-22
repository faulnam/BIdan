@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>
        <p class="text-sm text-gray-500">Manage your clinic transactions and records</p>
    </div>

    <!-- Search & Add -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-3 md:space-y-0">
        <form method="GET" class="flex items-center space-x-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full md:w-64 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                placeholder="Search by ID or patient name">
            <button type="submit"
                class="inline-flex items-center rounded-md bg-blue-500 px-3 py-2 text-sm font-medium text-white hover:bg-blue-600">
                <i data-lucide="search" class="mr-1 h-4 w-4"></i> Search
            </button>
        </form>

        <a href="{{ route('transactions.create') }}"
            class="inline-flex items-center rounded-md bg-gradient-to-r from-blue-500 to-teal-500 px-4 py-2 text-sm font-medium text-white shadow hover:from-blue-600 hover:to-teal-600 transition">
            <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
            Add Transaction
        </a>
    </div>

    <!-- Transactions Card View -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($transactions as $transaction)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">Transaction #{{ $transaction->id }}</h2>
                    <span class="text-xs font-medium px-2 py-1 rounded 
                        {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>

                <div class="text-sm text-gray-600 space-y-1 mb-4">
                    <p><strong>Patient:</strong> {{ $transaction->patient->name }}</p>
                    <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y') }}</p>
                    <p><strong>Total:</strong> Rp{{ number_format($transaction->total, 0, ',', '.') }}</p>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <a href="{{ route('transactions.show', $transaction->id) }}"
                        class="inline-flex items-center text-blue-600 hover:underline">
                        <i data-lucide="eye" class="w-4 h-4 mr-1"></i> View
                    </a>
                    <a href="{{ route('transactions.downloadPDF', $transaction->id) }}"
                        class="inline-flex items-center text-gray-600 hover:underline">
                        <i data-lucide="download" class="w-4 h-4 mr-1"></i> PDF
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                No transactions found.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $transactions->links('pagination::tailwind') }}
    </div>
@endsection
