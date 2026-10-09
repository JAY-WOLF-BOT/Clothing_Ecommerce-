@php
    use App\Support\Money;
@endphp

@extends('layouts.app')

@section('title', 'Admin dashboard')

@section('content')
    <div class="shell py-10">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-muted">Operations</p>
                <h1 class="mt-2 font-display text-3xl font-bold tracking-[-0.04em] text-ink">Admin dashboard</h1>
            </div>

            <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-full sm:w-auto">Add product</a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-line bg-white p-5 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-[0.18em] text-muted">Total products</p>
                <div class="mt-4 flex items-end justify-between gap-3">
                    <span class="font-display text-3xl font-bold text-ink">{{ $totalProducts }}</span>
                    <span class="rounded-full bg-mist px-2 py-1 text-xs font-medium text-muted">Live</span>
                </div>
            </div>

            <div class="rounded-2xl border border-line bg-white p-5 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-[0.18em] text-muted">Inventory units</p>
                <div class="mt-4 flex items-end justify-between gap-3">
                    <span class="font-display text-3xl font-bold text-ink">{{ number_format($inventoryUnits) }}</span>
                    <span class="rounded-full bg-mist px-2 py-1 text-xs font-medium text-muted">Stock</span>
                </div>
            </div>

            <div class="rounded-2xl border border-line bg-white p-5 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-[0.18em] text-muted">Inventory value</p>
                <div class="mt-4 flex items-end justify-between gap-3">
                    <span class="font-display text-3xl font-bold text-ink">{{ Money::format($inventoryValue) }}</span>
                    <span class="rounded-full bg-mist px-2 py-1 text-xs font-medium text-muted">Value</span>
                </div>
            </div>

            <div class="rounded-2xl border border-line bg-white p-5 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-[0.18em] text-muted">Avg. price</p>
                <div class="mt-4 flex items-end justify-between gap-3">
                    <span class="font-display text-3xl font-bold text-ink">{{ Money::format($averagePrice) }}</span>
                    <span class="rounded-full bg-mist px-2 py-1 text-xs font-medium text-muted">Avg</span>
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-6 xl:grid-cols-[1.6fr_0.8fr]">
            <div class="rounded-2xl border border-line bg-white shadow-sm">
                <div class="flex flex-col gap-2 border-b border-line px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="font-display text-xl font-bold text-ink">Products</h2>
                    <a href="{{ route('admin.products.create') }}" class="text-sm font-semibold text-ink underline-offset-4 hover:underline">New product</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-190 text-left">
                        <thead class="bg-mist text-xs uppercase tracking-[0.16em] text-muted">
                            <tr>
                                <th class="px-5 py-3 font-medium">Product</th>
                                <th class="px-5 py-3 font-medium">Category</th>
                                <th class="px-5 py-3 font-medium">Price</th>
                                <th class="px-5 py-3 font-medium">Stock</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                                <th class="px-5 py-3 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                @php
                                    $stockTotal = (int) $product->variants->sum('stock');
                                @endphp
                                <tr class="border-t border-line align-middle">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-ink text-sm font-semibold text-white">
                                                {{ strtoupper(substr($product->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-ink">{{ $product->name }}</p>
                                                <p class="text-xs text-muted">{{ $product->slug }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-muted">{{ $product->category?->name ?? 'Unassigned' }}</td>
                                    <td class="px-5 py-4 text-sm font-medium text-ink">{{ Money::format($product->price) }}</td>
                                    <td class="px-5 py-4 text-sm text-muted">{{ $stockTotal }}</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center whitespace-nowrap rounded-md border px-2.5 py-1 text-[0.68rem] font-semibold tracking-[0.08em] uppercase {{ $stockTotal > 0 ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
                                            {{ $stockTotal > 0 ? 'In stock' : 'Out of stock' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-secondary btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-sm text-muted">No products yet. Add the first one to get started.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-line bg-white p-5 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink">Category mix</h3>
                    <ul class="mt-4 space-y-3">
                        @foreach ($categories as $category)
                            <li class="flex items-center justify-between gap-3 text-sm">
                                <span class="text-muted">{{ $category->name }}</span>
                                <span class="rounded-full bg-mist px-2 py-1 text-xs font-semibold text-ink">{{ $category->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-2xl border border-line bg-white p-5 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink">Alerts</h3>
                    <div class="mt-4 rounded-xl bg-amber-50 p-3 text-sm text-amber-900">
                        {{ $lowStockItems }} product{{ $lowStockItems === 1 ? '' : 's' }} are low on stock.
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
