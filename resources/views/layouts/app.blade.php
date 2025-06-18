<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MediCare - Clinic & Pharmacy Management')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-blue-50 via-white to-teal-50">
    <div class="flex">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white/80 backdrop-blur-lg border-r border-blue-100 shadow-xl">
            <div class="flex h-full flex-col">
                <!-- Logo -->
                <div class="flex h-16 items-center justify-center border-b border-blue-100 bg-gradient-to-r from-blue-600 to-teal-600">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="activity" class="h-8 w-8 text-white"></i>
                        <span class="text-xl font-bold text-white">MediCare</span>
                    </div>
                </div>

                <!-- User Info -->
                <div class="p-4 border-b border-blue-100">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-teal-500">
                            @if(auth()->user()->isAdmin())
                                <i data-lucide="shield" class="h-5 w-5 text-white"></i>
                            @else
                                <i data-lucide="user" class="h-5 w-5 text-white"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1 p-4">
                    <a href="{{ route('dashboard') }}" 
                       class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                        <i data-lucide="activity" class="mr-3 h-5 w-5"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('services.index') }}" 
                       class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('services.*') ? 'bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                        <i data-lucide="settings" class="mr-3 h-5 w-5"></i>
                        Services
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                        <i data-lucide="package" class="mr-3 h-5 w-5"></i>
                        Products
                    </a>

                    <a href="{{ route('patients.index') }}" 
                       class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('patients.*') ? 'bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                        <i data-lucide="users" class="mr-3 h-5 w-5"></i>
                        Patients
                    </a>

                    <a href="{{ route('transactions.index') }}" 
                       class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                        <i data-lucide="file-text" class="mr-3 h-5 w-5"></i>
                        Transactions
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('staff.index') }}" 
                           class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('staff.*') ? 'bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <i data-lucide="user" class="mr-3 h-5 w-5"></i>
                            Staff
                        </a>
                    @endif
                </nav>

                <!-- Logout Button -->
                <div class="p-4 border-t border-blue-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-50">
                            <i data-lucide="log-out" class="mr-3 h-5 w-5"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="pl-64 flex-1">
            <main class="min-h-screen p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were some errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Auto-hide success messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>