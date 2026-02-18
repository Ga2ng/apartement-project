<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemesanan Berhasil - {{ config('app.name', 'ApartmentHub') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-foreground min-h-screen">
    <nav class="sticky top-0 z-50 border-b bg-background border-border">
        <div class="container mx-auto px-4 md:px-8 lg:px-12">
            <div class="flex items-center justify-between h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-primary">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-foreground">ApartmentHub</span>
                </a>
                <a href="{{ route('rooms.index') }}" class="text-muted hover:text-foreground transition text-sm">Lihat Kamar</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-8 lg:px-12 py-12 max-w-xl text-center">
        <div class="w-16 h-16 rounded-full bg-primary-lighter text-primary flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-3xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-foreground mb-2">Pemesanan Terkirim</h1>
        <p class="text-muted mb-8">Terima kasih. Data Anda telah kami terima. Silakan selesaikan pembayaran sesuai instruksi yang akan kami kirim ke email Anda.</p>

        <div class="card p-6 text-left mb-8">
            <p class="text-sm text-muted mb-1">No. pemesanan</p>
            <p class="text-xl font-bold text-primary">{{ $booking->booking_number }}</p>
            <hr class="my-4 border-border">
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-muted">Unit</dt><dd>{{ $booking->unit?->unit_number }} ({{ $booking->unit?->unitType?->name ?? '–' }})</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Check-in</dt><dd>{{ $booking->check_in_date->format('d M Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Check-out</dt><dd>{{ $booking->check_out_date->format('d M Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Total</dt><dd class="font-semibold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</dd></div>
            </dl>
        </div>

        <p class="text-sm text-muted mb-6">Konfirmasi dan cara pembayaran akan dikirim ke <strong>{{ $booking->guest_email }}</strong>.</p>

        <a href="{{ route('rooms.index') }}" class="btn-primary inline-block">Lihat Kamar Lain</a>
    </main>
</body>
</html>
