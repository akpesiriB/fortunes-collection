<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address_id',
        'shipping_method',
        'status',
        'currency',
        'subtotal',
        'discount_amount',
        'shipping_fee',
        'tax_amount',
        'total_amount',
        'coupon_code',
        'payment_method',
        'payment_status',
        'tracking_number',
        'courier_name',
        'internal_notes',
        'customer_notes',
        'paid_at',
        'shipped_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'shipping_fee' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function getFormattedTotalAttribute(): string
    {
        return '₦' . number_format($this->total_amount, 0);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '₦' . number_format($this->subtotal, 0);
    }

    public function getFormattedShippingFeeAttribute(): string
    {
        return '₦' . number_format($this->shipping_fee, 0);
    }

    public function getFormattedDiscountAttribute(): string
    {
        return $this->discount_amount > 0 ? '-₦' . number_format($this->discount_amount, 0) : '₦0';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'paid' => 'bg-emerald-950/60 text-emerald-400 border-emerald-800/60',
            'processing' => 'bg-blue-950/60 text-blue-400 border-blue-800/60',
            'shipped' => 'bg-amber-950/60 text-amber-300 border-amber-800/60',
            'delivered' => 'bg-gold-500/20 text-[#D4AF37] border-[#D4AF37]/50',
            'cancelled' => 'bg-red-950/60 text-red-400 border-red-800/60',
            default => 'bg-neutral-900 text-neutral-400 border-neutral-700',
        };
    }

    public static function generateOrderNumber(): string
    {
        return 'FC-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
    }

    public function scopePaid(Builder $query): void
    {
        $query->where('status', 'paid');
    }

    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }
}
