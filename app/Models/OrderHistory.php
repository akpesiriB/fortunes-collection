<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'notes',
        'notified_customer',
        'action_by',
    ];

    protected function casts(): array
    {
        return [
            'notified_customer' => 'boolean',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
