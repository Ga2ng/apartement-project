@extends('admin.layout')

@section('title', 'Harga per Tanggal')
@section('heading', 'Harga per Tanggal')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <form action="{{ route('admin.date-rates.index') }}" method="get" class="flex flex-wrap gap-2 items-end">
            <div>
                <label for="unit_id" class="block text-xs text-muted mb-1">Unit</label>
                <select name="unit_id" id="unit_id" class="px-3 py-2 rounded-lg border border-border bg-background text-foreground text-sm">
                    <option value="">Semua</option>
                    @foreach($units as $u)
                        <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->unit_number }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="from" class="block text-xs text-muted mb-1">Dari tanggal</label>
                <input type="date" name="from" id="from" value="{{ request('from') }}" class="px-3 py-2 rounded-lg border border-border bg-background text-foreground text-sm">
            </div>
            <div>
                <label for="to" class="block text-xs text-muted mb-1">Sampai</label>
                <input type="date" name="to" id="to" value="{{ request('to') }}" class="px-3 py-2 rounded-lg border border-border bg-background text-foreground text-sm">
            </div>
            <button type="submit" class="btn-primary py-2 px-4 text-sm">Filter</button>
        </form>
        <a href="{{ route('admin.date-rates.create') }}" class="btn-primary shrink-0">
            <i class="fas fa-plus mr-2"></i>Tambah Harga
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="px-6 py-4 border-b border-border">
            <h2 class="text-lg font-semibold text-foreground">Override harga per hari</h2>
            <p class="text-sm text-muted mt-1">Harga di sini dipakai untuk tanggal tertentu; jika tidak ada, dipakai harga dasar unit.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface border-b border-border">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($dateRates as $dr)
                        <tr class="hover:bg-surface/50">
                            <td class="px-6 py-4 font-medium">{{ $dr->unit?->unit_number ?? '–' }}</td>
                            <td class="px-6 py-4 text-muted">{{ $dr->date->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-medium text-primary">Rp {{ number_format($dr->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.date-rates.destroy', $dr) }}" method="post" class="inline" onsubmit="return confirm('Hapus harga ini?');">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-error hover:underline text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-muted">Belum ada override harga. <a href="{{ route('admin.date-rates.create') }}" class="text-primary hover:underline">Tambah harga untuk tanggal tertentu</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($dateRates->hasPages())
            <div class="px-6 py-3 border-t border-border">
                {{ $dateRates->links() }}
            </div>
        @endif
    </div>
@endsection
