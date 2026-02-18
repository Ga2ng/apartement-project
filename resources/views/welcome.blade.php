<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Discover and book premium apartments for your next stay. Comfortable, convenient, and curated just for you.">

        <title>{{ config('app.name', 'ApartmentHub') }} - Find Your Perfect Stay</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar" id="main-navbar">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-primary transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <i class="fas fa-building text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold text-foreground">Apartment<span class="text-primary">Hub</span></span>
                    </a>

                    <!-- Navigation Links (Desktop) -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ url('/') }}" class="nav-link active">Home</a>
                        <a href="{{ route('rooms.index') }}" class="nav-link">Rooms</a>
                        <a href="#properties" class="nav-link">Properties</a>
                        <a href="#features" class="nav-link">Features</a>
                        <a href="#contact" class="nav-link">Contact</a>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-secondary hidden sm:inline-flex items-center gap-2 py-2.5 px-5 text-sm">
                                    <i class="fas fa-th-large text-xs"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-secondary hidden sm:inline-flex items-center gap-2 py-2.5 px-5 text-sm">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-primary hidden sm:inline-flex items-center gap-2 py-2.5 px-5 text-sm">
                                        Get Started <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                @endif
                            @endauth
                        @endif

                        <!-- Dark Mode Toggle -->
                        <button id="theme-toggle" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 bg-surface text-foreground border border-border" aria-label="Toggle dark mode">
                            <i class="fas fa-moon" id="theme-icon"></i>
                        </button>

                        <!-- Mobile Menu Toggle -->
                        <button id="mobile-toggle" class="hamburger md:hidden" aria-label="Toggle mobile menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-menu-panel">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-lg font-bold text-foreground">Menu</span>
                    <button id="mobile-close" class="w-10 h-10 rounded-xl flex items-center justify-center bg-surface border border-border text-foreground hover:text-primary transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="flex flex-col space-y-1">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground font-medium hover:bg-surface transition">
                        <i class="fas fa-home w-5 text-center text-primary"></i> Home
                    </a>
                    <a href="{{ route('rooms.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-muted font-medium hover:bg-surface hover:text-foreground transition">
                        <i class="fas fa-door-open w-5 text-center"></i> Rooms
                    </a>
                    <a href="#properties" class="flex items-center gap-3 px-4 py-3 rounded-xl text-muted font-medium hover:bg-surface hover:text-foreground transition mobile-link">
                        <i class="fas fa-building w-5 text-center"></i> Properties
                    </a>
                    <a href="#features" class="flex items-center gap-3 px-4 py-3 rounded-xl text-muted font-medium hover:bg-surface hover:text-foreground transition mobile-link">
                        <i class="fas fa-star w-5 text-center"></i> Features
                    </a>
                    <a href="#contact" class="flex items-center gap-3 px-4 py-3 rounded-xl text-muted font-medium hover:bg-surface hover:text-foreground transition mobile-link">
                        <i class="fas fa-envelope w-5 text-center"></i> Contact
                    </a>
                </div>

                <!-- Mobile Auth Buttons -->
                <div class="mt-8 pt-6 border-t border-border space-y-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary w-full text-center block py-3">
                                <i class="fas fa-th-large mr-2"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary w-full text-center block py-3">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-primary w-full text-center block py-3">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>

        <!-- Hero Section with Background Slideshow -->
        <section class="relative overflow-hidden min-h-[700px] md:min-h-[750px] flex items-center" id="hero-section">
            <!-- Background Image Slideshow -->
            <div class="absolute inset-0 z-0" id="hero-slideshow">
                <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1920&q=80&auto=format&fit=crop')"></div>
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1920&q=80&auto=format&fit=crop')"></div>
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1920&q=80&auto=format&fit=crop')"></div>
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1920&q=80&auto=format&fit=crop')"></div>
            </div>

            <!-- Dark Overlay (subtle, keeps images visible) -->
            <div class="absolute inset-0 z-1" style="background: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%, rgba(0,0,0,0.35) 50%, rgba(0,0,0,0.55) 100%);"></div>

            <!-- Decorative floating elements -->
            <div class="absolute top-10 left-10 w-20 h-20 rounded-full bg-white/5 animate-float z-2"></div>
            <div class="absolute bottom-20 right-20 w-32 h-32 rounded-full bg-white/5 animate-float delay-300 z-2"></div>
            <div class="absolute top-1/2 left-1/4 w-16 h-16 rounded-full bg-white/5 animate-float delay-500 z-2"></div>

            <!-- Slideshow Indicator Dots -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2" id="hero-dots">
                <button class="hero-dot active" data-slide="0" aria-label="Slide 1"></button>
                <button class="hero-dot" data-slide="1" aria-label="Slide 2"></button>
                <button class="hero-dot" data-slide="2" aria-label="Slide 3"></button>
                <button class="hero-dot" data-slide="3" aria-label="Slide 4"></button>
            </div>

            <!-- Content -->
            <div class="container mx-auto px-4 md:px-8 lg:px-12 relative z-10 py-24 md:py-32">
                <div class="text-center mb-14">
                    <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm rounded-full px-5 py-2 mb-6 animate-fade-in-down">
                        <i class="fas fa-sparkles text-white/90 text-sm"></i>
                        <span class="text-white/90 text-sm font-medium">Premium Apartment Booking Platform</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 tracking-tight leading-tight animate-fade-in-up drop-shadow-lg">
                        Find Your<br>
                        <span class="relative">
                            Perfect Stay
                            <svg class="absolute -bottom-2 left-0 w-full" height="12" viewBox="0 0 200 12" fill="none">
                                <path d="M2 8C30 3 60 2 100 5C140 8 170 4 198 2" stroke="rgba(255,255,255,0.4)" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </h1>
                    <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-200 drop-shadow">
                        Discover and book premium apartments for your next stay. Comfortable, convenient, and curated just for you.
                    </p>
                </div>

                <!-- Search Box -->
                <div class="max-w-4xl mx-auto animate-fade-in-up delay-300">
                    <div class="search-box">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-foreground">
                                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>Location
                                </label>
                                <input type="text" placeholder="Where are you going?" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-foreground">
                                    <i class="fas fa-calendar mr-2 text-primary"></i>Check-in / Check-out
                                </label>
                                <input type="text" placeholder="Add dates" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-foreground">
                                    <i class="fas fa-users mr-2 text-primary"></i>Guests
                                </label>
                                <select class="form-input">
                                    <option>1 Guest</option>
                                    <option>2 Guests</option>
                                    <option>3 Guests</option>
                                    <option>4+ Guests</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn-primary w-full mt-6 py-4 text-base">
                            <i class="fas fa-search mr-2"></i>Search Apartments
                        </button>
                    </div>
                </div>

                <!-- Stats Bar -->
                <div class="max-w-3xl mx-auto mt-12 grid grid-cols-3 gap-4 animate-fade-in-up delay-400">
                    <div class="stat-card">
                        <div class="text-2xl md:text-3xl font-bold text-white mb-1" data-count="500">500+</div>
                        <div class="text-white/70 text-xs md:text-sm">Properties</div>
                    </div>
                    <div class="stat-card">
                        <div class="text-2xl md:text-3xl font-bold text-white mb-1" data-count="10000">10K+</div>
                        <div class="text-white/70 text-xs md:text-sm">Happy Guests</div>
                    </div>
                    <div class="stat-card">
                        <div class="text-2xl md:text-3xl font-bold text-white mb-1">4.9</div>
                        <div class="text-white/70 text-xs md:text-sm flex items-center justify-center gap-1">
                            <i class="fas fa-star text-warning text-xs"></i> Rating
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trusted By Section -->
        <section class="py-8 border-b border-border bg-surface">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="flex flex-wrap items-center justify-center gap-8 md:gap-14 opacity-50">
                    <span class="text-muted text-sm font-medium uppercase tracking-widest">Trusted by</span>
                    <span class="text-xl font-bold text-muted">Traveloka</span>
                    <span class="text-xl font-bold text-muted">Agoda</span>
                    <span class="text-xl font-bold text-muted">Booking.com</span>
                    <span class="text-xl font-bold text-muted">Airbnb</span>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 md:py-24 bg-surface">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="text-center mb-14 scroll-animate">
                    <span class="inline-flex items-center gap-2 bg-primary-lighter text-primary text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                        <i class="fas fa-gem text-xs"></i> Why Choose Us
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-foreground">Experience the Best</h2>
                    <p class="text-lg text-muted max-w-xl mx-auto">Top-tier service and amenities designed for your comfort and peace of mind</p>
                    <div class="section-divider mt-6"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="feature-card scroll-animate">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-foreground">Secure Booking</h3>
                        <p class="text-sm text-muted leading-relaxed">Your payment and personal information are always protected with end-to-end encryption</p>
                    </div>
                    <div class="feature-card scroll-animate">
                        <div class="feature-icon">
                            <i class="fas fa-star text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-foreground">Premium Quality</h3>
                        <p class="text-sm text-muted leading-relaxed">Handpicked apartments with verified quality standards and regular inspections</p>
                    </div>
                    <div class="feature-card scroll-animate">
                        <div class="feature-icon">
                            <i class="fas fa-headset text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-foreground">24/7 Support</h3>
                        <p class="text-sm text-muted leading-relaxed">Our dedicated team is always ready to help you anytime, anywhere</p>
                    </div>
                    <div class="feature-card scroll-animate">
                        <div class="feature-icon">
                            <i class="fas fa-bolt text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-foreground">Instant Booking</h3>
                        <p class="text-sm text-muted leading-relaxed">Book your stay in just a few clicks — no waiting, instant confirmation</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Properties Section -->
        <section id="properties" class="py-20 md:py-24">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-14 scroll-animate">
                    <div>
                        <span class="inline-flex items-center gap-2 bg-primary-lighter text-primary text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                            <i class="fas fa-fire text-xs"></i> Popular
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-bold mb-2 text-foreground">Featured Properties</h2>
                        <p class="text-lg text-muted">Handpicked apartments just for you</p>
                    </div>
                    <a href="{{ route('rooms.index') }}" class="btn-secondary hidden md:inline-flex items-center gap-2 mt-4 md:mt-0">
                        View All Rooms <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Property Card 1 -->
                    <div class="card cursor-pointer scroll-animate group">
                        <div class="property-image rounded-t-2xl">
                            <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600&q=80&auto=format&fit=crop" alt="Modern Downtown Loft" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <span class="badge absolute top-4 left-4 z-10">
                                <i class="fas fa-fire mr-1 text-xs"></i>Popular
                            </span>
                            <button class="wishlist-btn absolute top-4 right-4 z-10 text-muted">
                                <i class="far fa-heart text-sm"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-foreground group-hover:text-primary transition">Modern Downtown Loft</h3>
                                <div class="flex items-center gap-1 bg-warning/10 px-2 py-0.5 rounded-lg">
                                    <i class="fas fa-star text-xs text-warning"></i>
                                    <span class="text-sm font-semibold text-foreground">4.9</span>
                                </div>
                            </div>
                            <p class="text-sm mb-4 text-muted flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-primary text-xs"></i>Jakarta, Indonesia
                            </p>
                            <div class="flex items-center gap-3 text-sm text-muted mb-4">
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-bed text-xs text-primary"></i>2 Beds
                                </span>
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-bath text-xs text-primary"></i>2 Baths
                                </span>
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-ruler-combined text-xs text-primary"></i>85m²
                                </span>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-border">
                                <div>
                                    <p class="text-2xl font-bold text-primary">$120</p>
                                    <p class="text-xs text-muted">per night</p>
                                </div>
                                <a href="{{ route('rooms.index') }}" class="btn-primary py-2.5 px-5 text-sm">
                                    Book Now <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 2 -->
                    <div class="card cursor-pointer scroll-animate group">
                        <div class="property-image rounded-t-2xl">
                            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80&auto=format&fit=crop" alt="Luxury Beach Suite" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <span class="badge absolute top-4 left-4 z-10 bg-warning text-white">
                                <i class="fas fa-crown mr-1 text-xs"></i>Premium
                            </span>
                            <button class="wishlist-btn absolute top-4 right-4 z-10 text-muted">
                                <i class="far fa-heart text-sm"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-foreground group-hover:text-primary transition">Luxury Beach Suite</h3>
                                <div class="flex items-center gap-1 bg-warning/10 px-2 py-0.5 rounded-lg">
                                    <i class="fas fa-star text-xs text-warning"></i>
                                    <span class="text-sm font-semibold text-foreground">5.0</span>
                                </div>
                            </div>
                            <p class="text-sm mb-4 text-muted flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-primary text-xs"></i>Bali, Indonesia
                            </p>
                            <div class="flex items-center gap-3 text-sm text-muted mb-4">
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-bed text-xs text-primary"></i>3 Beds
                                </span>
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-bath text-xs text-primary"></i>3 Baths
                                </span>
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-ruler-combined text-xs text-primary"></i>120m²
                                </span>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-border">
                                <div>
                                    <p class="text-2xl font-bold text-primary">$250</p>
                                    <p class="text-xs text-muted">per night</p>
                                </div>
                                <a href="{{ route('rooms.index') }}" class="btn-primary py-2.5 px-5 text-sm">
                                    Book Now <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 3 -->
                    <div class="card cursor-pointer scroll-animate group">
                        <div class="property-image rounded-t-2xl">
                            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600&q=80&auto=format&fit=crop" alt="Cozy Studio Apartment" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <span class="badge absolute top-4 left-4 z-10 bg-info text-white">
                                <i class="fas fa-bolt mr-1 text-xs"></i>New
                            </span>
                            <button class="wishlist-btn absolute top-4 right-4 z-10 text-muted">
                                <i class="far fa-heart text-sm"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-foreground group-hover:text-primary transition">Cozy Studio Apartment</h3>
                                <div class="flex items-center gap-1 bg-warning/10 px-2 py-0.5 rounded-lg">
                                    <i class="fas fa-star text-xs text-warning"></i>
                                    <span class="text-sm font-semibold text-foreground">4.8</span>
                                </div>
                            </div>
                            <p class="text-sm mb-4 text-muted flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-primary text-xs"></i>Bandung, Indonesia
                            </p>
                            <div class="flex items-center gap-3 text-sm text-muted mb-4">
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-bed text-xs text-primary"></i>1 Bed
                                </span>
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-bath text-xs text-primary"></i>1 Bath
                                </span>
                                <span class="flex items-center gap-1.5 bg-surface px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-ruler-combined text-xs text-primary"></i>45m²
                                </span>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-border">
                                <div>
                                    <p class="text-2xl font-bold text-primary">$80</p>
                                    <p class="text-xs text-muted">per night</p>
                                </div>
                                <a href="{{ route('rooms.index') }}" class="btn-primary py-2.5 px-5 text-sm">
                                    Book Now <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12 md:hidden">
                    <a href="{{ route('rooms.index') }}" class="btn-primary inline-flex items-center gap-2">
                        View All Rooms <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-20 md:py-24 bg-surface">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="text-center mb-14 scroll-animate">
                    <span class="inline-flex items-center gap-2 bg-primary-lighter text-primary text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                        <i class="fas fa-magic text-xs"></i> Simple & Easy
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-foreground">How It Works</h2>
                    <p class="text-lg text-muted max-w-xl mx-auto">Book your perfect apartment in just 3 easy steps</p>
                    <div class="section-divider mt-6"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="text-center scroll-animate relative">
                        <div class="w-16 h-16 rounded-2xl mx-auto mb-5 flex items-center justify-center bg-primary text-white text-xl font-bold shadow-lg">
                            1
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-foreground">Search</h3>
                        <p class="text-sm text-muted leading-relaxed">Browse our wide selection of premium apartments based on your preferences</p>
                        <!-- Connector line (desktop only) -->
                        <div class="hidden md:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-border"></div>
                    </div>
                    <div class="text-center scroll-animate relative">
                        <div class="w-16 h-16 rounded-2xl mx-auto mb-5 flex items-center justify-center bg-primary text-white text-xl font-bold shadow-lg">
                            2
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-foreground">Book</h3>
                        <p class="text-sm text-muted leading-relaxed">Select your dates, fill in your details, and confirm your booking instantly</p>
                        <div class="hidden md:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-border"></div>
                    </div>
                    <div class="text-center scroll-animate">
                        <div class="w-16 h-16 rounded-2xl mx-auto mb-5 flex items-center justify-center bg-primary text-white text-xl font-bold shadow-lg">
                            3
                        </div>
                        <h3 class="text-lg font-semibold mb-2 text-foreground">Enjoy</h3>
                        <p class="text-sm text-muted leading-relaxed">Check in and enjoy your stay in a comfortable, well-furnished apartment</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-20 md:py-24">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="text-center mb-14 scroll-animate">
                    <span class="inline-flex items-center gap-2 bg-primary-lighter text-primary text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                        <i class="fas fa-heart text-xs"></i> Testimonials
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-foreground">What Our Guests Say</h2>
                    <p class="text-lg text-muted max-w-xl mx-auto">Real experiences from real guests</p>
                    <div class="section-divider mt-6"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    <div class="testimonial-card scroll-animate">
                        <div class="flex items-center gap-1 mb-4">
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                        </div>
                        <p class="text-sm text-muted leading-relaxed mb-5">"Amazing experience! The apartment was exactly as described. Clean, modern, and the location was perfect. Will definitely book again."</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-lighter flex items-center justify-center">
                                <span class="text-primary font-bold text-sm">AS</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Andi Setiawan</p>
                                <p class="text-xs text-muted">Jakarta</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card scroll-animate">
                        <div class="flex items-center gap-1 mb-4">
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                        </div>
                        <p class="text-sm text-muted leading-relaxed mb-5">"Best booking platform I've used. The process was so smooth and the customer support was incredibly helpful. Highly recommend!"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-lighter flex items-center justify-center">
                                <span class="text-primary font-bold text-sm">SW</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Sarah Wijaya</p>
                                <p class="text-xs text-muted">Bandung</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card scroll-animate">
                        <div class="flex items-center gap-1 mb-4">
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star text-warning text-sm"></i>
                            <i class="fas fa-star-half-alt text-warning text-sm"></i>
                        </div>
                        <p class="text-sm text-muted leading-relaxed mb-5">"Stayed for a whole month and it felt like home. Great amenities, beautiful views, and wonderful neighborhood. Perfect for remote workers!"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-lighter flex items-center justify-center">
                                <span class="text-primary font-bold text-sm">BR</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Budi Raharjo</p>
                                <p class="text-xs text-muted">Bali</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="contact" class="py-24 hero-gradient relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute top-10 right-10 w-24 h-24 rounded-full bg-white/5 animate-float"></div>
            <div class="absolute bottom-10 left-10 w-16 h-16 rounded-full bg-white/5 animate-float delay-300"></div>

            <div class="container mx-auto px-4 md:px-8 lg:px-12 text-center relative z-10">
                <div class="scroll-animate">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-5">Ready to Find Your<br>Perfect Stay?</h2>
                    <p class="text-lg md:text-xl text-white/85 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Join thousands of satisfied guests who found their ideal apartment through our platform
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300 text-primary hover:-translate-y-1">
                                <i class="fas fa-rocket"></i> Get Started Now
                            </a>
                        @endif
                        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/30 px-8 py-4 rounded-xl font-semibold text-lg text-white transition-all duration-300 hover:bg-white/25 hover:-translate-y-1">
                            <i class="fas fa-search"></i> Browse Rooms
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-16 border-t border-border bg-surface">
            <div class="container mx-auto px-4 md:px-8 lg:px-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                    <div>
                        <a href="{{ url('/') }}" class="flex items-center gap-2.5 mb-5 group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-primary transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <span class="text-lg font-bold text-foreground">Apartment<span class="text-primary">Hub</span></span>
                        </a>
                        <p class="text-sm text-muted leading-relaxed mb-5">
                            Your trusted platform for finding and booking premium apartments worldwide.
                        </p>
                        <!-- Social Links -->
                        <div class="flex gap-2.5">
                            <a href="#" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 bg-primary-lighter text-primary" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 bg-primary-lighter text-primary" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 bg-primary-lighter text-primary" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 bg-primary-lighter text-primary" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-5 text-foreground">Company</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>About Us</a></li>
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>Careers</a></li>
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>Press</a></li>
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>Blog</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-5 text-foreground">Support</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>Help Center</a></li>
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>Safety</a></li>
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>Cancellation</a></li>
                            <li><a href="#" class="text-muted hover:text-primary transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary/40"></i>Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-5 text-foreground">Newsletter</h4>
                        <p class="text-sm text-muted mb-4">Subscribe to get special offers and updates.</p>
                        <div class="flex gap-2">
                            <input type="email" placeholder="Your email" class="form-input text-sm flex-1 py-2.5">
                            <button class="btn-primary py-2.5 px-4 text-sm">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="border-t border-border pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-muted">
                    <p>&copy; {{ date('Y') }} ApartmentHub. All rights reserved.</p>
                    <div class="flex items-center gap-6">
                        <a href="#" class="hover:text-primary transition-colors duration-200">Privacy Policy</a>
                        <a href="#" class="hover:text-primary transition-colors duration-200">Terms of Service</a>
                        <a href="#" class="hover:text-primary transition-colors duration-200">Cookies</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Back to Top Button -->
        <button id="back-to-top" class="back-to-top" aria-label="Back to top">
            <i class="fas fa-chevron-up"></i>
        </button>

        <script>
            // ---- Dark Mode Toggle ----
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const html = document.documentElement;

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

            // ---- Mobile Menu ----
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileClose = document.getElementById('mobile-close');
            const mobileLinks = document.querySelectorAll('.mobile-link');

            function openMobileMenu() {
                mobileMenu.classList.add('active');
                mobileToggle.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                mobileMenu.classList.remove('active');
                mobileToggle.classList.remove('active');
                document.body.style.overflow = '';
            }

            mobileToggle.addEventListener('click', openMobileMenu);
            mobileClose.addEventListener('click', closeMobileMenu);
            mobileMenu.addEventListener('click', (e) => {
                if (e.target === mobileMenu) closeMobileMenu();
            });
            mobileLinks.forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });

            // ---- Navbar Scroll Effect ----
            const navbar = document.getElementById('main-navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // ---- Back to Top ----
            const backToTop = document.getElementById('back-to-top');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 400) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            });
            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // ---- Scroll Animations (Intersection Observer) ----
            const scrollElements = document.querySelectorAll('.scroll-animate');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        // Stagger the animations
                        setTimeout(() => {
                            entry.target.classList.add('visible');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            scrollElements.forEach(el => observer.observe(el));

            // ---- Wishlist Heart Toggle ----
            document.querySelectorAll('.wishlist-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const icon = btn.querySelector('i');
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        btn.style.backgroundColor = 'var(--color-error)';
                        btn.style.color = '#fff';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        btn.style.backgroundColor = 'rgba(255,255,255,0.8)';
                        btn.style.color = '';
                    }
                });
            });

            // ---- Smooth scroll for anchor links ----
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // ---- Hero Background Slideshow ----
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');
            let currentSlide = 0;
            let slideInterval;

            function goToSlide(index) {
                // Remove active from all
                slides.forEach(s => s.classList.remove('active'));
                dots.forEach(d => d.classList.remove('active'));
                
                // Set active
                currentSlide = index;
                slides[currentSlide].classList.add('active');
                dots[currentSlide].classList.add('active');
            }

            function nextSlide() {
                const next = (currentSlide + 1) % slides.length;
                goToSlide(next);
            }

            function startSlideshow() {
                slideInterval = setInterval(nextSlide, 5000);
            }

            function stopSlideshow() {
                clearInterval(slideInterval);
            }

            // Click on dots
            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const slideIndex = parseInt(dot.getAttribute('data-slide'));
                    goToSlide(slideIndex);
                    stopSlideshow();
                    startSlideshow();
                });
            });

            // Pause on hover
            const heroSection = document.getElementById('hero-section');
            if (heroSection) {
                heroSection.addEventListener('mouseenter', stopSlideshow);
                heroSection.addEventListener('mouseleave', startSlideshow);
            }

            // Start auto slideshow
            startSlideshow();
        </script>
    </body>
</html>