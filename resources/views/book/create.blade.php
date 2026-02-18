<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Book your perfect apartment stay at ApartmentHub.">
    <title>Pesan Kamar - {{ config('app.name', 'ApartmentHub') }}</title>
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('rooms.index') }}" class="btn-secondary py-2 px-4 text-sm inline-flex items-center gap-2">
                        <i class="fas fa-arrow-left text-xs"></i> Kembali
                    </a>
                    <button id="theme-toggle" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 bg-surface text-foreground border border-border" aria-label="Toggle dark mode">
                        <i class="fas fa-moon" id="theme-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="relative overflow-hidden py-12 md:py-14">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1920&q=80&auto=format&fit=crop" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.55), rgba(0,0,0,0.45));"></div>
        </div>
        <div class="container mx-auto px-4 md:px-8 lg:px-12 relative z-10">
            <nav class="flex items-center gap-2 text-sm text-white/70 mb-4">
                <a href="{{ url('/') }}" class="hover:text-white transition"><i class="fas fa-home mr-1"></i>Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('rooms.index') }}" class="hover:text-white transition">Rooms</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white font-medium">Booking</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-lg">Pesan Kamar</h1>
            <p class="text-white/80 mt-2">Isi data diri Anda untuk menyelesaikan pemesanan. Tidak perlu login.</p>
        </div>
    </section>

    <main class="container mx-auto px-4 md:px-8 lg:px-12 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">

            <!-- Left: Booking Form -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Progress Steps -->
                <div class="flex items-center gap-2 mb-2" id="booking-steps">
                    <div class="flex items-center gap-2 step-item active" data-step="1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-primary text-white transition-all">1</div>
                        <span class="text-sm font-medium text-foreground hidden sm:inline">Data Tamu</span>
                    </div>
                    <div class="flex-1 h-0.5 rounded-full bg-border mx-1"></div>
                    <div class="flex items-center gap-2 step-item" data-step="2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-surface border border-border text-muted transition-all">2</div>
                        <span class="text-sm font-medium text-muted hidden sm:inline">Tanggal</span>
                    </div>
                    <div class="flex-1 h-0.5 rounded-full bg-border mx-1"></div>
                    <div class="flex items-center gap-2 step-item" data-step="3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-surface border border-border text-muted transition-all">3</div>
                        <span class="text-sm font-medium text-muted hidden sm:inline">Pembayaran</span>
                    </div>
                </div>

                <form action="{{ route('book.store') }}" method="post" id="booking-form">
                    @csrf
                    <input type="hidden" name="unit_id" value="{{ $unit->id }}">

                    <!-- Section 1: Data Tamu -->
                    <div class="rounded-2xl border border-border bg-surface p-6 md:p-8 space-y-5" id="section-guest">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-primary-lighter flex items-center justify-center">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-foreground text-lg">Data Tamu</h3>
                                <p class="text-xs text-muted">Informasi pemesan kamar</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label for="guest_name" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-user-circle mr-1.5 text-primary text-xs"></i>Nama Lengkap <span class="text-error">*</span>
                                </label>
                                <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required placeholder="Masukkan nama lengkap" class="form-input">
                                @error('guest_name') <p class="text-error text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="guest_email" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-envelope mr-1.5 text-primary text-xs"></i>Email <span class="text-error">*</span>
                                </label>
                                <input type="email" name="guest_email" id="guest_email" value="{{ old('guest_email') }}" required placeholder="email@contoh.com" class="form-input">
                                @error('guest_email') <p class="text-error text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="guest_phone" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-phone mr-1.5 text-primary text-xs"></i>No. Telepon <span class="text-error">*</span>
                                </label>
                                <input type="text" name="guest_phone" id="guest_phone" value="{{ old('guest_phone') }}" required placeholder="08xx xxxx xxxx" class="form-input">
                                @error('guest_phone') <p class="text-error text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="guest_id_type" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-id-card mr-1.5 text-primary text-xs"></i>Tipe Identitas
                                </label>
                                <select name="guest_id_type" id="guest_id_type" class="form-input">
                                    <option value="">– Pilih –</option>
                                    <option value="KTP" {{ old('guest_id_type') === 'KTP' ? 'selected' : '' }}>KTP</option>
                                    <option value="Passport" {{ old('guest_id_type') === 'Passport' ? 'selected' : '' }}>Passport</option>
                                </select>
                            </div>
                            <div>
                                <label for="guest_id_number" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-hashtag mr-1.5 text-primary text-xs"></i>No. Identitas
                                </label>
                                <input type="text" name="guest_id_number" id="guest_id_number" value="{{ old('guest_id_number') }}" placeholder="Nomor identitas" class="form-input">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="guest_address" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-map-marker-alt mr-1.5 text-primary text-xs"></i>Alamat
                                </label>
                                <textarea name="guest_address" id="guest_address" rows="2" placeholder="Alamat lengkap (opsional)" class="form-input">{{ old('guest_address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Tanggal Menginap -->
                    <div class="rounded-2xl border border-border bg-surface p-6 md:p-8 space-y-5 mt-6" id="section-dates">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-primary-lighter flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-foreground text-lg">Tanggal Menginap</h3>
                                <p class="text-xs text-muted">Pilih tanggal check-in dan check-out</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="check_in_date" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-sign-in-alt mr-1.5 text-primary text-xs"></i>Check-in <span class="text-error">*</span>
                                </label>
                                <input type="date" name="check_in_date" id="check_in_date" value="{{ old('check_in_date') }}" required class="form-input">
                                @error('check_in_date') <p class="text-error text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="check_out_date" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-sign-out-alt mr-1.5 text-primary text-xs"></i>Check-out <span class="text-error">*</span>
                                </label>
                                <input type="date" name="check_out_date" id="check_out_date" value="{{ old('check_out_date') }}" required class="form-input">
                                @error('check_out_date') <p class="text-error text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="number_of_guests" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-users mr-1.5 text-primary text-xs"></i>Jumlah Tamu
                                </label>
                                <input type="number" name="number_of_guests" id="number_of_guests" value="{{ old('number_of_guests', 1) }}" min="1" class="form-input">
                            </div>
                        </div>

                        <!-- Duration display -->
                        <div class="bg-primary-lighter/50 rounded-xl p-4 flex items-center gap-3" id="duration-info" style="display: none;">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                <i class="fas fa-moon text-primary"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Durasi menginap: <span id="duration-nights" class="text-primary">0</span> malam</p>
                                <p class="text-xs text-muted" id="duration-dates"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Pembayaran & Promo -->
                    <div class="rounded-2xl border border-border bg-surface p-6 md:p-8 space-y-5 mt-6" id="section-payment">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-primary-lighter flex items-center justify-center">
                                <i class="fas fa-credit-card text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-foreground text-lg">Pembayaran & Promo</h3>
                                <p class="text-xs text-muted">Pilih metode pembayaran dan kode promo</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="payment_type_id" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-wallet mr-1.5 text-primary text-xs"></i>Cara Bayar
                                </label>
                                <select name="payment_type_id" id="payment_type_id" class="form-input">
                                    <option value="">– Pilih nanti –</option>
                                    @foreach($paymentTypes as $pt)
                                        <option value="{{ $pt->id }}" {{ old('payment_type_id') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="promo_id" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-tag mr-1.5 text-primary text-xs"></i>Kode Promo
                                </label>
                                <select name="promo_id" id="promo_id" class="form-input">
                                    <option value="">– Tidak ada –</option>
                                    @foreach($promos as $p)
                                        <option value="{{ $p->id }}" {{ old('promo_id') == $p->id ? 'selected' : '' }}>{{ $p->code }} – {{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="special_requests" class="block text-sm font-semibold text-foreground mb-1.5">
                                    <i class="fas fa-comment mr-1.5 text-primary text-xs"></i>Request Khusus
                                </label>
                                <textarea name="special_requests" id="special_requests" rows="3" placeholder="Contoh: extra bantal, early check-in, dll." class="form-input">{{ old('special_requests') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-8">
                        <button type="submit" class="btn-primary flex-1 py-4 text-base flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i> Kirim Pemesanan
                        </button>
                        <a href="{{ route('rooms.index') }}" class="btn-secondary py-4 px-8 text-base text-center flex items-center justify-center gap-2">
                            <i class="fas fa-times text-xs"></i> Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Right: Room Summary Sidebar (sticky) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <!-- Room Preview Card -->
                    <div class="rounded-2xl border border-border bg-surface overflow-hidden">
                        <!-- Room Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&q=80&auto=format&fit=crop" alt="{{ $unit->unit_number }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <div class="absolute bottom-3 left-4 z-10">
                                <h3 class="text-white font-bold text-lg drop-shadow">{{ $unit->unit_number }}</h3>
                            </div>
                            @if($unit->rental_status === 'vacant')
                                <span class="badge absolute top-3 right-3 z-10">
                                    <i class="fas fa-check-circle mr-1 text-xs"></i>Available
                                </span>
                            @endif
                        </div>

                        <!-- Room Details -->
                        <div class="p-5 space-y-4">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex items-center gap-2 bg-background px-3 py-2 rounded-xl">
                                    <div class="w-7 h-7 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-home text-primary text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-muted">Type</p>
                                        <p class="font-semibold text-foreground text-xs">{{ $unit->unitType?->name ?? '–' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 bg-background px-3 py-2 rounded-xl">
                                    <div class="w-7 h-7 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-mountain-sun text-primary text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-muted">View</p>
                                        <p class="font-semibold text-foreground text-xs">{{ $unit->unitView?->name ?? '–' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 bg-background px-3 py-2 rounded-xl">
                                    <div class="w-7 h-7 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-couch text-primary text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-muted">Interior</p>
                                        <p class="font-semibold text-foreground text-xs">{{ $unit->interiorType?->name ?? '–' }}</p>
                                    </div>
                                </div>
                                @if($unit->building_tower)
                                <div class="flex items-center gap-2 bg-background px-3 py-2 rounded-xl">
                                    <div class="w-7 h-7 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-building text-primary text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-muted">Tower</p>
                                        <p class="font-semibold text-foreground text-xs">{{ $unit->building_tower }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($unit->from_price)
                                <div class="border-t border-border pt-4">
                                    <p class="text-xs text-muted mb-1">Harga mulai dari</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-bold text-primary">Rp {{ number_format($unit->from_price, 0, ',', '.') }}</span>
                                        <span class="text-sm text-muted">/malam</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="rounded-2xl border border-border bg-surface p-5 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shield-alt text-primary text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Pembayaran Aman</p>
                                <p class="text-xs text-muted">Data Anda terenkripsi & terlindungi</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-headset text-primary text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Support 24/7</p>
                                <p class="text-xs text-muted">Tim kami siap membantu Anda</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-lighter flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-undo text-primary text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Pembatalan Mudah</p>
                                <p class="text-xs text-muted">Fleksibel sesuai kebijakan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Need Help -->
                    <div class="rounded-2xl border border-dashed border-border p-5 text-center">
                        <i class="fas fa-question-circle text-2xl text-primary mb-2"></i>
                        <p class="text-sm font-semibold text-foreground mb-1">Butuh Bantuan?</p>
                        <p class="text-xs text-muted mb-3">Hubungi kami untuk pertanyaan seputar pemesanan</p>
                        <a href="{{ url('/') }}#contact" class="btn-secondary py-2 px-4 text-xs inline-flex items-center gap-1.5">
                            <i class="fas fa-comment-dots"></i> Hubungi Kami
                        </a>
                    </div>
                </div>
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
        updateThemeIcon(currentTheme);

        themeToggle.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            themeIcon.classList.toggle('fa-moon', theme !== 'dark');
            themeIcon.classList.toggle('fa-sun', theme === 'dark');
        }

        // ---- Navbar scroll ----
        const navbar = document.getElementById('main-navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ---- Duration calculator ----
        const checkIn = document.getElementById('check_in_date');
        const checkOut = document.getElementById('check_out_date');
        const durationInfo = document.getElementById('duration-info');
        const durationNights = document.getElementById('duration-nights');
        const durationDates = document.getElementById('duration-dates');

        function calcDuration() {
            if (checkIn.value && checkOut.value) {
                const start = new Date(checkIn.value);
                const end = new Date(checkOut.value);
                const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                if (diff > 0) {
                    durationNights.textContent = diff;
                    durationDates.textContent = start.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) + ' → ' + end.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    durationInfo.style.display = 'flex';
                } else {
                    durationInfo.style.display = 'none';
                }
            } else {
                durationInfo.style.display = 'none';
            }
        }

        checkIn.addEventListener('change', calcDuration);
        checkOut.addEventListener('change', calcDuration);
        // Run on load in case old values exist
        calcDuration();

        // ---- Focus highlight on sections ----
        const sections = document.querySelectorAll('#section-guest, #section-dates, #section-payment');
        sections.forEach(section => {
            const inputs = section.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    sections.forEach(s => s.style.borderColor = '');
                    section.style.borderColor = 'var(--color-primary)';
                });
                input.addEventListener('blur', () => {
                    section.style.borderColor = '';
                });
            });
        });
    </script>
</body>
</html>
