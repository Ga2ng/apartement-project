<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * Public list of rooms/units with specifications (no login).
     */
    public function index(): View
    {
        $units = Unit::with(['unitType', 'unitView', 'interiorType', 'owner'])
            ->where('is_active', true)
            ->orderBy('unit_number')
            ->get();

        $units->each(function (Unit $unit) {
            $baseRate = $unit->baseRates()->where('is_active', true)->orderByDesc('effective_from')->first();
            $unit->setAttribute('from_price', $baseRate ? (float) $baseRate->daily_rate : null);
        });

        return view('rooms.index', compact('units'));
    }
}
