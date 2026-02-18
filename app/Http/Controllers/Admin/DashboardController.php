<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Unit;
use App\Models\UnitType;
use App\Models\Owner;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with master data overview.
     */
    public function index(): View
    {
        $units = Unit::with(['unitType', 'unitView', 'interiorType', 'owner'])
            ->orderBy('unit_number')
            ->get();

        $stats = [
            'units_total' => Unit::count(),
            'units_vacant' => Unit::where('rental_status', 'vacant')->count(),
            'units_monthly' => Unit::where('rental_status', 'monthly')->count(),
            'units_daily' => Unit::where('rental_status', 'daily')->count(),
            'unit_types_count' => UnitType::count(),
            'owners_count' => Owner::count(),
            'bookings_total' => Booking::count(),
            'bookings_pending' => Booking::where('status', 'pending_payment')->count(),
            'bookings_confirmed' => Booking::where('status', 'confirmed')->count(),
        ];

        $recentBookings = Booking::with(['unit', 'paymentType'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'units' => $units,
            'stats' => $stats,
            'recentBookings' => $recentBookings,
        ]);
    }
}
