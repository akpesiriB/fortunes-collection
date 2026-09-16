<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HomepageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'type',
        'content',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('display_order');
    }
}
