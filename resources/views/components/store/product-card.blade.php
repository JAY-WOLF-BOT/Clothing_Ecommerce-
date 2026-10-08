@props(['product', 'index' => 0, 'eager' => false])

@php
    $image = $product->primaryImage();
    $soldOut = ! $product->inStock();
@endphp

<a href="{{ route('product.show', $product) }}"
   class="card card-interactive reveal group block overflow-hidden"
   style="--reveal-i: {{ $index }}">

    <div class="relative aspect-[4/5] overflow-hidden bg-mist">
        @if ($image)
            <img src="{{ $image->path }}"
                 alt="{{ $image->alt ?? $product->name }}"
                 width="1100" height="1375"
                 loading="{{ $eager ? 'eager' : 'lazy' }}"
                 decoding="async"
                 class="h-full w-full object-cover">
        @endif

        <div class="absolute left-3 top-3 flex flex-col items-start gap-2">
            @if ($product->isOnSale())
                <x-store.badge tone="signal" :label="$product->discountPercent().'% off'" />
            @elseif ($product->badge)
                <x-store.badge tone="paper" :label="$product->badge" />
            @endif

            @if ($soldOut)
                <x-store.badge tone="ink" label="Sold out" />
            @endif
        </div>
    </div>

    <div class="p-4">
        <h3 class="font-display text-[0.9375rem] font-bold leading-snug tracking-[-0.015em] text-ink">
            {{ $product->name }}
        </h3>

        @if ($product->series)
            <p class="mt-1.5 text-xs text-muted">{{ $product->series }}</p>
        @endif

        <div class="mt-3 flex items-center justify-between gap-3">
            <x-store.price :product="$product" />

            <span class="flex items-center gap-1.5 text-xs font-semibold text-muted transition group-hover:text-ink">
                {{ $soldOut ? 'View' : 'Take a size' }}
                <x-icon name="arrow-right" class="h-3.5 w-3.5 transition duration-300 ease-expo group-hover:translate-x-0.5" />
            </span>
        </div>
    </div>
</a>
