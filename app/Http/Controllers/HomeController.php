<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FeedPost;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Category::ordered()->get();

        $posts = FeedPost::published()
            ->ordered()
            ->with(['images', 'products.images', 'products.variants'])
            ->take(5)
            ->get();

        $heroPost = $posts->first();

        $featured = Product::with(['images', 'variants'])
            ->where('is_featured', true)
            ->orderBy('position')
            ->take(3)
            ->get();

        return view('home', [
            'categories' => $categories,
            'posts' => $posts,
            'heroPost' => $heroPost,
            'heroProduct' => $heroPost?->products->first(),
            'featured' => $featured,
            // Illustrative stock, summed from the seeded variants.
            'piecesInStock' => (int) ProductVariant::where('stock', '>', 0)->sum('stock'),
        ]);
    }
}
