@extends('admin.layout')

@section('title', 'Bookings')
@section('heading', 'Bookings')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <form action="{{ route('admin.bookings.index') }}" method="get" class="flex gap-2 flex-wrap items-center">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Booking # or guest..." class="px-4 py-2 rounded-lg border border-border bg-background text-foreground max-w-xs">
            <select name="status" class="px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                <option value="">All statuses</option>
                @foreach(['draft','pending_payment','confirmed','checked_in','checked_out','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ str_replace('_',' ', ucfirst($s)) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary py-2 px-4">Filter</button>
        </form>
        <a href="{{ route('admin.bookings.create') }}" class="btn-primary shrink-0">
            <i class="fas fa-plus mr-2"></i>New Booking
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface border-b border-border">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Booking</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Guest</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Check-in / Out</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-surface/50">
                            <td class="px-6 py-4">
                                <span class="font-medium text-foreground">{{ $booking->booking_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-muted">{{ $booking->unit?->unit_number ?? '–' }}</td>
                            <td class="px-6 py-4 text-muted">{{ $booking->guest_name }}</td>
                            <td class="px-6 py-4 text-muted text-sm">
                                {{ $booking->check_in_date->format('d M Y') }} – {{ $booking->check_out_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-foreground">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($booking->status) {
                                        'confirmed' => 'bg-primary-lighter text-primary',
                                        'pending_payment' => 'bg-warning/20 text-warning',
                                        'checked_in' => 'bg-info/20 text-info',
                                        'checked_out' => 'bg-surface text-muted',
                                        'cancelled' => 'bg-error/20 text-error',
                                        default => 'bg-surface text-muted',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">{{ str_replace('_',' ', $booking->status) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-primary hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-muted">No bookings yet. <a href="{{ route('admin.bookings.create') }}" class="text-primary hover:underline">Create one</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="px-6 py-3 border-t border-border">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection
