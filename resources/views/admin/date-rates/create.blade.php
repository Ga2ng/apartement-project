@extends('admin.layout')

@section('title', 'Tambah Harga per Tanggal')
@section('heading', 'Tambah Harga per Tanggal')

@section('content')
    <div class="max-w-2xl">
        <div class="card p-6 mb-4 bg-surface">
            <p class="text-sm text-muted">Isi satu tanggal, atau isi <strong>Dari tanggal</strong> dan <strong>Sampai tanggal</strong> untuk mengisi harga yang sama untuk seluruh rentang hari.</p>
        </div>

        <form action="{{ route('admin.date-rates.store') }}" method="post" class="card p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="unit_id" class="block text-sm font-medium text-foreground mb-1">Unit <span class="text-error">*</span></label>
                    <select name="unit_id" id="unit_id" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        <option value="">Pilih unit</option>
                        @foreach($units as $u)
                            <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->unit_number }}</option>
                        @endforeach
                    </select>
                    @error('unit_id') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-foreground mb-1">Harga (Rp) <span class="text-error">*</span></label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('amount') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2 border-t border-border pt-4">
                    <p class="text-sm font-medium text-foreground mb-2">Satu tanggal</p>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-foreground mb-1">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ old('date') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    <p class="text-xs text-muted mt-1">Kosongkan jika pakai rentang di bawah</p>
                    @error('date') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2 border-t border-border pt-4">
                    <p class="text-sm font-medium text-foreground mb-2">Atau rentang tanggal (harga sama untuk tiap hari)</p>
                </div>
                <div>
                    <label for="from_date" class="block text-sm font-medium text-foreground mb-1">Dari tanggal</label>
                    <input type="date" name="from_date" id="from_date" value="{{ old('from_date') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                </div>
                <div>
                    <label for="to_date" class="block text-sm font-medium text-foreground mb-1">Sampai tanggal</label>
                    <input type="date" name="to_date" id="to_date" value="{{ old('to_date') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                </div>
            </div>
            <p class="text-sm text-muted">Jika isi <strong>Dari</strong> dan <strong>Sampai</strong>, semua hari di rentang itu akan diisi dengan harga di atas. Jika hanya isi <strong>Tanggal</strong>, hanya satu hari yang diisi.</p>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.date-rates.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
