@extends('admin.layout')

@section('title', 'Edit Promo')
@section('heading', 'Edit Promo')

@section('content')
    <div class="max-w-2xl">
        <form action="{{ route('admin.promos.update', $promo) }}" method="post" class="card p-6 space-y-4">
            @csrf
            @method('patch')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="code" class="block text-sm font-medium text-foreground mb-1">Kode <span class="text-error">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code', $promo->code) }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('code') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-foreground mb-1">Nama <span class="text-error">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $promo->name) }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('name') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-foreground mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('description', $promo->description) }}</textarea>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-foreground mb-1">Tipe <span class="text-error">*</span></label>
                    <select name="type" id="type" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        <option value="percentage" {{ old('type', $promo->type) === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="fixed_amount" {{ old('type', $promo->type) === 'fixed_amount' ? 'selected' : '' }}>Potongan tetap (Rp)</option>
                    </select>
                </div>
                <div>
                    <label for="value" class="block text-sm font-medium text-foreground mb-1">Nilai <span class="text-error">*</span></label>
                    <input type="number" name="value" id="value" value="{{ old('value', $promo->value) }}" required min="0" step="0.01" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('value') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="min_stay_nights" class="block text-sm font-medium text-foreground mb-1">Min. malam menginap</label>
                    <input type="number" name="min_stay_nights" id="min_stay_nights" value="{{ old('min_stay_nights', $promo->min_stay_nights) }}" min="1" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                </div>
                <div>
                    <label for="min_amount" class="block text-sm font-medium text-foreground mb-1">Min. nilai booking (Rp)</label>
                    <input type="number" name="min_amount" id="min_amount" value="{{ old('min_amount', $promo->min_amount) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                </div>
                <div>
                    <label for="valid_from" class="block text-sm font-medium text-foreground mb-1">Berlaku dari <span class="text-error">*</span></label>
                    <input type="date" name="valid_from" id="valid_from" value="{{ old('valid_from', $promo->valid_from->format('Y-m-d')) }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('valid_from') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="valid_until" class="block text-sm font-medium text-foreground mb-1">Berlaku sampai <span class="text-error">*</span></label>
                    <input type="date" name="valid_until" id="valid_until" value="{{ old('valid_until', $promo->valid_until->format('Y-m-d')) }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('valid_until') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="max_uses" class="block text-sm font-medium text-foreground mb-1">Batas pemakaian</label>
                    <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses', $promo->max_uses) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    <p class="text-xs text-muted mt-1">Terpakai: {{ $promo->used_count }}</p>
                </div>
                <div class="sm:col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }} class="rounded border-border">
                    <label for="is_active" class="text-sm text-foreground">Aktif</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Update Promo</button>
                <a href="{{ route('admin.promos.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
