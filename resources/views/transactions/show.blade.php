@extends('layouts.app')

@section('title', 'Transaction Detail')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Transaction #{{ $transaction->id }}</h1>
        <p class="text-gray-600">Date: {{ $transaction->created_at->format('d M Y H:i') }}</p>
        <p class="text-gray-600">Patient: {{ $transaction->patient->name }}</p>
        <p class="text-gray-600">Handled by: {{ $transaction->user->name }}</p>
    </div>

    <div class="bg-white rounded shadow p-4">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr>
                    <th class="text-left py-2">#</th>
                    <th class="text-left py-2">Type</th>
                    <th class="text-left py-2">Name</th>
                    <th class="text-left py-2">Quantity</th>
                    <th class="text-left py-2">Price</th>
                    <th class="text-left py-2">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php $grandTotal = 0; @endphp
                @foreach($transaction->items as $index => $item)
                    @php $grandTotal += $item->total; @endphp
                    <tr>
                        <td class="py-2">{{ $index + 1 }}</td>
                        <td class="py-2">{{ ucfirst($item->type) }}</td>
                        <td class="py-2">{{ $item->item_name }}</td>
                        <td class="py-2">{{ $item->quantity }}</td>
                        <td class="py-2">Rp{{ number_format($item->price) }}</td>
                        <td class="py-2">Rp{{ number_format($item->total) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right font-semibold py-2">Total</td>
                    <td class="py-2 font-semibold">Rp{{ number_format($grandTotal) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('transactions.index') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-md">
            ← Back
        </a>
        <a href="{{ route('transactions.downloadPDF', $transaction->id) }}"
           class="ml-2 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md">
            ⬇ Download PDF
        </a>
    </div>
@endsection
