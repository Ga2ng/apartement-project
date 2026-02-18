<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'ApartmentHub') }} Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-background text-foreground min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 shrink-0 border-r border-border bg-surface flex flex-col">
            <div class="p-6 border-b border-border">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-primary">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <span class="font-bold text-lg text-foreground">ApartmentHub</span>
                </a>
                <p class="text-xs text-muted mt-1">Admin Panel</p>
            </div>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-primary-lighter text-primary font-medium' : 'text-muted hover:bg-surface-elevated hover:text-foreground' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.bookings.*') ? 'bg-primary-lighter text-primary font-medium' : 'text-muted hover:bg-surface-elevated hover:text-foreground' }}">
                    <i class="fas fa-calendar-check w-5"></i>
                    <span>Bookings</span>
                </a>
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-muted uppercase tracking-wider">Master Data</p>
                </div>
                <a href="{{ route('admin.units.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.units.index') ? 'bg-primary-lighter text-primary font-medium' : 'text-muted hover:bg-surface-elevated hover:text-foreground' }}">
                    <i class="fas fa-door-open w-5"></i>
                    <span>Units</span>
                </a>
                <a href="{{ route('admin.units.available') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.units.available') ? 'bg-primary-lighter text-primary font-medium' : 'text-muted hover:bg-surface-elevated hover:text-foreground' }}">
                    <i class="fas fa-key w-5"></i>
                    <span>Kamar Tersedia</span>
                </a>
                <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.clients.*') ? 'bg-primary-lighter text-primary font-medium' : 'text-muted hover:bg-surface-elevated hover:text-foreground' }}">
                    <i class="fas fa-users w-5"></i>
                    <span>Clients</span>
                </a>
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-muted uppercase tracking-wider">Harga & Promo</p>
                </div>
                <a href="{{ route('admin.date-rates.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.date-rates.*') ? 'bg-primary-lighter text-primary font-medium' : 'text-muted hover:bg-surface-elevated hover:text-foreground' }}">
                    <i class="fas fa-calendar-day w-5"></i>
                    <span>Harga per Tanggal</span>
                </a>
                <a href="{{ route('admin.promos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.promos.*') ? 'bg-primary-lighter text-primary font-medium' : 'text-muted hover:bg-surface-elevated hover:text-foreground' }}">
                    <i class="fas fa-tag w-5"></i>
                    <span>Promo</span>
                </a>
            </nav>
            <div class="p-4 border-t border-border">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-muted hover:bg-surface-elevated hover:text-foreground text-sm">
                    <i class="fas fa-external-link-alt w-4"></i>
                    <span>View Site</span>
                </a>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top bar -->
            <header class="sticky top-0 z-30 border-b border-border bg-background">
                <div class="flex items-center justify-between h-16 px-6">
                    <h1 class="text-xl font-semibold text-foreground">@yield('heading', 'Dashboard')</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-muted">{{ Auth::user()->name }}</span>
                        <a href="{{ route('profile.edit') }}" class="p-2 rounded-lg text-muted hover:bg-surface hover:text-foreground transition" title="Profile">
                            <i class="fas fa-user-cog"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg text-muted hover:bg-surface hover:text-foreground transition" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 overflow-auto">
                @if (session('status'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-primary-lighter text-primary text-sm">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
