<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING_PAYMENT = 'pending_payment';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CHECKED_IN = 'checked_in';
    public const STATUS_CHECKED_OUT = 'checked_out';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'booking_number',
        'unit_id',
        'client_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_id_type',
        'guest_id_number',
        'guest_address',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'total_nights',
        'status',
        'subtotal',
        'discount_amount',
        'promo_id',
        'tax_amount',
        'total_amount',
        'currency',
        'payment_type_id',
        'source',
        'special_requests',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function totalPaid(): float
    {
        return (float) $this->payments()->where('status', Payment::STATUS_PAID)->sum('amount');
    }

    public function balanceDue(): float
    {
        return max(0, (float) $this->total_amount - $this->totalPaid());
    }

    public function isFullyPaid(): bool
    {
        return $this->balanceDue() <= 0;
    }
}
