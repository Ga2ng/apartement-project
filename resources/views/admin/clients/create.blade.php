@extends('admin.layout')

@section('title', 'Add Client')
@section('heading', 'Add Client')

@section('content')
    <div class="max-w-2xl">
        <form action="{{ route('admin.clients.store') }}" method="post" class="card p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-foreground mb-1">Name <span class="text-error">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('name') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-foreground mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('email') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-foreground mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    @error('phone') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="id_type" class="block text-sm font-medium text-foreground mb-1">ID Type</label>
                    <select name="id_type" id="id_type" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        <option value="">–</option>
                        <option value="KTP" {{ old('id_type') === 'KTP' ? 'selected' : '' }}>KTP</option>
                        <option value="Passport" {{ old('id_type') === 'Passport' ? 'selected' : '' }}>Passport</option>
                    </select>
                </div>
                <div>
                    <label for="id_number" class="block text-sm font-medium text-foreground mb-1">ID Number</label>
                    <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="block text-sm font-medium text-foreground mb-1">Address</label>
                    <textarea name="address" id="address" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('address') }}</textarea>
                </div>
                <div>
                    <label for="city" class="block text-sm font-medium text-foreground mb-1">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                </div>
                <div>
                    <label for="country" class="block text-sm font-medium text-foreground mb-1">Country</label>
                    <input type="text" name="country" id="country" value="{{ old('country', 'Indonesia') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                </div>
                <div class="sm:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-foreground mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Save Client</button>
                <a href="{{ route('admin.clients.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
