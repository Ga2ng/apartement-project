<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pemesanan berhasil dikirim. Terima kasih telah memilih ApartmentHub.">
    <title>Pemesanan Berhasil - {{ config('app.name', 'ApartmentHub') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes checkmarkDraw {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
        }
        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes confettiFall {
            0% { transform: translateY(-10px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(60px) rotate(360deg); opacity: 0; }
        }
        .success-icon { animation: scaleIn 0.6s ease-out forwards; }
        .success-check { stroke-dasharray: 100; animation: checkmarkDraw 0.8s ease-out 0.4s forwards; stroke-dashoffset: 100; }
        .confetti { animation: confettiFall 2s ease-out forwards; }
    </style>
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('rooms.index') }}" class="btn-secondary py-2 px-4 text-sm inline-flex items-center gap-2">
                        <i class="fas fa-door-open text-xs"></i> Lihat Kamar
                    </a>
                    <button id="theme-toggle" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 bg-surface text-foreground border border-border" aria-label="Toggle dark mode">
                        <i class="fas fa-moon" id="theme-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-8 lg:px-12 py-12 md:py-16">
        <div class="max-w-2xl mx-auto">
            <!-- Success Animation -->
            <div class="text-center mb-10 relative">
                <!-- Confetti particles -->
                <div class="absolute inset-x-0 top-0 flex justify-center gap-4 pointer-events-none">
                    <div class="w-2 h-2 rounded-full bg-primary confetti" style="animation-delay: 0.2s; margin-left: -40px;"></div>
                    <div class="w-2 h-2 rounded-full bg-warning confetti" style="animation-delay: 0.4s; margin-left: 20px;"></div>
                    <div class="w-2 h-2 rounded-full bg-info confetti" style="animation-delay: 0.3s; margin-left: -20px;"></div>
                    <div class="w-2 h-2 rounded-full bg-success confetti" style="animation-delay: 0.5s; margin-left: 40px;"></div>
                    <div class="w-2 h-2 rounded-full bg-primary confetti" style="animation-delay: 0.6s; margin-left: 0;"></div>
                </div>

                <!-- Checkmark icon -->
                <div class="success-icon w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-6 relative">
                    <div class="w-20 h-20 rounded-full bg-primary/20 flex items-center justify-center">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <path class="success-check" d="M10 20L17 27L30 13" stroke="var(--color-primary)" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-3 animate-fade-in-up">Pemesanan Berhasil! 🎉</h1>
                <p class="text-muted text-lg max-w-md mx-auto animate-fade-in-up delay-200">Terima kasih. Data Anda telah kami terima dan sedang diproses.</p>
            </div>

            <!-- Booking Details Card -->
            <div class="rounded-2xl border border-border bg-surface overflow-hidden mb-8 animate-fade-in-up delay-300">
                <!-- Card Header -->
                <div class="bg-primary/5 px-6 py-4 border-b border-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-lighter flex items-center justify-center">
                            <i class="fas fa-receipt text-primary"></i>
                        </div>
                        <div>
                            <p class="text-xs text-muted">No. Pemesanan</p>
                            <p class="text-lg font-bold text-primary tracking-wider">{{ $booking->booking_number }}</p>
                        </div>
                    </div>
                    <span class="badge">
                        <i class="fas fa-clock mr-1 text-xs"></i>Menunggu Pembayaran
                    </span>
                </div>

                <!-- Card Body -->
                <div class="p-6 space-y-4">
                    <!-- Room Info -->
                    <div class="flex items-center gap-4 bg-background rounded-xl p-4">
                        <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=200&q=80&auto=format&fit=crop" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-bold text-foreground">{{ $booking->unit?->unit_number }}</h3>
                            <p class="text-sm text-muted">{{ $booking->unit?->unitType?->name ?? '–' }}</p>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="flex items-center gap-3 bg-background rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-sign-in-alt text-primary text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-muted uppercase tracking-wider font-medium">Check-in</p>
                                <p class="font-semibold text-foreground text-sm">{{ $booking->check_in_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-background rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-sign-out-alt text-primary text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-muted uppercase tracking-wider font-medium">Check-out</p>
                                <p class="font-semibold text-foreground text-sm">{{ $booking->check_out_date->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-border pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-muted font-medium">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-primary">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Notice -->
            <div class="rounded-2xl border border-border bg-surface p-5 mb-8 flex items-start gap-4 animate-fade-in-up delay-400">
                <div class="w-10 h-10 rounded-xl bg-info/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i class="fas fa-envelope text-info"></i>
                </div>
                <div>
                    <p class="font-semibold text-foreground mb-1">Instruksi dikirim ke email</p>
                    <p class="text-sm text-muted">
                        Konfirmasi dan cara pembayaran akan dikirim ke <strong class="text-foreground">{{ $booking->guest_email }}</strong>. 
                        Silakan cek inbox dan folder spam Anda.
                    </p>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="rounded-2xl border border-border bg-surface p-6 mb-8 animate-fade-in-up delay-400">
                <h3 class="font-bold text-foreground mb-4 flex items-center gap-2">
                    <i class="fas fa-list-ol text-primary"></i> Langkah Selanjutnya
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">1</div>
                        <div>
                            <p class="font-medium text-foreground text-sm">Cek email Anda</p>
                            <p class="text-xs text-muted">Kami mengirimkan detail pemesanan dan instruksi pembayaran</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">2</div>
                        <div>
                            <p class="font-medium text-foreground text-sm">Selesaikan pembayaran</p>
                            <p class="text-xs text-muted">Lakukan pembayaran sesuai instruksi yang diberikan</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">3</div>
                        <div>
                            <p class="font-medium text-foreground text-sm">Siap check-in!</p>
                            <p class="text-xs text-muted">Setelah pembayaran terkonfirmasi, Anda siap untuk menginap</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 animate-fade-in-up delay-500">
                <a href="{{ route('rooms.index') }}" class="btn-primary flex-1 py-4 text-center flex items-center justify-center gap-2 text-base">
                    <i class="fas fa-door-open"></i> Lihat Kamar Lain
                </a>
                <a href="{{ url('/') }}" class="btn-secondary flex-1 py-4 text-center flex items-center justify-center gap-2 text-base">
                    <i class="fas fa-home text-xs"></i> Ke Beranda
                </a>
            </div>
        </div>
    </main>

    <script>
        // ---- Dark Mode ----
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        const currentTheme = localStorage.getItem('theme') || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        html.setAttribute('data-theme', currentTheme);

        themeToggle.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            themeIcon.classList.toggle('fa-moon', newTheme !== 'dark');
            themeIcon.classList.toggle('fa-sun', newTheme === 'dark');
        });

        if (currentTheme === 'dark') {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }

        // ---- Navbar scroll ----
        const navbar = document.getElementById('main-navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });
    </script>
</body>
</html>
