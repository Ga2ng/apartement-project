<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\UnitDateRate;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitDateRateController extends Controller
{
    public function index(Request $request): View
    {
        $query = UnitDateRate::with('unit')->orderBy('date')->orderBy('unit_id');

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }
        if ($request->filled('from')) {
            $query->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('date', '<=', $request->to);
        }

        $dateRates = $query->paginate(20)->withQueryString();
        $units = Unit::where('is_active', true)->orderBy('unit_number')->get(['id', 'unit_number']);

        return view('admin.date-rates.index', compact('dateRates', 'units'));
    }

    public function create(): View
    {
        $units = Unit::where('is_active', true)->orderBy('unit_number')->get(['id', 'unit_number']);
        return view('admin.date-rates.create', compact('units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'date' => 'nullable|date',
            'amount' => 'required|numeric|min:0',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        if (! empty($valid['from_date']) && ! empty($valid['to_date'])) {
            $from = Carbon::parse($valid['from_date']);
            $to = Carbon::parse($valid['to_date']);
            $amount = (float) $valid['amount'];
            $unitId = (int) $valid['unit_id'];
            $count = 0;
            for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
                UnitDateRate::updateOrCreate(
                    ['unit_id' => $unitId, 'date' => $d->toDateString()],
                    ['amount' => $amount, 'currency' => 'IDR']
                );
                $count++;
            }
            return redirect()->route('admin.date-rates.index')->with('status', "Harga untuk {$count} tanggal berhasil disimpan.");
        }

        if (empty($valid['date'])) {
            return redirect()->back()->withErrors(['date' => 'Isi satu tanggal atau rentang dari–sampai.'])->withInput();
        }

        UnitDateRate::updateOrCreate(
            [
                'unit_id' => $valid['unit_id'],
                'date' => $valid['date'],
            ],
            [
                'amount' => (float) $valid['amount'],
                'currency' => 'IDR',
            ]
        );
        return redirect()->route('admin.date-rates.index')->with('status', 'Harga untuk tanggal tersebut disimpan.');
    }

    public function destroy(UnitDateRate $dateRate): RedirectResponse
    {
        $dateRate->delete();
        return redirect()->route('admin.date-rates.index')->with('status', 'Harga dihapus.');
    }
}
