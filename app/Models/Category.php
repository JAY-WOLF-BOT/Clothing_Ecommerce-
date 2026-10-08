<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'tagline', 'is_sale', 'position'];

    protected $casts = [
        'is_sale' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('position');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
