<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'color',
        'color_hex',
        'sku',
        'price_override',
        'stock_quantity',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price_override' => 'decimal:2',
            'stock_quantity' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->price_override ?? $this->product->price);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₦' . number_format($this->effective_price, 0);
    }

    public function getInStockAttribute(): bool
    {
        return $this->is_available && $this->stock_quantity > 0;
    }
}
