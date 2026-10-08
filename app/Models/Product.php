<?php

namespace App\Models;

use App\Support\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'series', 'description', 'details',
        'price', 'compare_at_price', 'badge', 'colour', 'is_featured', 'position',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('position');
    }

    public function feedPosts(): BelongsToMany
    {
        return $this->belongsToMany(FeedPost::class)->withPivot('position');
    }

    /* ---------------------------------------------------------------------
     | Sorting and filtering
     --------------------------------------------------------------------- */

    public function scopeSort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price-asc' => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'newest' => $query->orderByDesc('created_at')->orderByDesc('id'),
            default => $query->orderBy('position')->orderBy('name'),
        };
    }

    public function scopeColour(Builder $query, ?string $colour): Builder
    {
        return $colour ? $query->where('colour', $colour) : $query;
    }

    public function scopeSize(Builder $query, ?string $size): Builder
    {
        return $size
            ? $query->whereHas('variants', fn (Builder $q) => $q->where('size', $size)->where('stock', '>', 0))
            : $query;
    }

    public function scopeOnSale(Builder $query): Builder
    {
        return $query->whereNotNull('compare_at_price')->whereColumn('compare_at_price', '>', 'price');
    }

    /* ---------------------------------------------------------------------
     | Presentation helpers
     --------------------------------------------------------------------- */

    public function isOnSale(): bool
    {
        return $this->compare_at_price !== null && $this->compare_at_price > $this->price;
    }

    public function discountPercent(): int
    {
        if (! $this->isOnSale()) {
            return 0;
        }

        return (int) round((1 - $this->price / $this->compare_at_price) * 100);
    }

    public function priceLabel(): string
    {
        return Money::format($this->price);
    }

    public function compareAtLabel(): ?string
    {
        return $this->compare_at_price ? Money::format($this->compare_at_price) : null;
    }

    public function primaryImage(): ?ProductImage
    {
        return $this->images->first();
    }

    public function primaryImageUrl(): ?string
    {
        return $this->images->first()?->path;
    }

    public function inStock(): bool
    {
        return $this->variants->contains(fn (ProductVariant $v) => $v->stock > 0);
    }

    public function stockFor(string $size): int
    {
        return (int) $this->variants->firstWhere('size', $size)?->stock;
    }
}
