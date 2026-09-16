<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'subtitle',
        'short_description',
        'description',
        'details',
        'care_instructions',
        'size_guide',
        'price',
        'compare_at_price',
        'category_id',
        'collection_id',
        'is_featured',
        'is_new',
        'is_bestseller',
        'status',
        'featured_image',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_bestseller' => 'boolean',
            'view_count' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->latest();
    }

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₦' . number_format($this->price, 0);
    }

    public function getFormattedCompareAtPriceAttribute(): ?string
    {
        return $this->compare_at_price ? '₦' . number_format($this->compare_at_price, 0) : null;
    }

    public function getTotalStockAttribute(): int
    {
        return (int) $this->variants()->sum('stock_quantity');
    }

    public function getIsSoldOutAttribute(): bool
    {
        return $this->total_stock <= 0;
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) round($this->reviews()->avg('rating') ?: 5.0, 1);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('status', 'active')->where('is_featured', true);
    }

    public function scopeNewArrivals(Builder $query): void
    {
        $query->where('status', 'active')->where('is_new', true);
    }

    public function scopeBestSellers(Builder $query): void
    {
        $query->where('status', 'active')->where('is_bestseller', true);
    }
}
