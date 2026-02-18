<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'ApartmentHub') }} - Find Your Perfect Stay</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Styles / Scripts (semua tema & dark mode di resources/css/app.css + tailwind.config.js) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Navbar -->
        <nav class="sticky top-0 z-50 border-b bg-background border-border">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center gap-2">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-primary">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-foreground">ApartmentHub</span>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ url('/') }}" class="font-medium hover:opacity-70 transition text-foreground">Home</a>
                        <a href="{{ route('rooms.index') }}" class="font-medium hover:opacity-70 transition text-muted">Rooms</a>
                        <a href="#properties" class="font-medium hover:opacity-70 transition text-muted">Properties</a>
                        <a href="#features" class="font-medium hover:opacity-70 transition text-muted">Features</a>
                        <a href="#contact" class="font-medium hover:opacity-70 transition text-muted">Contact</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-secondary">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-secondary">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-primary">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        @endif

                        <!-- Dark Mode Toggle -->
                        <button id="theme-toggle" type="button" class="p-2 rounded-lg transition bg-surface text-foreground" aria-label="Toggle dark mode">
                            <i class="fas fa-moon" id="theme-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-gradient py-20 md:py-24">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="text-center mb-12">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 tracking-tight">
                        Find Your Perfect Stay
                    </h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
                        Discover and book premium apartments for your next stay. Comfortable, convenient, and curated just for you.
                    </p>
                </div>

                <!-- Search Box -->
                <div class="max-w-4xl mx-auto">
                    <div class="search-box">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-muted">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Location
                                </label>
                                <input type="text" placeholder="Where are you going?" class="w-full p-3 rounded-lg border border-border bg-background text-foreground transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-muted">
                                    <i class="fas fa-calendar mr-2"></i>Check-in / Check-out
                                </label>
                                <input type="text" placeholder="Add dates" class="w-full p-3 rounded-lg border border-border bg-background text-foreground transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-muted">
                                    <i class="fas fa-users mr-2"></i>Guests
                                </label>
                                <select class="w-full p-3 rounded-lg border border-border bg-background text-foreground transition">
                                    <option>1 Guest</option>
                                    <option>2 Guests</option>
                                    <option>3 Guests</option>
                                    <option>4+ Guests</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn-primary w-full mt-6">
                            <i class="fas fa-search mr-2"></i>Search Apartments
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 bg-surface">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-foreground">Why Choose Us</h2>
                    <p class="text-lg text-muted">Experience the best in apartment booking</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center bg-primary-lighter">
                            <i class="fas fa-shield-alt text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-foreground">Secure Booking</h3>
                        <p class="text-muted">Your payment and personal information are always protected</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center bg-primary-lighter">
                            <i class="fas fa-star text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-foreground">Premium Quality</h3>
                        <p class="text-muted">Handpicked apartments with verified quality standards</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center bg-primary-lighter">
                            <i class="fas fa-headset text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-foreground">24/7 Support</h3>
                        <p class="text-muted">Our team is always ready to help you anytime</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Properties Section -->
        <section id="properties" class="py-16">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl sm:text-4xl font-bold mb-2 text-foreground">Featured Properties</h2>
                        <p class="text-lg text-muted">Handpicked apartments just for you</p>
                    </div>
                    <a href="{{ route('rooms.index') }}" class="btn-secondary hidden md:inline-flex">
                        View All Rooms <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Property Card 1 -->
                    <div class="card cursor-pointer">
                        <div class="relative h-64 overflow-hidden rounded-t-2xl bg-border">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-image text-6xl opacity-20 text-foreground"></i>
                            </div>
                            <span class="badge absolute top-4 left-4">Popular</span>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-semibold text-foreground">Modern Downtown Loft</h3>
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-star text-sm text-warning"></i>
                                    <span class="text-sm font-medium text-foreground">4.9</span>
                                </div>
                            </div>
                            <p class="text-sm mb-4 text-muted">
                                <i class="fas fa-map-marker-alt mr-1"></i>Jakarta, Indonesia
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4 text-sm text-muted">
                                    <span><i class="fas fa-bed mr-1"></i>2 Beds</span>
                                    <span><i class="fas fa-bath mr-1"></i>2 Baths</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-primary">$120</p>
                                    <p class="text-sm text-muted">per night</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 2 -->
                    <div class="card cursor-pointer">
                        <div class="relative h-64 overflow-hidden rounded-t-2xl bg-border">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-image text-6xl opacity-20 text-foreground"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-semibold text-foreground">Luxury Beach Suite</h3>
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-star text-sm text-warning"></i>
                                    <span class="text-sm font-medium text-foreground">5.0</span>
                                </div>
                            </div>
                            <p class="text-sm mb-4 text-muted">
                                <i class="fas fa-map-marker-alt mr-1"></i>Bali, Indonesia
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4 text-sm text-muted">
                                    <span><i class="fas fa-bed mr-1"></i>3 Beds</span>
                                    <span><i class="fas fa-bath mr-1"></i>3 Baths</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-primary">$250</p>
                                    <p class="text-sm text-muted">per night</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 3 -->
                    <div class="card cursor-pointer">
                        <div class="relative h-64 overflow-hidden rounded-t-2xl bg-border">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-image text-6xl opacity-20 text-foreground"></i>
                            </div>
                            <span class="badge absolute top-4 left-4 bg-info text-white">New</span>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-semibold text-foreground">Cozy Studio Apartment</h3>
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-star text-sm text-warning"></i>
                                    <span class="text-sm font-medium text-foreground">4.8</span>
                                </div>
                            </div>
                            <p class="text-sm mb-4 text-muted">
                                <i class="fas fa-map-marker-alt mr-1"></i>Bandung, Indonesia
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4 text-sm text-muted">
                                    <span><i class="fas fa-bed mr-1"></i>1 Bed</span>
                                    <span><i class="fas fa-bath mr-1"></i>1 Bath</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-primary">$80</p>
                                    <p class="text-sm text-muted">per night</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12 md:hidden">
                    <a href="{{ route('rooms.index') }}" class="btn-primary">
                        View All Rooms <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 hero-gradient">
            <div class="container mx-auto px-4 md:px-8 lg:px-12 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Ready to Find Your Perfect Stay?</h2>
                <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Join thousands of satisfied guests who found their ideal apartment through our platform
                </p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300 text-primary">
                        Get Started Now <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 border-t border-border bg-surface">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-primary">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <span class="text-lg font-bold text-foreground">ApartmentHub</span>
                        </div>
                        <p class="text-sm text-muted">
                            Your trusted platform for finding and booking premium apartments worldwide.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4 text-foreground">Company</h4>
                        <ul class="space-y-2 text-sm text-muted">
                            <li><a href="#" class="hover:opacity-70 transition">About Us</a></li>
                            <li><a href="#" class="hover:opacity-70 transition">Careers</a></li>
                            <li><a href="#" class="hover:opacity-70 transition">Press</a></li>
                            <li><a href="#" class="hover:opacity-70 transition">Blog</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4 text-foreground">Support</h4>
                        <ul class="space-y-2 text-sm text-muted">
                            <li><a href="#" class="hover:opacity-70 transition">Help Center</a></li>
                            <li><a href="#" class="hover:opacity-70 transition">Safety</a></li>
                            <li><a href="#" class="hover:opacity-70 transition">Cancellation</a></li>
                            <li><a href="#" class="hover:opacity-70 transition">Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4 text-foreground">Connect</h4>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition hover:opacity-70 bg-primary-lighter text-primary">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition hover:opacity-70 bg-primary-lighter text-primary">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition hover:opacity-70 bg-primary-lighter text-primary">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-border pt-8 text-center text-sm text-muted">
                    <p>&copy; {{ date('Y') }} ApartmentHub. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // Dark Mode Toggle
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const html = document.documentElement;

            // Check for saved theme preference or default to system preference
            const currentTheme = localStorage.getItem('theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            html.setAttribute('data-theme', currentTheme);
            updateThemeIcon(currentTheme);

            themeToggle.addEventListener('click', () => {
                const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateThemeIcon(newTheme);
            });

            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }
        </script>
    </body>
</html>