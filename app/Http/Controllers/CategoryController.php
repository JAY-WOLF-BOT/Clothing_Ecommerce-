<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public const SORTS = [
        'curated' => 'Curated',
        'newest' => 'Newest',
        'price-asc' => 'Price: low to high',
        'price-desc' => 'Price: high to low',
    ];

    public function __invoke(Category $category, Request $request): View
    {
        $sort = $request->string('sort')->toString() ?: 'curated';
        $size = $request->string('size')->toString() ?: null;
        $colour = $request->string('colour')->toString() ?: null;

        if (! array_key_exists($sort, self::SORTS)) {
            $sort = 'curated';
        }

        $scope = Product::query()
            ->when(
                $category->is_sale,
                fn ($query) => $query->onSale(),
                fn ($query) => $query->where('category_id', $category->id),
            );

        $products = $scope
            ->clone()
            ->with(['images', 'variants'])
            ->colour($colour)
            ->size($size)
            ->sort($sort)
            ->paginate(9)
            ->withQueryString();

        // Filter options come from what this category actually holds, so the
        // bar never offers a size that returns nothing.
        $colours = $scope->clone()->whereNotNull('colour')->distinct()->orderBy('colour')->pluck('colour');

        $sizes = ProductVariant::query()
            ->whereIn('product_id', $scope->clone()->pluck('id'))
            ->where('stock', '>', 0)
            ->distinct()
            ->orderBy('position')
            ->pluck('size')
            ->unique()
            ->values();

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
            'colours' => $colours,
            'sizes' => $sizes,
            'sorts' => self::SORTS,
            'activeSort' => $sort,
            'activeSize' => $size,
            'activeColour' => $colour,
            'total' => $scope->clone()->count(),
        ]);
    }
}
