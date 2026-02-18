<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_deposit',
        'deposit_percentage',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_deposit' => 'boolean',
            'deposit_percentage' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'payment_type_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'payment_type_id');
    }
}
