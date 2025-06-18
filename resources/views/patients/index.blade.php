@extends('layouts.app')

@section('title', 'Patients - MediCare')

@section('content')
<div class="space-y-6">
    <!-- Add Patient Form -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Add New Patient</h2>
        <form action="{{ route('patients.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter NIK" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter full name" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter phone number" required>
            </div>
            <div class="md:col-span-2 lg:col-span-4">
                <button type="submit"
                        class="flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-600 to-teal-600 text-white px-6 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i data-lucide="plus" class="h-5 w-5"></i>
                    <span>Add Patient</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Patient Records</h1>
        <p class="text-gray-600 mt-2">Manage patient information and history</p>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('patients.index') }}" class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"></i>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search patients by name or NIK..."
               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </form>

    <!-- Patients Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($patients as $patient)
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 rounded-full">
                            <i data-lucide="user" class="h-6 w-6 text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $patient->name }}</h3>
                            <p class="text-sm text-gray-500">NIK: {{ $patient->nik }}</p>
                        </div>
                    </div>
                    @if(auth()->user()->isAdmin())
                        <div class="flex space-x-2">
                            <button onclick="editPatient({{ $patient->id }}, '{{ $patient->nik }}', '{{ $patient->name }}', '{{ $patient->date_of_birth->format('Y-m-d') }}', '{{ $patient->phone }}')"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i data-lucide="edit-2" class="h-4 w-4"></i>
                            </button>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this patient?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="space-y-3 mb-4">
                    <div class="flex items-center space-x-2 text-gray-600">
                        <i data-lucide="calendar" class="h-4 w-4"></i>
                        <span class="text-sm">Age: {{ $patient->age }} years old</span>
                    </div>
                    <div class="flex items-center space-x-2 text-gray-600">
                        <i data-lucide="phone" class="h-4 w-4"></i>
                        <span class="text-sm">{{ $patient->phone }}</span>
                    </div>
                </div>

                <!-- Transaction Summary -->
                <div class="border-t pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Transaction History</span>
                        <span class="text-sm text-gray-500">{{ $patient->transactions->count() }} visits</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Spent</span>
                        <span class="font-semibold text-green-600">Rp {{ number_format($patient->total_spent, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Recent Transactions -->
                @if($patient->transactions->count() > 0)
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-600 mb-2">Recent visits:</p>
                        <div class="space-y-1">
                            @foreach($patient->transactions->take(2) as $transaction)
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-700">{{ $transaction->created_at->format('d/m/Y') }}</span>
                                    <span class="font-medium text-gray-900">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-2 text-center py-12">
                <i data-lucide="users" class="h-12 w-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No patients found</h3>
                <p class="text-gray-500">Add your first patient using the form above</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Edit Patient</h2>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                <input type="text" name="nik" id="edit_nik" maxlength="16"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" id="edit_name"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                <input type="date" name="date_of_birth" id="edit_date_of_birth"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="tel" name="phone" id="edit_phone"
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
                    Update Patient
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();

    function editPatient(id, nik, name, dateOfBirth, phone) {
        document.getElementById('editForm').action = `/patients/${id}`;
        document.getElementById('edit_nik').value = nik;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_date_of_birth').value = dateOfBirth;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>
@endsection