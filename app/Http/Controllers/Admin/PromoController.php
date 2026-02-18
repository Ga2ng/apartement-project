<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function index(): View
    {
        $promos = Promo::orderByDesc('valid_until')->paginate(15);

        return view('admin.promos.index', compact('promos'));
    }

    public function create(): View
    {
        return view('admin.promos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'code' => 'required|string|max:50|unique:promos,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_stay_nights' => 'nullable|integer|min:1',
            'min_amount' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $valid['is_active'] = $request->boolean('is_active');
        Promo::create($valid);
        return redirect()->route('admin.promos.index')->with('status', 'Promo created.');
    }

    public function edit(Promo $promo): View
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo): RedirectResponse
    {
        $valid = $request->validate([
            'code' => 'required|string|max:50|unique:promos,code,' . $promo->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_stay_nights' => 'nullable|integer|min:1',
            'min_amount' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $valid['is_active'] = $request->boolean('is_active');
        $promo->update($valid);
        return redirect()->route('admin.promos.index')->with('status', 'Promo updated.');
    }
}
