<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $products = Product::with(['category', 'variants'])
            ->orderByDesc('created_at')
            ->get();

        $totalProducts = $products->count();
        $inventoryUnits = (int) $products->sum(fn (Product $product) => $product->variants->sum('stock'));
        $inventoryValue = (int) $products->sum(function (Product $product) {
            $units = (int) $product->variants->sum('stock');

            return $units * $product->price;
        });
        $averagePrice = $totalProducts > 0 ? (int) round($products->avg('price')) : 0;
        $lowStockItems = $products->filter(fn (Product $product) => $product->variants->sum('stock') <= 3)->count();
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.dashboard', compact(
            'products',
            'totalProducts',
            'inventoryUnits',
            'inventoryValue',
            'averagePrice',
            'lowStockItems',
            'categories'
        ));
    }
}
