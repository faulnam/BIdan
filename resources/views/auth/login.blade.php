<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - MediCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-teal-600 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                    <i data-lucide="activity" class="h-12 w-12 text-white"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">MediCare</h1>
            <p class="text-blue-100">Clinic & Pharmacy Management</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Login as:</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center p-3 rounded-lg border-2 cursor-pointer transition-all role-option" data-role="admin">
                            <input type="radio" name="role" value="admin" class="sr-only" required>
                            <i data-lucide="shield" class="h-5 w-5 mr-2"></i>
                            Admin
                        </label>
                        <label class="flex items-center justify-center p-3 rounded-lg border-2 cursor-pointer transition-all role-option" data-role="staff">
                            <input type="radio" name="role" value="staff" class="sr-only" required>
                            <i data-lucide="user" class="h-5 w-5 mr-2"></i>
                            Staff
                        </label>
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"></i>
                        <input id="username" name="username" type="text" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               placeholder="Enter username" value="{{ old('username') }}">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"></i>
                        <input id="password" name="password" type="password" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               placeholder="Enter password">
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        @foreach($errors->all() as $error)
                            <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Demo Credentials -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <p class="text-xs text-gray-600 mb-2">Demo Credentials:</p>
                    <p class="text-xs text-gray-500">
                        Admin: admin / password<br>
                        Staff: staff1 or staff2 / password
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submit-btn"
                        class="w-full py-3 rounded-lg font-medium transition-all bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white shadow-lg hover:shadow-xl">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Role selection handling
        const roleOptions = document.querySelectorAll('.role-option');
        const submitBtn = document.getElementById('submit-btn');

        roleOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all options
                roleOptions.forEach(opt => {
                    opt.classList.remove('border-blue-500', 'bg-blue-50', 'text-blue-700', 'border-teal-500', 'bg-teal-50', 'text-teal-700');
                    opt.classList.add('border-gray-200', 'text-gray-600');
                });

                // Add active class to selected option
                const role = this.dataset.role;
                if (role === 'admin') {
                    this.classList.remove('border-gray-200', 'text-gray-600');
                    this.classList.add('border-blue-500', 'bg-blue-50', 'text-blue-700');
                    submitBtn.className = 'w-full py-3 rounded-lg font-medium transition-all bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white shadow-lg hover:shadow-xl';
                } else {
                    this.classList.remove('border-gray-200', 'text-gray-600');
                    this.classList.add('border-teal-500', 'bg-teal-50', 'text-teal-700');
                    submitBtn.className = 'w-full py-3 rounded-lg font-medium transition-all bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white shadow-lg hover:shadow-xl';
                }

                // Check the radio button
                this.querySelector('input[type="radio"]').checked = true;
            });
        });

        // Set default role
        roleOptions[0].click();
    </script>
</body>
</html>