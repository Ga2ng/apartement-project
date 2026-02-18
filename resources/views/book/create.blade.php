<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesan Kamar - {{ config('app.name', 'ApartmentHub') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-foreground min-h-screen">
    <nav class="sticky top-0 z-50 border-b bg-background border-border">
        <div class="container mx-auto px-4 md:px-8 lg:px-12">
            <div class="flex items-center justify-between h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-primary">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-foreground">ApartmentHub</span>
                </a>
                <a href="{{ route('rooms.index') }}" class="text-muted hover:text-foreground transition text-sm">← Kembali ke Daftar Kamar</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-8 lg:px-12 py-8 max-w-3xl">
        <h1 class="text-2xl font-bold text-foreground mb-2">Pesan Kamar</h1>
        <p class="text-muted mb-6">Isi data diri Anda. Tidak perlu login.</p>

        <div class="card p-6 mb-6 bg-primary-lighter/30 border-primary/20">
            <p class="font-medium text-foreground">{{ $unit->unit_number }}</p>
            <p class="text-sm text-muted">{{ $unit->unitType?->name ?? '–' }} · {{ $unit->unitView?->name ?? '–' }} · {{ $unit->interiorType?->name ?? '–' }}</p>
            @if($unit->from_price)
                <p class="text-sm text-primary mt-1">From Rp {{ number_format($unit->from_price, 0, ',', '.') }}/malam</p>
            @endif
        </div>

        <form action="{{ route('book.store') }}" method="post" class="card p-6 space-y-6">
            @csrf
            <input type="hidden" name="unit_id" value="{{ $unit->id }}">

            <div>
                <h3 class="font-semibold text-foreground mb-3">Data Tamu</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="guest_name" class="block text-sm font-medium text-foreground mb-1">Nama lengkap <span class="text-error">*</span></label>
                        <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        @error('guest_name') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="guest_email" class="block text-sm font-medium text-foreground mb-1">Email <span class="text-error">*</span></label>
                        <input type="email" name="guest_email" id="guest_email" value="{{ old('guest_email') }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        @error('guest_email') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="guest_phone" class="block text-sm font-medium text-foreground mb-1">No. telepon <span class="text-error">*</span></label>
                        <input type="text" name="guest_phone" id="guest_phone" value="{{ old('guest_phone') }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                        @error('guest_phone') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="guest_id_type" class="block text-sm font-medium text-foreground mb-1">Tipe identitas</label>
                        <select name="guest_id_type" id="guest_id_type" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">–</option>
                            <option value="KTP" {{ old('guest_id_type') === 'KTP' ? 'selected' : '' }}>KTP</option>
                            <option value="Passport" {{ old('guest_id_type') === 'Passport' ? 'selected' : '' }}>Passport</option>
                        </select>
                    </div>
                    <div>
                        <label for="guest_id_number" class="block text-sm font-medium text-foreground mb-1">No. identitas</label>
                        <input type="text" name="guest_id_number" id="guest_id_number" value="{{ old('guest_id_number') }}" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="guest_address" class="block text-sm font-medium text-foreground mb-1">Alamat</label>
                        <textarea name="guest_address" id="guest_address" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('guest_address') }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-foreground mb-3">Tanggal menginap</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                        <label for="number_of_guests" class="block text-sm font-medium text-foreground mb-1">Jumlah tamu</label>
                        <input type="number" name="number_of_guests" id="number_of_guests" value="{{ old('number_of_guests') }}" min="1" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-foreground mb-3">Pembayaran & Promo</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="payment_type_id" class="block text-sm font-medium text-foreground mb-1">Cara bayar</label>
                        <select name="payment_type_id" id="payment_type_id" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">– Pilih nanti –</option>
                            @foreach($paymentTypes as $pt)
                                <option value="{{ $pt->id }}" {{ old('payment_type_id') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="promo_id" class="block text-sm font-medium text-foreground mb-1">Kode promo</label>
                        <select name="promo_id" id="promo_id" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            <option value="">–</option>
                            @foreach($promos as $p)
                                <option value="{{ $p->id }}" {{ old('promo_id') == $p->id ? 'selected' : '' }}>{{ $p->code }} – {{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="special_requests" class="block text-sm font-medium text-foreground mb-1">Request khusus</label>
                        <textarea name="special_requests" id="special_requests" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">{{ old('special_requests') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Kirim Pemesanan</button>
                <a href="{{ route('rooms.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </main>
</body>
</html>
