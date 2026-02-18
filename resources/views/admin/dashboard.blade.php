@extends('admin.layout')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted">Total Units</p>
                    <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['units_total'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-primary-lighter text-primary">
                    <i class="fas fa-door-open text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted">Vacant</p>
                    <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['units_vacant'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-primary-lighter text-primary">
                    <i class="fas fa-key text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted">Monthly</p>
                    <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['units_monthly'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-primary-lighter text-primary">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted">Daily</p>
                    <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['units_daily'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-primary-lighter text-primary">
                    <i class="fas fa-moon text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <a href="{{ route('admin.bookings.index') }}" class="card p-6 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted">Total Bookings</p>
                    <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['bookings_total'] }}</p>
                </div>
                <i class="fas fa-calendar-check text-2xl text-primary"></i>
            </div>
        </a>
        <a href="{{ route('admin.bookings.index') }}?status=pending_payment" class="card p-6 hover:border-warning transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted">Pending Payment</p>
                    <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['bookings_pending'] }}</p>
                </div>
                <i class="fas fa-clock text-2xl text-warning"></i>
            </div>
        </a>
        <a href="{{ route('admin.bookings.index') }}?status=confirmed" class="card p-6 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted">Confirmed</p>
                    <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['bookings_confirmed'] }}</p>
                </div>
                <i class="fas fa-check-circle text-2xl text-primary"></i>
            </div>
        </a>
    </div>

    @if(isset($recentBookings) && $recentBookings->isNotEmpty())
        <div class="card overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                <h2 class="text-lg font-semibold text-foreground">Recent Bookings</h2>
                <a href="{{ route('admin.bookings.index') }}" class="text-sm text-primary hover:underline">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface border-b border-border">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Booking</th>
                            <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Unit</th>
                            <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Guest</th>
                            <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider w-20"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($recentBookings as $b)
                            <tr class="hover:bg-surface/50">
                                <td class="px-6 py-3 font-medium">{{ $b->booking_number }}</td>
                                <td class="px-6 py-3 text-muted">{{ $b->unit?->unit_number }}</td>
                                <td class="px-6 py-3 text-muted">{{ $b->guest_name }}</td>
                                <td class="px-6 py-3">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-3"><span class="px-2 py-0.5 rounded text-xs {{ $b->status === 'confirmed' ? 'bg-primary-lighter text-primary' : 'bg-surface text-muted' }}">{{ $b->status }}</span></td>
                                <td class="px-6 py-3"><a href="{{ route('admin.bookings.show', $b) }}" class="text-primary text-sm hover:underline">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Master Data: Units -->
    <section id="units" class="card overflow-hidden">
        <div class="px-6 py-4 border-b border-border flex items-center justify-between">
            <h2 class="text-lg font-semibold text-foreground">Master Data – Units</h2>
            <a href="{{ route('admin.units.index') }}" class="text-sm text-primary hover:underline">{{ $units->count() }} units →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface border-b border-border">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">View</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Interior</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Occupancy</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Available</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($units as $unit)
                        <tr class="hover:bg-surface/50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-foreground">{{ $unit->unit_number }}</span>
                                @if($unit->building_tower)
                                    <span class="text-muted text-sm">({{ $unit->building_tower }}-{{ $unit->floor_level }})</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-muted">{{ $unit->unitType?->name ?? '–' }}</td>
                            <td class="px-6 py-4 text-muted">{{ $unit->unitView?->name ?? '–' }}</td>
                            <td class="px-6 py-4 text-muted">{{ $unit->interiorType?->name ?? '–' }}</td>
                            <td class="px-6 py-4 text-muted">{{ $unit->owner?->name ?? '–' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($unit->rental_status) {
                                        'vacant' => 'bg-primary-lighter text-primary',
                                        'monthly' => 'bg-info/20 text-info',
                                        'daily' => 'bg-warning/20 text-warning',
                                        default => 'bg-surface text-muted',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">{{ $unit->rental_status }}</span>
                            </td>
                            <td class="px-6 py-4 text-muted">{{ $unit->occupancy_count }}</td>
                            <td class="px-6 py-4">
                                @if($unit->is_available)
                                    <span class="text-success text-sm">Yes</span>
                                @else
                                    <span class="text-muted text-sm">No</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-muted">No units found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
