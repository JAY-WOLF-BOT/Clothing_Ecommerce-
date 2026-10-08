<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        $product->load(['images', 'variants', 'category']);

        $related = Product::with(['images', 'variants'])
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->orderBy('position')
            ->take(3)
            ->get();

        return view('products.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }
}
