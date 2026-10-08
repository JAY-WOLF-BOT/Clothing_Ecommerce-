@extends('layouts.app')

@section('title', $isEditing ? 'Edit product' : 'Create product')

@section('content')
    <div class="shell py-10">
        <div class="mb-6 flex items-center justify-between gap-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-muted">Catalogue</p>
                <h1 class="mt-2 font-display text-3xl font-bold tracking-[-0.04em] text-ink">{{ $isEditing ? 'Edit product' : 'Create product' }}</h1>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to dashboard</a>
        </div>

        <form method="POST" action="{{ $isEditing ? route('admin.products.update', $product) : route('admin.products.store') }}" class="mx-auto max-w-3xl rounded-2xl border border-line bg-white p-6 shadow-sm">
            @csrf
            @if ($isEditing)
                @method('PUT')
            @endif

            <div class="grid gap-5 md:grid-cols-2">
                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Name</span>
                    <input type="text" name="name" value="{{ old('name', $product?->name) }}" class="field" required>
                </label>

                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Slug</span>
                    <input type="text" name="slug" value="{{ old('slug', $product?->slug) }}" class="field" placeholder="example-product">
                </label>

                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Category</span>
                    <select name="category_id" class="field" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product?->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Price (GH₵)</span>
                    <input type="number" name="price" min="1" step="0.01" value="{{ old('price', $product ? number_format($product->price / 100, 2, '.', '') : '') }}" class="field" required>
                </label>

                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Compare at price (GH₵)</span>
                    <input type="number" name="compare_at_price" min="0" step="0.01" value="{{ old('compare_at_price', $product && $product->compare_at_price ? number_format($product->compare_at_price / 100, 2, '.', '') : '') }}" class="field">
                </label>

                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Stock</span>
                    <input type="number" name="stock" min="0" value="{{ old('stock', $product?->variants->sum('stock') ?? 0) }}" class="field" required>
                </label>

                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Colour</span>
                    <input type="text" name="colour" value="{{ old('colour', $product?->colour) }}" class="field" placeholder="Black">
                </label>

                <label class="space-y-2 md:col-span-1">
                    <span class="text-sm font-medium text-ink">Badge</span>
                    <input type="text" name="badge" value="{{ old('badge', $product?->badge) }}" class="field" placeholder="New">
                </label>

                <div class="md:col-span-1">
                    <label class="flex items-center gap-3 rounded-xl border border-line bg-mist px-3 py-3 text-sm font-medium text-ink">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product?->is_featured ? '1' : '') ? 'checked' : '' }} class="h-4 w-4 rounded border-line text-ink focus:ring-ink">
                        Mark as featured
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-ink">Description</span>
                        <textarea name="description" rows="5" class="field" required>{{ old('description', $product?->description) }}</textarea>
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-ink">Details</span>
                        <textarea name="details" rows="4" class="field" placeholder="Fabric, fit, care instructions">{{ old('details', $product?->details) }}</textarea>
                    </label>
                </div>
            </div>

            @if ($errors->any())
                <div class="mt-5 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Update product' : 'Create product' }}</button>
            </div>
        </form>
    </div>
@endsection
