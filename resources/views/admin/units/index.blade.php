@extends('admin.layout')

@section('title', 'Units')
@section('heading', 'Units')

@section('content')
    <div class="card overflow-hidden">
        <div class="px-6 py-4 border-b border-border flex items-center justify-between">
            <h2 class="text-lg font-semibold text-foreground">Master Data – Units</h2>
            <span class="text-sm text-muted">{{ $units->count() }} units</span>
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
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Available</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($units as $unit)
                        <tr class="hover:bg-surface/50">
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
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($unit->rental_status === 'vacant') bg-primary-lighter text-primary
                                    @elseif($unit->rental_status === 'monthly') bg-info/20 text-info
                                    @else bg-surface text-muted @endif
                                ">{{ $unit->rental_status }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $unit->is_available ? 'Yes' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-muted">No units.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
