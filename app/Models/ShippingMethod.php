<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'base_cost',
        'cost_per_kg',
        'free_shipping_min_amount',
        'estimated_delivery_days',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'base_cost' => 'decimal:2',
            'cost_per_kg' => 'decimal:2',
            'free_shipping_min_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
