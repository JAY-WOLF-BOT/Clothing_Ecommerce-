@props(['product', 'id' => null, 'quantity' => 1])

@php
    $fieldId = 'size-'.($id ?? $product->id);
    $sizes = $product->variants->where('stock', '>', 0)->pluck('size');
    $whatsapp = preg_replace('/\D/', '', (string) config('store.whatsapp'));
@endphp

@if ($sizes->isEmpty())
    <a href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode('Hello — when will the '.$product->name.' be back in stock?') }}"
       rel="noopener"
       {{ $attributes->merge(['class' => 'btn btn-secondary btn-sm']) }}>
        Ask
    </a>
@else
    <form method="POST"
          action="{{ route('bag.store') }}"
          data-bag-add
          {{ $attributes->merge(['class' => 'flex items-center gap-1.5']) }}>
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="{{ $quantity }}">

        <label class="sr-only" id="{{ $fieldId }}-label" for="{{ $fieldId }}">Size for {{ $product->name }}</label>
        <x-store.select name="size"
                        id="{{ $fieldId }}"
                        tone="xs"
                        :options="$sizes->all()"
                        labelledby="{{ $fieldId }}-label" />

        <button type="submit" class="btn btn-primary btn-sm">Add</button>
    </form>
@endif
