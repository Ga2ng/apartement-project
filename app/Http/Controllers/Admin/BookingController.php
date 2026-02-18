<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\PaymentType;
use App\Models\Promo;
use App\Models\Unit;
use App\Services\BookingService;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService,
        protected PaymentService $paymentService
    ) {}

    public function index(Request $request): View
    {
        $bookings = Booking::with(['unit', 'client', 'paymentType', 'promo'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), fn ($q) => $q->where('booking_number', 'like', '%' . $request->q . '%')
                ->orWhere('guest_name', 'like', '%' . $request->q . '%'))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $units = Unit::where('is_active', true)->orderBy('unit_number')->get(['id', 'unit_number', 'building_tower', 'floor_level']);
        $clients = Client::orderBy('name')->get(['id', 'name', 'email', 'phone']);
        $paymentTypes = PaymentType::where('is_active', true)->orderBy('sort_order')->get();
        $promos = Promo::where('is_active', true)->where('valid_until', '>=', now()->toDateString())->get();

        return view('admin.bookings.create', compact('units', 'clients', 'paymentTypes', 'promos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'client_id' => 'nullable|exists:clients,id',
            'guest_name' => 'required_without:client_id|nullable|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'nullable|string|max:50',
            'guest_id_type' => 'nullable|string|max:30',
            'guest_id_number' => 'nullable|string|max:50',
            'guest_address' => 'nullable|string',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'nullable|integer|min:1',
            'payment_type_id' => 'nullable|exists:payment_types,id',
            'promo_id' => 'nullable|exists:promos,id',
            'tax_amount' => 'nullable|numeric|min:0',
            'source' => 'nullable|string|max:30',
            'special_requests' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        if (empty($valid['guest_name']) && empty($valid['client_id'])) {
            return back()->withErrors(['guest_name' => 'Pilih client atau isi nama tamu.'])->withInput();
        }
        $booking = $this->bookingService->createBooking($valid);
        return redirect()->route('admin.bookings.show', $booking)->with('status', 'Booking created: ' . $booking->booking_number);
    }

    public function show(Booking $booking): View
    {
        $booking->load(['unit.unitType', 'unit.unitView', 'unit.interiorType', 'unit.owner', 'client', 'paymentType', 'promo', 'payments.paymentType']);
        $suggestedDeposit = $this->paymentService->suggestedDepositAmount($booking);
        return view('admin.bookings.show', compact('booking', 'suggestedDeposit'));
    }

    public function storePayment(Request $request, Booking $booking): RedirectResponse
    {
        $valid = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_type_id' => 'nullable|exists:payment_types,id',
            'status' => 'required|in:pending,paid',
            'gateway_name' => 'nullable|string|max:50',
            'gateway_reference' => 'nullable|string|max:100',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);
        $options = [
            'payment_type_id' => $valid['payment_type_id'] ?? $booking->payment_type_id,
            'status' => $valid['status'],
            'gateway_name' => $valid['gateway_name'] ?? null,
            'gateway_reference' => $valid['gateway_reference'] ?? null,
            'reference_number' => $valid['reference_number'] ?? null,
            'notes' => $valid['notes'] ?? null,
        ];
        if ($valid['status'] === 'paid') {
            $options['paid_at'] = now();
        }
        $this->paymentService->recordPayment($booking, (float) $valid['amount'], $options);
        return redirect()->route('admin.bookings.show', $booking)->with('status', 'Payment recorded.');
    }
}
