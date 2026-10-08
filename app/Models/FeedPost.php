<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedPost extends Model
{
    protected $fillable = [
        'kind', 'caption', 'place', 'badge', 'badge_tone',
        'is_placeholder', 'published_at', 'position',
    ];

    protected $casts = [
        'is_placeholder' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(FeedPostImage::class)->orderBy('position');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('position')->orderBy('feed_post_product.position');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereNull('published_at')->orWhere('published_at', '<=', now());
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderByDesc('published_at');
    }

    public function coverImage(): ?string
    {
        return $this->images->first()?->path;
    }

    public function relativeTime(): string
    {
        return $this->published_at?->diffForHumans(short: true) ?? 'Just now';
    }
}
