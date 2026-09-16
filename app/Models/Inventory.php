<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'stock_count',
        'low_stock_threshold',
        'reserved_count',
    ];

    protected function casts(): array
    {
        return [
            'stock_count' => 'integer',
            'low_stock_threshold' => 'integer',
            'reserved_count' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function getAvailableStockAttribute(): int
    {
        return max(0, $this->stock_count - $this->reserved_count);
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock_count <= $this->low_stock_threshold && $this->stock_count > 0;
    }

    public function scopeLowStock(Builder $query): void
    {
        $query->whereRaw('stock_count <= low_stock_threshold AND stock_count > 0');
    }

    public function scopeOutOfStock(Builder $query): void
    {
        $query->where('stock_count', '<=', 0);
    }
}
