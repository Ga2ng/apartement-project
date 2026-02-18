<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rooms - {{ config('app.name', 'ApartmentHub') }}</title>
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
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="text-muted hover:text-foreground transition">Home</a>
                    <a href="{{ route('rooms.index') }}" class="font-medium text-primary">Rooms</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-secondary py-2 px-4 text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary py-2 px-4 text-sm">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary py-2 px-4 text-sm">Get Started</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-8 lg:px-12 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-foreground mb-2">Our Rooms</h1>
            <p class="text-muted">Browse available units. Pesan tanpa login – isi data diri Anda langsung.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($units as $unit)
                <div class="card overflow-hidden flex flex-col">
                    <div class="h-48 bg-border flex items-center justify-center">
                        <i class="fas fa-door-open text-5xl text-muted opacity-50"></i>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h2 class="text-xl font-semibold text-foreground">{{ $unit->unit_number }}</h2>
                            @if($unit->from_price)
                                <span class="text-sm font-medium text-primary whitespace-nowrap">From Rp {{ number_format($unit->from_price, 0, ',', '.') }}/night</span>
                            @endif
                        </div>
                        <dl class="space-y-2 text-sm text-muted flex-1">
                            <div class="flex justify-between"><dt class="text-foreground">Type</dt><dd>{{ $unit->unitType?->name ?? '–' }}</dd></div>
                            <div class="flex justify-between"><dt class="text-foreground">View</dt><dd>{{ $unit->unitView?->name ?? '–' }}</dd></div>
                            <div class="flex justify-between"><dt class="text-foreground">Interior</dt><dd>{{ $unit->interiorType?->name ?? '–' }}</dd></div>
                            @if($unit->building_tower)
                                <div class="flex justify-between"><dt class="text-foreground">Tower / Floor</dt><dd>{{ $unit->building_tower }} / {{ $unit->floor_level ?? '–' }}</dd></div>
                            @endif
                            <div class="flex justify-between">
                                <dt class="text-foreground">Status</dt>
                                <dd>
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($unit->rental_status === 'vacant') bg-primary-lighter text-primary
                                        @elseif($unit->rental_status === 'monthly') bg-info/20 text-info
                                        @else bg-surface text-muted @endif
                                    ">{{ $unit->rental_status }}</span>
                                </dd>
                            </div>
                        </dl>
                        <div class="mt-4 pt-4 border-t border-border flex gap-2">
                            <a href="{{ route('book.create', ['unit_id' => $unit->id]) }}" class="btn-primary flex-1 text-center py-2 text-sm">Pesan sekarang</a>
                            <a href="{{ url('/') }}#contact" class="btn-secondary py-2 px-4 text-sm">Tanya</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full card p-12 text-center text-muted">
                    <i class="fas fa-door-open text-4xl mb-4 opacity-50"></i>
                    <p>No rooms available at the moment.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="border-t border-border bg-surface mt-12 py-8">
        <div class="container mx-auto px-4 md:px-8 lg:px-12 text-center text-sm text-muted">
            <a href="{{ url('/') }}" class="text-primary hover:underline">← Back to Home</a>
            <p class="mt-2">&copy; {{ date('Y') }} ApartmentHub.</p>
        </div>
    </footer>
</body>
</html>
