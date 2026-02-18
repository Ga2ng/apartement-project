<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\PaymentType;
use App\Models\Promo;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Form pemesanan (tanpa login) – isi data tamu manual.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $unitId = $request->query('unit_id');
        if (! $unitId) {
            return redirect()->route('rooms.index')->with('status', 'Pilih unit terlebih dahulu.');
        }
        $unit = Unit::where('is_active', true)->findOrFail($unitId);
        $unit->setAttribute('from_price', $unit->baseRates()->where('is_active', true)->orderByDesc('effective_from')->first()?->daily_rate);

        $paymentTypes = PaymentType::where('is_active', true)->orderBy('sort_order')->get();
        $promos = Promo::where('is_active', true)->where('valid_until', '>=', now()->toDateString())->get();

        return view('book.create', compact('unit', 'paymentTypes', 'promos'));
    }

    /**
     * Simpan pemesanan (tanpa login) – data tamu dari form.
     */
    public function store(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'guest_id_type' => 'nullable|string|max:30',
            'guest_id_number' => 'nullable|string|max:50',
            'guest_address' => 'nullable|string',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'nullable|integer|min:1',
            'payment_type_id' => 'nullable|exists:payment_types,id',
            'promo_id' => 'nullable|exists:promos,id',
            'special_requests' => 'nullable|string',
        ], [
            'guest_name.required' => 'Nama lengkap wajib diisi.',
            'guest_email.required' => 'Email wajib diisi.',
            'guest_phone.required' => 'No. telepon wajib diisi.',
        ]);

        $valid['source'] = 'web';
        $valid['status'] = \App\Models\Booking::STATUS_PENDING_PAYMENT;

        $booking = $this->bookingService->createBooking($valid);

        return redirect()->route('book.thank-you', ['booking' => $booking->booking_number])
            ->with('booking', $booking);
    }

    /**
     * Halaman terima kasih setelah pesan (tanpa login).
     */
    public function thankYou(Request $request): View|RedirectResponse
    {
        $bookingNumber = $request->query('booking');
        if (! $bookingNumber) {
            return redirect()->route('rooms.index');
        }
        $booking = \App\Models\Booking::where('booking_number', $bookingNumber)->firstOrFail();
        $booking->load(['unit.unitType', 'paymentType']);

        return view('book.thank-you', compact('booking'));
    }
}
