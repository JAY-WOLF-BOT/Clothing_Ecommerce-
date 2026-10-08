<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\Money;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => null,
            'categories' => Category::orderBy('name')->get(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProduct($request);

        $product = Product::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'details' => $data['details'],
            'price' => Money::toPesewas((float) $data['price']),
            'compare_at_price' => $data['compare_at_price'] !== null && $data['compare_at_price'] !== ''
                ? Money::toPesewas((float) $data['compare_at_price'])
                : null,
            'badge' => $data['badge'] ?: null,
            'colour' => $data['colour'] ?: null,
            'is_featured' => (bool) $data['is_featured'],
            'position' => Product::max('position') + 1,
        ]);

        $product->variants()->firstOrCreate(
            ['size' => 'One Size'],
            ['stock' => max(0, (int) $data['stock']), 'position' => 0]
        );

        return redirect()->route('admin.dashboard')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validateProduct($request, $product);

        $product->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'details' => $data['details'],
            'price' => Money::toPesewas((float) $data['price']),
            'compare_at_price' => $data['compare_at_price'] !== null && $data['compare_at_price'] !== ''
                ? Money::toPesewas((float) $data['compare_at_price'])
                : null,
            'badge' => $data['badge'] ?: null,
            'colour' => $data['colour'] ?: null,
            'is_featured' => (bool) $data['is_featured'],
        ]);

        $product->variants()->updateOrCreate(
            ['size' => 'One Size'],
            ['stock' => max(0, (int) $data['stock']), 'position' => 0]
        );

        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully.');
    }

    protected function validateProduct(Request $request, ?Product $product = null): array
    {
        $slug = $request->input('slug');

        if (blank($slug)) {
            $slug = Str::slug($request->input('name'));
        }

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . ($product?->id ?? 'NULL') . ',id'],
            'description' => ['required', 'string'],
            'details' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'badge' => ['nullable', 'string', 'max:255'],
            'colour' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $data['slug'] = $slug;

        return $data;
    }
}
