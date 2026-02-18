<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Record a payment (DP, full, or additional) and optionally mark as paid.
     */
    public function recordPayment(
        Booking $booking,
        float $amount,
        array $options = []
    ): Payment {
        return DB::transaction(function () use ($booking, $amount, $options) {
            $payment = new Payment([
                'booking_id' => $booking->id,
                'payment_type_id' => $options['payment_type_id'] ?? $booking->payment_type_id,
                'amount' => $amount,
                'currency' => $options['currency'] ?? $booking->currency ?? 'IDR',
                'status' => $options['status'] ?? Payment::STATUS_PENDING,
                'paid_at' => $options['paid_at'] ?? null,
                'gateway_name' => $options['gateway_name'] ?? null,
                'gateway_reference' => $options['gateway_reference'] ?? null,
                'gateway_response' => $options['gateway_response'] ?? null,
                'reference_number' => $options['reference_number'] ?? null,
                'notes' => $options['notes'] ?? null,
            ]);
            $payment->save();

            if ($payment->status === Payment::STATUS_PAID) {
                $this->syncBookingPaymentStatus($booking);
            }

            return $payment;
        });
    }

    /**
     * Mark payment as paid (e.g. after gateway callback).
     */
    public function markAsPaid(Payment $payment, array $options = []): Payment
    {
        return DB::transaction(function () use ($payment, $options) {
            $payment->update([
                'status' => Payment::STATUS_PAID,
                'paid_at' => $options['paid_at'] ?? now(),
                'gateway_name' => $options['gateway_name'] ?? $payment->gateway_name,
                'gateway_reference' => $options['gateway_reference'] ?? $payment->gateway_reference,
                'gateway_response' => $options['gateway_response'] ?? $payment->gateway_response,
                'reference_number' => $options['reference_number'] ?? $payment->reference_number,
            ]);

            $this->syncBookingPaymentStatus($payment->booking);

            return $payment->fresh();
        });
    }

    /**
     * Update booking status based on total paid amount.
     * - If total paid >= total_amount -> confirmed (or keep pending if pay_at_venue and not yet checked in).
     */
    public function syncBookingPaymentStatus(Booking $booking): void
    {
        $booking->refresh();
        $totalPaid = $booking->totalPaid();
        $totalAmount = (float) $booking->total_amount;

        if ($totalPaid >= $totalAmount && $booking->status === Booking::STATUS_PENDING_PAYMENT) {
            $booking->update(['status' => Booking::STATUS_CONFIRMED]);
        }
    }

    /**
     * Calculate suggested deposit amount based on booking's payment type.
     */
    public function suggestedDepositAmount(Booking $booking): ?float
    {
        $paymentType = $booking->paymentType;
        if ($paymentType === null || ! $paymentType->is_deposit) {
            return null;
        }
        $pct = (float) $paymentType->deposit_percentage;
        if ($pct <= 0) {
            return null;
        }
        return round((float) $booking->total_amount * ($pct / 100), 2);
    }
}
