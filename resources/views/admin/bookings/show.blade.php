@extends('admin.layout')

@section('title', $booking->booking_number)
@section('heading', 'Booking ' . $booking->booking_number)

@section('content')
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1 space-y-6">
            <div class="card p-6">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($booking->status === 'confirmed') bg-primary-lighter text-primary
                        @elseif($booking->status === 'pending_payment') bg-warning/20 text-warning
                        @elseif($booking->status === 'cancelled') bg-error/20 text-error
                        @else bg-surface text-muted @endif
                    ">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span>
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-muted hover:text-foreground">← Back to list</a>
                </div>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <dt class="text-muted">Unit</dt>
                    <dd class="font-medium">{{ $booking->unit?->unit_number }} ({{ $booking->unit?->unitType?->name ?? '–' }})</dd>
                    <dt class="text-muted">Check-in</dt>
                    <dd>{{ $booking->check_in_date->format('d M Y') }}</dd>
                    <dt class="text-muted">Check-out</dt>
                    <dd>{{ $booking->check_out_date->format('d M Y') }}</dd>
                    <dt class="text-muted">Nights</dt>
                    <dd>{{ $booking->total_nights }}</dd>
                    <dt class="text-muted">Guest</dt>
                    <dd>{{ $booking->guest_name }} @if($booking->guest_phone)<br><span class="text-muted">{{ $booking->guest_phone }}</span>@endif</dd>
                    <dt class="text-muted">Payment type</dt>
                    <dd>{{ $booking->paymentType?->name ?? '–' }}</dd>
                    @if($booking->promo)
                        <dt class="text-muted">Promo</dt>
                        <dd>{{ $booking->promo->code }} (-Rp {{ number_format($booking->discount_amount, 0, ',', '.') }})</dd>
                    @endif
                </dl>
            </div>

            <div class="card p-6">
                <h3 class="font-semibold text-foreground mb-3">Amount</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span class="text-muted">Subtotal</span> Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</div>
                    @if($booking->discount_amount > 0)
                        <div class="flex justify-between text-primary">Discount <span>- Rp {{ number_format($booking->discount_amount, 0, ',', '.') }}</span></div>
                    @endif
                    @if($booking->tax_amount > 0)
                        <div class="flex justify-between">Tax <span>Rp {{ number_format($booking->tax_amount, 0, ',', '.') }}</span></div>
                    @endif
                    <div class="flex justify-between font-semibold text-foreground pt-2 border-t border-border">Total <span>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between text-muted">Paid <span>Rp {{ number_format($booking->totalPaid(), 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-medium">Balance <span class="text-primary">Rp {{ number_format($booking->balanceDue(), 0, ',', '.') }}</span></div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-semibold text-foreground mb-3">Payments</h3>
                @if($booking->payments->isEmpty())
                    <p class="text-muted text-sm">No payments yet.</p>
                @else
                    <table class="w-full text-sm">
                        <thead class="border-b border-border">
                            <tr class="text-left text-muted">
                                <th class="pb-2">Date</th>
                                <th class="pb-2">Amount</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2">Reference</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($booking->payments as $p)
                                <tr>
                                    <td class="py-2">{{ $p->created_at->format('d M Y H:i') }}</td>
                                    <td>Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                                    <td><span class="px-2 py-0.5 rounded text-xs {{ $p->status === 'paid' ? 'bg-primary-lighter text-primary' : 'bg-surface text-muted' }}">{{ $p->status }}</span></td>
                                    <td class="text-muted">{{ $p->reference_number ?? $p->gateway_reference ?? '–' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="lg:w-96 shrink-0">
            <div class="card p-6 sticky top-24">
                <h3 class="font-semibold text-foreground mb-3">Record Payment</h3>
                @if($booking->balanceDue() <= 0)
                    <p class="text-sm text-muted">This booking is fully paid.</p>
                @else
                    <form action="{{ route('admin.bookings.payments.store', $booking) }}" method="post" class="space-y-3">
                        @csrf
                        <div>
                            <label for="amount" class="block text-sm font-medium text-foreground mb-1">Amount <span class="text-error">*</span></label>
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ $suggestedDeposit ?? $booking->balanceDue() }}" required class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                            @if($suggestedDeposit)
                                <p class="text-xs text-muted mt-1">Suggested DP: Rp {{ number_format($suggestedDeposit, 0, ',', '.') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-foreground mb-1">Status</label>
                            <select name="status" id="status" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-foreground mb-1">Reference / No. transfer</label>
                            <input type="text" name="reference_number" id="reference_number" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground" placeholder="Optional">
                        </div>
                        <div>
                            <label for="gateway_name" class="block text-sm font-medium text-foreground mb-1">Gateway</label>
                            <input type="text" name="gateway_name" id="gateway_name" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground" placeholder="e.g. manual, xendit">
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-foreground mb-1">Notes</label>
                            <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground"></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full">Record Payment</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
