@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Services</h1>
            <p class="text-gray-600 mt-2">Manage your clinic services and pricing</p>
        </div>
        @if(auth()->user()?->role === 'admin')
        <button
            onclick="openModal()"
            class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300"
        >
            <i data-lucide="plus" class="h-5 w-5"></i>
            <span>Add Service</span>
        </button>
        @endif
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('services.index') }}" class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"></i>
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search services..."
            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        />
    </form>

    <!-- Service Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($services as $service)
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                @if(auth()->user()?->role === 'admin')
                <div class="flex space-x-2">
                    <button type="button"
                        onclick="editService({{ $service->id }}, '{{ $service->name }}', {{ $service->price }}, {{ $service->staff_fee }}, {{ $service->profit }})"
                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                        <i data-lucide="edit-2" class="h-4 w-4"></i>
                    </button>
                    <form action="{{ route('services.destroy', $service) }}" method="POST"
                        onsubmit="return confirm('Delete this service?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Service Price</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                </div>
                @if(auth()->user()?->role === 'admin')
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Staff Fee</span>
                    <span class="font-medium text-blue-600">Rp {{ number_format($service->staff_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between border-t pt-3">
                    <span class="text-sm font-medium text-gray-900">Clinic Profit</span>
                    <span class="font-bold text-green-600">Rp {{ number_format($service->profit, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>

            <div class="mt-4 p-3 bg-gradient-to-r from-blue-50 to-teal-50 rounded-lg">
                <div class="flex items-center text-blue-700">
                    <i data-lucide="dollar-sign" class="h-4 w-4 mr-1"></i>
                    <span class="text-sm font-medium">Revenue per service</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center text-gray-500 py-12">
            <i data-lucide="package-search" class="w-12 h-12 mx-auto mb-4 text-gray-400"></i>
            <p>No services found.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal Form -->
    <div id="serviceModal" class="fixed inset-0 hidden bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h2 class="text-xl font-bold text-gray-900 mb-4" id="modalTitle">Add New Service</h2>
            <form method="POST" id="serviceForm" action="{{ route('services.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="name" id="formName" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (IDR)</label>
                    <input type="number" name="price" id="formPrice" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Staff Fee (IDR)</label>
                    <input type="number" name="staff_fee" id="formStaffFee" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Clinic Profit (IDR)</label>
                    <input type="number" name="profit" id="formProfit" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-lg hover:from-blue-700 hover:to-teal-700 transition-all">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add New Service';
        document.getElementById('serviceForm').action = "{{ route('services.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('formName').value = '';
        document.getElementById('formPrice').value = '';
        document.getElementById('formStaffFee').value = '';
        document.getElementById('formProfit').value = '';
        document.getElementById('serviceModal').classList.remove('hidden');
        document.getElementById('serviceModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('serviceModal').classList.remove('flex');
        document.getElementById('serviceModal').classList.add('hidden');
    }

    function editService(id, name, price, staffFee, profit) {
        document.getElementById('modalTitle').innerText = 'Edit Service';
        document.getElementById('serviceForm').action = `/services/${id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('formName').value = name;
        document.getElementById('formPrice').value = price;
        document.getElementById('formStaffFee').value = staffFee;
        document.getElementById('formProfit').value = profit;
        document.getElementById('serviceModal').classList.remove('hidden');
        document.getElementById('serviceModal').classList.add('flex');
    }

    document.getElementById('serviceModal')?.addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    // Load Lucide icons (if needed)
    lucide?.createIcons();
</script>
@endsection
