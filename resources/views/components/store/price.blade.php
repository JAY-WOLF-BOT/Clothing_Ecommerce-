@props(['product', 'size' => 'base'])

@php
    $valueClass = match ($size) {
        'lg' => 'text-xl font-bold',
        'sm' => 'text-sm font-semibold',
        default => 'text-[0.9375rem] font-semibold',
    };
@endphp

@if ($product->isOnSale())
    <span class="flex items-baseline gap-2">
        <span class="tabular {{ $valueClass }} text-signal">{{ $product->priceLabel() }}</span>
        <span class="tabular text-xs text-muted line-through">{{ $product->compareAtLabel() }}</span>
    </span>
@else
    <span class="tabular {{ $valueClass }} text-ink">{{ $product->priceLabel() }}</span>
@endif
