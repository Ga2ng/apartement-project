@extends('admin.layout')

@section('title', 'Promo')
@section('heading', 'Promo')

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.promos.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Tambah Promo
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface border-b border-border">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Type / Value</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Valid</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Uses</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($promos as $promo)
                        <tr class="hover:bg-surface/50">
                            <td class="px-6 py-4 font-medium">{{ $promo->code }}</td>
                            <td class="px-6 py-4 text-muted">{{ $promo->name }}</td>
                            <td class="px-6 py-4 text-muted">
                                {{ $promo->type === 'percentage' ? $promo->value . '%' : 'Rp ' . number_format($promo->value, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-muted text-sm">
                                {{ $promo->valid_from->format('d M Y') }} – {{ $promo->valid_until->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-muted">
                                {{ $promo->used_count }}{{ $promo->max_uses ? ' / ' . $promo->max_uses : '' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs {{ $promo->is_active ? 'bg-primary-lighter text-primary' : 'bg-surface text-muted' }}">
                                    {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="text-primary hover:underline text-sm">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-muted">Belum ada promo. <a href="{{ route('admin.promos.create') }}" class="text-primary hover:underline">Tambah promo</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($promos->hasPages())
            <div class="px-6 py-3 border-t border-border">
                {{ $promos->links() }}
            </div>
        @endif
    </div>
@endsection
