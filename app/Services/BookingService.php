<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Promo;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Calculate nightly rate for a unit on a given date.
     * Uses unit_date_rates if exists, else unit_base_rates.
     */
    public function getRateForDate(Unit $unit, Carbon $date): float
    {
        $dateStr = $date->toDateString();

        $override = $unit->dateRates()->where('date', $dateStr)->first();
        if ($override !== null) {
            return (float) $override->amount;
        }

        $base = $unit->baseRates()
            ->where('is_active', true)
            ->where('effective_from', '<=', $dateStr)
            ->where(function ($q) use ($dateStr) {
                $q->whereNull('effective_until')->orWhere('effective_until', '>=', $dateStr);
            })
            ->orderByDesc('effective_from')
            ->first();

        if ($base !== null) {
            return (float) $base->daily_rate;
        }

        return 0;
    }

    /**
     * Calculate subtotal for a unit over a date range (sum of nightly rates).
     */
    public function calculateSubtotal(Unit $unit, string $checkIn, string $checkOut): float
    {
        $start = Carbon::parse($checkIn);
        $end = Carbon::parse($checkOut);
        $subtotal = 0;

        for ($d = $start->copy(); $d->lt($end); $d->addDay()) {
            $subtotal += $this->getRateForDate($unit, $d);
        }

        return round($subtotal, 2);
    }

    /**
     * Calculate total nights between check_in and check_out.
     */
    public function totalNights(string $checkIn, string $checkOut): int
    {
        return (int) Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
    }

    /**
     * Apply promo to subtotal; returns discount amount and updated total.
     */
    public function applyPromo(?Promo $promo, float $subtotal, int $totalNights): array
    {
        $discount = 0.0;
        if ($promo === null || ! $promo->isValid($totalNights, $subtotal)) {
            return ['discount_amount' => $discount, 'total_after_discount' => $subtotal];
        }

        if ($promo->type === 'percentage') {
            $discount = round($subtotal * ((float) $promo->value / 100), 2);
        } else {
            $discount = min((float) $promo->value, $subtotal);
        }

        return [
            'discount_amount' => $discount,
            'total_after_discount' => round($subtotal - $discount, 2),
        ];
    }

    /**
     * Generate next booking number (e.g. INV-2025-0001).
     */
    public function generateBookingNumber(): string
    {
        $year = now()->format('Y');
        $last = Booking::withTrashed()
            ->whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $seq = $last ? ((int) preg_replace('/\D/', '', $last->booking_number) + 1) : 1;
        return sprintf('INV-%s-%04d', $year, $seq);
    }

    /**
     * Create a new booking with guest snapshot and totals.
     */
    public function createBooking(array $data): Booking
    {
        $unit = Unit::findOrFail($data['unit_id']);
        $checkIn = $data['check_in_date'];
        $checkOut = $data['check_out_date'];
        $totalNights = $this->totalNights($checkIn, $checkOut);

        $subtotal = $this->calculateSubtotal($unit, $checkIn, $checkOut);
        $promo = isset($data['promo_id']) ? Promo::find($data['promo_id']) : null;
        $promoResult = $this->applyPromo($promo, $subtotal, $totalNights);
        $discountAmount = $promoResult['discount_amount'];
        $totalAfterDiscount = $promoResult['total_after_discount'];
        $taxAmount = $data['tax_amount'] ?? 0;
        $totalAmount = round($totalAfterDiscount + $taxAmount, 2);

        $guestName = $data['guest_name'] ?? null;
        $guestEmail = $data['guest_email'] ?? null;
        $guestPhone = $data['guest_phone'] ?? null;
        $guestIdType = $data['guest_id_type'] ?? null;
        $guestIdNumber = $data['guest_id_number'] ?? null;
        $guestAddress = $data['guest_address'] ?? null;

        if (isset($data['client_id']) && $data['client_id']) {
            $client = Client::find($data['client_id']);
            if ($client) {
                $guestName = $guestName ?? $client->name;
                $guestEmail = $guestEmail ?? $client->email;
                $guestPhone = $guestPhone ?? $client->phone;
                $guestIdType = $guestIdType ?? $client->id_type;
                $guestIdNumber = $guestIdNumber ?? $client->id_number;
                $guestAddress = $guestAddress ?? $client->address;
            }
        }

        if (empty($guestName)) {
            throw new \InvalidArgumentException('Guest name is required.');
        }

        return DB::transaction(function () use (
            $data,
            $unit,
            $totalNights,
            $subtotal,
            $discountAmount,
            $promo,
            $taxAmount,
            $totalAmount,
            $guestName,
            $guestEmail,
            $guestPhone,
            $guestIdType,
            $guestIdNumber,
            $guestAddress
        ) {
            $booking = new Booking([
                'booking_number' => $this->generateBookingNumber(),
                'unit_id' => $unit->id,
                'client_id' => $data['client_id'] ?? null,
                'user_id' => $data['user_id'] ?? (auth()->user()?->getKey()),
                'guest_name' => $guestName,
                'guest_email' => $guestEmail,
                'guest_phone' => $guestPhone,
                'guest_id_type' => $guestIdType,
                'guest_id_number' => $guestIdNumber,
                'guest_address' => $guestAddress,
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'number_of_guests' => $data['number_of_guests'] ?? null,
                'total_nights' => $totalNights,
                'status' => $data['status'] ?? Booking::STATUS_PENDING_PAYMENT,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'promo_id' => $promo?->id,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'currency' => $data['currency'] ?? 'IDR',
                'payment_type_id' => $data['payment_type_id'] ?? null,
                'source' => $data['source'] ?? 'admin',
                'special_requests' => $data['special_requests'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
            $booking->save();

            if ($promo) {
                $promo->increment('used_count');
            }

            return $booking;
        });
    }
}
