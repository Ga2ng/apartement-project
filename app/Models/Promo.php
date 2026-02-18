<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_stay_nights',
        'min_amount',
        'valid_from',
        'valid_until',
        'max_uses',
        'used_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_amount' => 'decimal:2',
            'valid_from' => 'date',
            'valid_until' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function isValid(int $totalNights, float $subtotal): bool
    {
        if (! $this->is_active) {
            return false;
        }
        $now = now()->toDateString();
        if ($this->valid_from > $now || $this->valid_until < $now) {
            return false;
        }
        if ($this->min_stay_nights !== null && $totalNights < $this->min_stay_nights) {
            return false;
        }
        if ($this->min_amount !== null && (float) $subtotal < (float) $this->min_amount) {
            return false;
        }
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }
        return true;
    }
}
