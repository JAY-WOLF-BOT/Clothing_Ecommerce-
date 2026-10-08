<?php

namespace App\Support;

use App\Models\Category;
use Illuminate\Support\Collection;

/**
 * The shop's categories, resolved once per request. Bound as a singleton so a
 * page with a header, a drawer and a footer still asks the database once.
 */
class Navigation
{
    private ?Collection $categories = null;

    /** @return Collection<int, Category> */
    public function categories(): Collection
    {
        return $this->categories ??= Category::ordered()->get();
    }
}
