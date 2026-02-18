@extends('admin.layout')

@section('title', 'New Booking')
@section('heading', 'New Booking')

@section('content')
    <div class="max-w-4xl">
        <form action="{{ route('admin.bookings.store') }}" method="post" class="card p-6 space-y-6">
            @csrf

            <div>
                <h3 class="text-lg font-semibold text-foreground mb-3">Unit & Dates</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="unit_id" class="block text-sm font-medium text-foreground mb-1">Unit <span class="text-error">*</span></label>
                        <select name="unit_id" id="unit_id" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">Select unit</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->unit_number }} @if($u->building_tower)({{ $u->building_tower }}-{{ $u->floor_level }})@endif</option>
                            @endforeach
                        </select>
                        @error('unit_id') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="check_in_date" class="block text-sm font-medium text-foreground mb-1">Check-in <span class="text-error">*</span></label>
                        <input type="date" name="check_in_date" id="check_in_date" value="{{ old('check_in_date') }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        @error('check_in_date') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="check_out_date" class="block text-sm font-medium text-foreground mb-1">Check-out <span class="text-error">*</span></label>
                        <input type="date" name="check_out_date" id="check_out_date" value="{{ old('check_out_date') }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        @error('check_out_date') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="number_of_guests" class="block text-sm font-medium text-foreground mb-1">Guests</label>
                        <input type="number" name="number_of_guests" id="number_of_guests" value="{{ old('number_of_guests') }}" min="1" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-foreground mb-3">Guest</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="client_id" class="block text-sm font-medium text-foreground mb-1">Existing client (optional)</label>
                        <select name="client_id" id="client_id" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">– New guest –</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} @if($c->phone)({{ $c->phone }})@endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2 border-t border-border pt-3 mt-1">
                        <p class="text-sm text-muted mb-2">Or fill guest details (used if no client selected)</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="guest_name" class="block text-sm font-medium text-foreground mb-1">Guest name <span class="text-error">*</span> if no client</label>
                        <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground" placeholder="Full name">
                        @error('guest_name') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="guest_email" class="block text-sm font-medium text-foreground mb-1">Email</label>
                        <input type="email" name="guest_email" id="guest_email" value="{{ old('guest_email') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    </div>
                    <div>
                        <label for="guest_phone" class="block text-sm font-medium text-foreground mb-1">Phone</label>
                        <input type="text" name="guest_phone" id="guest_phone" value="{{ old('guest_phone') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    </div>
                    <div>
                        <label for="guest_id_type" class="block text-sm font-medium text-foreground mb-1">ID Type</label>
                        <select name="guest_id_type" id="guest_id_type" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">–</option>
                            <option value="KTP" {{ old('guest_id_type') === 'KTP' ? 'selected' : '' }}>KTP</option>
                            <option value="Passport" {{ old('guest_id_type') === 'Passport' ? 'selected' : '' }}>Passport</option>
                        </select>
                    </div>
                    <div>
                        <label for="guest_id_number" class="block text-sm font-medium text-foreground mb-1">ID Number</label>
                        <input type="text" name="guest_id_number" id="guest_id_number" value="{{ old('guest_id_number') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="guest_address" class="block text-sm font-medium text-foreground mb-1">Address</label>
                        <textarea name="guest_address" id="guest_address" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('guest_address') }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-foreground mb-3">Payment & Promo</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="payment_type_id" class="block text-sm font-medium text-foreground mb-1">Payment type</label>
                        <select name="payment_type_id" id="payment_type_id" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">–</option>
                            @foreach($paymentTypes as $pt)
                                <option value="{{ $pt->id }}" {{ old('payment_type_id') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="promo_id" class="block text-sm font-medium text-foreground mb-1">Promo</label>
                        <select name="promo_id" id="promo_id" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">–</option>
                            @foreach($promos as $p)
                                <option value="{{ $p->id }}" {{ old('promo_id') == $p->id ? 'selected' : '' }}>{{ $p->code }} – {{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tax_amount" class="block text-sm font-medium text-foreground mb-1">Tax amount (optional)</label>
                        <input type="number" name="tax_amount" id="tax_amount" value="{{ old('tax_amount', 0) }}" min="0" step="0.01" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    </div>
                    <div>
                        <label for="source" class="block text-sm font-medium text-foreground mb-1">Source</label>
                        <select name="source" id="source" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="admin" {{ old('source') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="web" {{ old('source') === 'web' ? 'selected' : '' }}>Web</option>
                            <option value="walk_in" {{ old('source') === 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="special_requests" class="block text-sm font-medium text-foreground mb-1">Special requests</label>
                        <textarea name="special_requests" id="special_requests" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('special_requests') }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-foreground mb-1">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Create Booking</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
