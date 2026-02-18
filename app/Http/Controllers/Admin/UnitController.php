<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(): View
    {
        $units = Unit::with(['unitType', 'unitView', 'interiorType', 'owner'])
            ->orderBy('unit_number')
            ->get();

        return view('admin.units.index', compact('units'));
    }

    /**
     * Kamar yang tersedia (is_available = true, is_active = true).
     */
    public function available(): View
    {
        $units = Unit::with(['unitType', 'unitView', 'interiorType', 'owner'])
            ->where('is_active', true)
            ->where('is_available', true)
            ->orderBy('unit_number')
            ->get();

        return view('admin.units.available', compact('units'));
    }
}
