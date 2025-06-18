<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediCare Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-white text-gray-800">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-teal-600 shadow text-white px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="p-2 rounded-full bg-white/20 backdrop-blur">
                <i data-lucide="activity" class="h-6 w-6 text-white"></i>
            </div>
            <span class="text-xl font-bold">MediCareee</span>
        </div>
        <a href="{{ route('login') }}" class="bg-white text-blue-700 font-semibold px-4 py-2 rounded shadow hover:bg-gray-100 transition">Login</a>
    </nav>

    <!-- Banner Carousel -->
    <div class="relative overflow-hidden">
        <div class="carousel w-full h-96 relative">
            <div class="absolute w-full h-full flex transition-all duration-1000 ease-in-out" id="carousel-slides">
                <img src="https://source.unsplash.com/1600x600/?clinic" class="w-full object-cover" />
                <img src="https://source.unsplash.com/1600x600/?pharmacy" class="w-full object-cover" />
                <img src="https://source.unsplash.com/1600x600/?healthcare" class="w-full object-cover" />
            </div>
        </div>
    </div>

    <!-- Ajakan Login -->
    <section class="text-center py-16 px-4 bg-gradient-to-b from-white to-blue-50">
        <h2 class="text-3xl font-bold mb-4">Manajemen Klinik & Apotek Terintegrasi</h2>
        <p class="mb-6 text-gray-600 max-w-2xl mx-auto">Kelola layanan, stok obat, transaksi, dan pasien dalam satu sistem digital yang efisien dan mudah digunakan.</p>
        <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">Mulai Login</a>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-700 text-white text-center py-6">
        <p class="text-sm">&copy; {{ date('Y') }} MediCare. All rights reserved.</p>
    </footer>

    <script>
        lucide.createIcons();

        // Simple automatic carousel
        const slides = document.getElementById('carousel-slides');
        let index = 0;
        setInterval(() => {
            index = (index + 1) % 3;
            slides.style.transform = `translateX(-${index * 100}%)`;
        }, 3000);
    </script>
</body>
</html>
