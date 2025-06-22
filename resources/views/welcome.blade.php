<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediCare - Healthcare Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #3B82F6, #14B8A6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass-effect { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); }
        .slide-enter { animation: slideIn 1s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .hover-lift { transition: all 0.3s ease; }
        .hover-lift:hover { transform: translateY(-8px); }
    </style>
</head>
<body class="bg-white text-gray-800 overflow-x-hidden">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm border-b border-gray-100 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-teal-600 rounded-lg shadow-lg">
                        <i data-lucide="activity" class="h-8 w-8 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold gradient-text">MediCare</h1>
                        <p class="text-xs text-gray-500">Healthcare Management</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Features</a>
                    <a href="#about" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">About</a>
                    <a href="#contact" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Contact</a>
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-teal-600 text-white px-6 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-teal-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Login
                    </a>
                </div>

                <!-- Mobile Login Button -->
                <div class="md:hidden">
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-teal-600 text-white px-4 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-teal-700 transition-all duration-300">
                        Login
                    </a>
                </div>
            </div>
        </div>
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

        <!-- Slider Controls -->
        <button onclick="prevSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 glass-effect text-white p-3 rounded-full hover:bg-white/20 transition-all duration-300 z-10">
            <i data-lucide="chevron-left" class="h-6 w-6"></i>
        </button>
        <button onclick="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 glass-effect text-white p-3 rounded-full hover:bg-white/20 transition-all duration-300 z-10">
            <i data-lucide="chevron-right" class="h-6 w-6"></i>
        </button>

        <!-- Slide Indicators -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10">
            <button onclick="goToSlide(0)" class="slide-indicator w-3 h-3 rounded-full bg-white transition-all duration-300"></button>
            <button onclick="goToSlide(1)" class="slide-indicator w-3 h-3 rounded-full bg-white/50 transition-all duration-300"></button>
            <button onclick="goToSlide(2)" class="slide-indicator w-3 h-3 rounded-full bg-white/50 transition-all duration-300"></button>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Comprehensive Healthcare Solutions
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Everything you need to manage your clinic and pharmacy operations efficiently, from patient records to inventory management.
                </p>
            </div>

            
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Built for Modern Healthcare
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        MediCare is designed specifically for healthcare professionals who demand efficiency, security, and reliability in their daily operations. Our platform combines intuitive design with powerful functionality.
                    </p>
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <i data-lucide="heart" class="h-3 w-3 text-white"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Patient-centered approach</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                <i data-lucide="shield" class="h-3 w-3 text-white"></i>
                            </div>
                            <span class="text-gray-700 font-medium">HIPAA compliant security</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-teal-500 rounded-full flex items-center justify-center">
                                <i data-lucide="clock" class="h-3 w-3 text-white"></i>
                            </div>
                            <span class="text-gray-700 font-medium">24/7 system availability</span>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-blue-600 to-teal-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-teal-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Start Your Journey
                    </a>
                </div>
                <div class="relative">
                    <img src="https://images.pexels.com/photos/4386467/pexels-photo-4386467.jpeg?auto=compress&cs=tinysrgb&w=800&h=600&fit=crop" alt="Healthcare professionals" class="rounded-2xl shadow-2xl">
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-xl shadow-xl">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                                <i data-lucide="users" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">1000+</p>
                                <p class="text-sm text-gray-600">Happy Patients</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-blue-600 to-teal-600 rounded-lg shadow-lg">
                            <i data-lucide="activity" class="h-8 w-8 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">MediCare</h3>
                            <p class="text-gray-400 text-sm">Healthcare Management System</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Empowering healthcare professionals with comprehensive management solutions for clinics and pharmacies. Streamline operations, enhance patient care, and grow your practice with confidence.
                    </p>
                    <div class="flex space-x-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors cursor-pointer">
                            <span class="text-sm font-bold">f</span>
                        </div>
                        <div class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors cursor-pointer">
                            <span class="text-sm font-bold">t</span>
                        </div>
                        <div class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors cursor-pointer">
                            <span class="text-sm font-bold">in</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-300 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#about" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Support</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Documentation</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Contact Us</h4>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="phone" class="h-5 w-5 text-blue-400"></i>
                            <span class="text-gray-300">+1 (555) 123-4567</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i data-lucide="mail" class="h-5 w-5 text-blue-400"></i>
                            <span class="text-gray-300">support@medicare.com</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i data-lucide="map-pin" class="h-5 w-5 text-blue-400 mt-1"></i>
                            <span class="text-gray-300">123 Healthcare Ave<br>Medical District, MD 12345</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} MediCare Healthcare Management. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Enhanced carousel functionality
        const slides = document.getElementById('carousel-slides');
        const indicators = document.querySelectorAll('.slide-indicator');
        const totalSlides = 3;
        let currentSlide = 0;
        let autoplayInterval;

        function updateSlide() {
            slides.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update indicators
            indicators.forEach((indicator, index) => {
                if (index === currentSlide) {
                    indicator.classList.remove('bg-white/50');
                    indicator.classList.add('bg-white');
                } else {
                    indicator.classList.remove('bg-white');
                    indicator.classList.add('bg-white/50');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlide();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlide();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlide();
        }

        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 4000);
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        // Start autoplay
        startAutoplay();

        // Pause autoplay on hover
        const carousel = document.querySelector('.carousel');
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 100) {
                navbar.classList.add('shadow-lg');
                navbar.classList.remove('border-b');
            } else {
                navbar.classList.remove('shadow-lg');
                navbar.classList.add('border-b');
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('slide-enter');
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('#features .hover-lift').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>