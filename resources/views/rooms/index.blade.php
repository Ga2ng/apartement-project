<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Browse available rooms and apartments at ApartmentHub. Find your ideal stay today.">
    <title>Rooms - {{ config('app.name', 'ApartmentHub') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-foreground min-h-screen">
    <!-- Navbar -->
    <nav class="navbar" id="main-navbar">
        <div class="container mx-auto px-4 md:px-8 lg:px-12">
            <div class="flex items-center justify-between h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-primary transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-foreground">Apartment<span class="text-primary">Hub</span></span>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="nav-link hidden sm:inline">Home</a>
                    <a href="{{ route('rooms.index') }}" class="nav-link active hidden sm:inline">Rooms</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-secondary py-2 px-4 text-sm">
                            <i class="fas fa-th-large mr-1 text-xs"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary py-2 px-4 text-sm">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary py-2 px-4 text-sm">Get Started</a>
                        @endif
                    @endauth

                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 bg-surface text-foreground border border-border" aria-label="Toggle dark mode">
                        <i class="fas fa-moon" id="theme-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header with Background Image -->
    <section class="relative overflow-hidden py-16 md:py-20">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1920&q=80&auto=format&fit=crop" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.4) 100%);"></div>
        </div>

        <div class="container mx-auto px-4 md:px-8 lg:px-12 relative z-10">
            <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6">
                <div>
                    <nav class="flex items-center gap-2 text-sm text-white/70 mb-4">
                        <a href="{{ url('/') }}" class="hover:text-white transition"><i class="fas fa-home mr-1"></i>Home</a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-white font-medium">Rooms</span>
                    </nav>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 drop-shadow-lg">Our Rooms</h1>
                    <p class="text-white/85 text-lg max-w-lg">Temukan unit terbaik untuk Anda. Pesan langsung tanpa perlu login.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/15 backdrop-blur-md px-5 py-3 rounded-xl border border-white/20 text-white">
                        <div class="text-2xl font-bold">{{ isset($units) ? $units->count() : 0 }}</div>
                        <div class="text-xs text-white/70">Units Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="container mx-auto px-4 md:px-8 lg:px-12 py-10">
        <!-- Filter / Sort Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8 scroll-animate">
            <p class="text-muted text-sm">
                Menampilkan <span class="text-foreground font-semibold">{{ isset($units) ? $units->count() : 0 }}</span> unit tersedia
            </p>
            <div class="flex items-center gap-2">
                <span class="text-sm text-muted mr-1">View:</span>
                <button id="view-grid" class="w-9 h-9 rounded-lg flex items-center justify-center bg-primary text-white transition" aria-label="Grid view">
                    <i class="fas fa-th text-sm"></i>
                </button>
                <button id="view-list" class="w-9 h-9 rounded-lg flex items-center justify-center bg-surface border border-border text-muted hover:text-foreground transition" aria-label="List view">
                    <i class="fas fa-list text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Room Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7" id="rooms-grid">
            @php
                // Array of Unsplash room images to cycle through
                $roomImages = [
                    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&q=80&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600&q=80&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600&q=80&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&q=80&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=600&q=80&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=600&q=80&auto=format&fit=crop',
                ];
            @endphp

            @forelse($units as $index => $unit)
                <div class="room-card group scroll-animate">
                    <!-- Image -->
                    <div class="room-card-image relative">
                        <img 
                            src="{{ $roomImages[$index % count($roomImages)] }}" 
                            alt="Room {{ $unit->unit_number }}" 
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            loading="lazy"
                        >
                        <!-- Gradient overlay on image -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent z-[1]"></div>

                        <!-- Status Badge -->
                        @if($unit->rental_status === 'vacant')
                            <span class="badge absolute top-3 left-3 z-10">
                                <i class="fas fa-check-circle mr-1 text-xs"></i>Available
                            </span>
                        @elseif($unit->rental_status === 'monthly')
                            <span class="badge absolute top-3 left-3 z-10 bg-info text-white">
                                <i class="fas fa-calendar mr-1 text-xs"></i>Monthly
                            </span>
                        @else
                            <span class="badge absolute top-3 left-3 z-10 bg-surface-elevated text-muted">
                                {{ ucfirst($unit->rental_status) }}
                            </span>
                        @endif

                        <!-- Price on image -->
                        @if($unit->from_price)
                            <div class="absolute bottom-3 right-3 z-10 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm">
                                <span class="text-sm font-bold text-primary">Rp {{ number_format($unit->from_price, 0, ',', '.') }}</span>
                                <span class="text-xs text-muted">/night</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col">
                        <!-- Title -->
                        <h2 class="text-lg font-bold text-foreground mb-3 group-hover:text-primary transition">
                            {{ $unit->unit_number }}
                        </h2>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-2 text-sm mb-4 flex-1">
                            <div class="flex items-center gap-2.5 bg-surface px-3 py-2.5 rounded-xl transition hover:shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-home text-primary text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-muted uppercase tracking-wider font-medium">Type</p>
                                    <p class="font-semibold text-foreground text-xs">{{ $unit->unitType?->name ?? '–' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 bg-surface px-3 py-2.5 rounded-xl transition hover:shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-mountain-sun text-primary text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-muted uppercase tracking-wider font-medium">View</p>
                                    <p class="font-semibold text-foreground text-xs">{{ $unit->unitView?->name ?? '–' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 bg-surface px-3 py-2.5 rounded-xl transition hover:shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-couch text-primary text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-muted uppercase tracking-wider font-medium">Interior</p>
                                    <p class="font-semibold text-foreground text-xs">{{ $unit->interiorType?->name ?? '–' }}</p>
                                </div>
                            </div>
                            @if($unit->building_tower)
                                <div class="flex items-center gap-2.5 bg-surface px-3 py-2.5 rounded-xl transition hover:shadow-sm">
                                    <div class="w-8 h-8 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-building text-primary text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-muted uppercase tracking-wider font-medium">Tower / Floor</p>
                                        <p class="font-semibold text-foreground text-xs">{{ $unit->building_tower }} / {{ $unit->floor_level ?? '–' }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-auto pt-4 border-t border-border flex gap-2">
                            <a href="{{ route('book.create', ['unit_id' => $unit->id]) }}" class="btn-primary flex-1 text-center py-2.5 text-sm flex items-center justify-center gap-2">
                                <i class="fas fa-calendar-check text-xs"></i> Pesan Sekarang
                            </a>
                            <a href="{{ url('/') }}#contact" class="btn-secondary py-2.5 px-4 text-sm flex items-center gap-1 tooltip" data-tooltip="Hubungi Kami">
                                <i class="fas fa-comment-dots"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-24 px-6 rounded-2xl border-2 border-dashed border-border">
                        <div class="w-24 h-24 rounded-2xl mx-auto mb-6 flex items-center justify-center bg-primary-lighter animate-float">
                            <i class="fas fa-door-open text-4xl text-primary"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-foreground mb-3">Belum Ada Kamar Tersedia</h3>
                        <p class="text-muted mb-8 max-w-md mx-auto">Saat ini belum ada unit yang tersedia. Silakan periksa kembali nanti atau hubungi kami untuk informasi lebih lanjut.</p>
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ url('/') }}" class="btn-secondary inline-flex items-center gap-2">
                                <i class="fas fa-arrow-left text-xs"></i> Kembali
                            </a>
                            <a href="{{ url('/') }}#contact" class="btn-primary inline-flex items-center gap-2">
                                <i class="fas fa-envelope"></i> Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-border bg-surface mt-12 py-10">
        <div class="container mx-auto px-4 md:px-8 lg:px-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-primary transition-transform group-hover:scale-110">
                        <i class="fas fa-building text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-bold text-foreground">Apartment<span class="text-primary">Hub</span></span>
                </a>
                <div class="flex items-center gap-6 text-sm text-muted">
                    <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                    <a href="{{ url('/') }}#features" class="hover:text-primary transition-colors">Features</a>
                    <a href="{{ url('/') }}#contact" class="hover:text-primary transition-colors">Contact</a>
                </div>
                <p class="text-sm text-muted">&copy; {{ date('Y') }} ApartmentHub.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="back-to-top" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // ---- Dark Mode ----
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

        // ---- Navbar scroll ----
        const navbar = document.getElementById('main-navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ---- Back to Top ----
        const backToTop = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('visible', window.scrollY > 400);
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ---- View Toggle (Grid / List) ----
        const gridBtn = document.getElementById('view-grid');
        const listBtn = document.getElementById('view-list');
        const roomsGrid = document.getElementById('rooms-grid');

        if (gridBtn && listBtn && roomsGrid) {
            gridBtn.addEventListener('click', () => {
                roomsGrid.classList.remove('grid-cols-1', '!grid-cols-1');
                roomsGrid.classList.add('md:grid-cols-2', 'lg:grid-cols-3');
                gridBtn.classList.add('bg-primary', 'text-white');
                gridBtn.classList.remove('bg-surface', 'text-muted', 'border', 'border-border');
                listBtn.classList.remove('bg-primary', 'text-white');
                listBtn.classList.add('bg-surface', 'text-muted', 'border', 'border-border');
                // Reset card image heights
                document.querySelectorAll('.room-card-image').forEach(img => {
                    img.style.height = '';
                    img.style.width = '';
                });
                document.querySelectorAll('.room-card').forEach(card => {
                    card.classList.remove('md:flex-row');
                });
            });

            listBtn.addEventListener('click', () => {
                roomsGrid.classList.remove('md:grid-cols-2', 'lg:grid-cols-3');
                roomsGrid.classList.add('!grid-cols-1');
                listBtn.classList.add('bg-primary', 'text-white');
                listBtn.classList.remove('bg-surface', 'text-muted', 'border', 'border-border');
                gridBtn.classList.remove('bg-primary', 'text-white');
                gridBtn.classList.add('bg-surface', 'text-muted', 'border', 'border-border');
                // Adjust cards for list view
                document.querySelectorAll('.room-card').forEach(card => {
                    card.classList.add('md:flex-row');
                });
                document.querySelectorAll('.room-card-image').forEach(img => {
                    img.style.width = '280px';
                    img.style.minHeight = '100%';
                    img.style.height = 'auto';
                });
            });
        }

        // ---- Scroll animations ----
        const scrollEls = document.querySelectorAll('.scroll-animate');
        const obs = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
        scrollEls.forEach(el => obs.observe(el));
    </script>
</body>
</html>
