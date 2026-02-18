<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unit_number',
        'building_tower',
        'floor_level',
        'room_number',
        'unit_type_id',
        'unit_view_id',
        'interior_type_id',
        'owner_id',
        'rental_status',
        'occupancy_count',
        'issues',
        'notes',
        'is_active',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_available' => 'boolean',
        ];
    }

    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class);
    }

    public function unitView(): BelongsTo
    {
        return $this->belongsTo(UnitView::class);
    }

    public function interiorType(): BelongsTo
    {
        return $this->belongsTo(InteriorType::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function baseRates(): HasMany
    {
        return $this->hasMany(UnitBaseRate::class, 'unit_id');
    }

    public function dateRates(): HasMany
    {
        return $this->hasMany(UnitDateRate::class, 'unit_id');
    }
}
