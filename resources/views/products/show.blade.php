@extends('layouts.app')

@section('title', $product->name.' — '.config('store.name'))
@section('description', Str::limit($product->description, 150))

@php
    $whatsapp = preg_replace('/\D/', '', (string) config('store.whatsapp'));
    $available = $product->variants->where('stock', '>', 0);
    $firstAvailable = $available->first();
    $inStock = $available->isNotEmpty();
    $orderMessage = rawurlencode('Hello — I would like to order the '.$product->name.' ('.($firstAvailable->size ?? 'size to confirm').').');
@endphp

@section('content')
    <section class="shell pt-6">

        <nav class="flex flex-wrap items-center gap-2 text-xs text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="link hover:text-ink">Home</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('category.show', $product->category) }}" class="link hover:text-ink">{{ $product->category->name }}</a>
            <span aria-hidden="true">/</span>
            <span class="text-ink">{{ $product->name }}</span>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-12 lg:gap-12">

            {{-- Gallery --}}
            <div class="lg:col-span-7" data-gallery>
                <div class="relative overflow-hidden rounded-card bg-mist">
                    @if ($product->primaryImageUrl())
                        <img src="{{ $product->primaryImageUrl() }}"
                             alt="{{ $product->primaryImage()?->alt ?? $product->name }}"
                             width="1100" height="1375"
                             fetchpriority="high" decoding="async"
                             data-gallery-main
                             class="aspect-4/5 w-full object-cover">
                    @endif

                    @if ($product->isOnSale())
                        <span class="absolute left-4 top-4">
                            <x-store.badge tone="signal" :label="$product->discountPercent().'% off'" />
                        </span>
                    @endif
                </div>

                @if ($product->images->count() > 1)
                    <div class="mt-3 flex gap-3" role="group" aria-label="Product images">
                        @foreach ($product->images as $image)
                            <button type="button"
                                    data-gallery-thumb="{{ $loop->index }}"
                                    data-src="{{ $image->path }}"
                                    data-alt="{{ $image->alt ?? $product->name }}"
                                    @if ($loop->first) aria-current="true" @endif
                                    class="overflow-hidden rounded-control border border-line transition duration-300 ease-expo hover:border-ink aria-[current]:border-ink">
                                <img src="{{ $image->path }}"
                                     alt=""
                                     width="1100" height="1375"
                                     loading="lazy" decoding="async"
                                     class="h-20 w-16 object-cover sm:h-24 sm:w-20">
                                <span class="sr-only">Show image {{ $loop->iteration }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="lg:col-span-5">
                <h1 class="font-display text-[1.75rem] font-extrabold leading-tight tracking-[-0.035em] text-ink sm:text-[2rem]">
                    {{ $product->name }}
                </h1>

                @if ($product->series || $product->colour)
                    <p class="mt-2.5 text-xs text-muted">
                        {{ $product->series }}{{ $product->series && $product->colour ? ' · ' : '' }}{{ $product->colour }}
                    </p>
                @endif

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <x-store.price :product="$product" size="lg" />
                    @if ($inStock)
                        <span class="chip bg-mist text-muted">In stock</span>
                    @else
                        <span class="chip bg-signal-soft text-signal">Sold out</span>
                    @endif
                </div>

                <p class="mt-5 text-sm leading-relaxed text-muted">{{ $product->description }}</p>

                @if ($inStock)
                    <form method="POST" action="{{ route('bag.store') }}" data-bag-add data-size-form class="mt-7">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <fieldset>
                            <legend class="flex w-full items-baseline justify-between gap-3">
                                <span class="micro text-muted">Choose a size</span>
                                <a href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode('Hello — I need help with sizing for the '.$product->name.'.') }}"
                                   rel="noopener"
                                   class="link text-xs font-semibold text-muted hover:text-ink">
                                    Ask about fit
                                </a>
                            </legend>

                            <div class="button-group mt-3">
                                @foreach ($product->variants as $variant)
                                    <label class="segment">
                                        <input type="radio"
                                               name="size"
                                               value="{{ $variant->size }}"
                                               class="sr-only"
                                               @disabled(! $variant->available())
                                               @checked($variant->is($firstAvailable))>
                                        <span>{{ $variant->size }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- The segment shows a size is gone by striking it
                                 through; the word for it is written out here,
                                 where there is room to say it properly. --}}
                            @php($gone = $product->variants->reject->available())
                            @if ($gone->isNotEmpty())
                                <p class="mt-2.5 text-xs text-muted">
                                    Sold out in {{ $gone->pluck('size')->join(', ') }}.
                                </p>
                            @endif
                        </fieldset>

                        <div class="mt-6 flex items-center gap-4">
                            <span class="micro text-muted">Quantity</span>

                            <div class="input-group w-auto">
                                <input type="text"
                                       inputmode="numeric"
                                       name="quantity"
                                       value="1"
                                       data-qty-input
                                       aria-label="Quantity"
                                       class="input-group-control tabular w-9 shrink-0 px-0 py-2.75 text-center text-sm font-semibold">

                                <span class="input-group-addon" data-align="inline-start">
                                    <button type="button" data-qty-step="-1" class="input-group-button">
                                        <x-icon name="minus" class="h-4 w-4" />
                                        <span class="sr-only">Reduce quantity</span>
                                    </button>
                                </span>

                                <span class="input-group-addon" data-align="inline-end">
                                    <button type="button" data-qty-step="1" class="input-group-button">
                                        <x-icon name="plus" class="h-4 w-4" />
                                        <span class="sr-only">Increase quantity</span>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="mt-7 space-y-3">
                            <button type="submit" class="btn btn-primary btn-block">Add to bag</button>
                            <a href="https://wa.me/{{ $whatsapp }}?text={{ $orderMessage }}"
                               rel="noopener"
                               class="btn btn-secondary btn-block">
                                <x-icon name="chat" class="h-4 w-4" />
                                Order on WhatsApp
                            </a>
                        </div>

                        <p class="mt-3 text-xs leading-relaxed text-muted">
                            Your bag is kept for this session. Nothing is charged online yet — the seller
                            confirms stock, delivery and the total in the chat.
                        </p>
                    </form>
                @else
                    <div class="mt-7 rounded-card border border-line p-5">
                        <p class="text-sm font-semibold text-ink">Every size is gone.</p>
                        <p class="mt-2 text-sm leading-relaxed text-muted">
                            This piece sold out at the last drop. Ask on WhatsApp and we will tell you
                            when the next one lands.
                        </p>
                        <a href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode('Hello — please tell me when the '.$product->name.' is back in stock.') }}"
                           rel="noopener"
                           class="btn btn-primary btn-block mt-5">
                            <x-icon name="chat" class="h-4 w-4" />
                            Ask when it is back
                        </a>
                    </div>
                @endif

                {{-- The facts a shopper needs before paying, as an honest list. --}}
                <div class="mt-8 divide-y divide-line border-y border-line">
                    @if ($product->details)
                        <details class="group py-4">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-sm font-semibold text-ink marker:content-none">
                                Fabric &amp; care
                                <x-icon name="chevron-down" class="h-4 w-4 text-muted transition duration-300 ease-expo group-open:rotate-180" />
                            </summary>
                            <p class="mt-3 text-sm leading-relaxed text-muted">{{ $product->details }}</p>
                        </details>
                    @endif

                    <div class="flex items-start gap-3 py-4">
                        <x-icon name="truck" class="mt-0.5 h-4 w-4 shrink-0 text-muted" />
                        <div>
                            <p class="text-sm font-semibold text-ink">Delivery</p>
                            <p class="mt-1 text-sm leading-relaxed text-muted">
                                Delivery area and fee are confirmed by the seller in the chat. Coverage
                                is not finalised yet.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 py-4">
                        <x-icon name="mark" class="mt-0.5 h-4 w-4 shrink-0 text-muted" />
                        <div>
                            <p class="text-sm font-semibold text-ink">About this listing</p>
                            <p class="mt-1 text-sm leading-relaxed text-muted">
                                Placeholder garment: the photographs are stock images and the stock
                                counts are illustrative, not this store's real inventory.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related --}}
        @if ($related->isNotEmpty())
            <section class="mt-20">
                <div class="flex flex-wrap items-end justify-between gap-3 border-b border-line pb-4">
                    <h2 class="font-display text-xl font-extrabold tracking-tight text-ink">
                        More {{ strtolower($product->category->name) }}
                    </h2>
                    <a href="{{ route('category.show', $product->category) }}"
                       class="link inline-flex items-center gap-1.5 text-sm font-semibold text-ink">
                        All {{ strtolower($product->category->name) }}
                        <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                    </a>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-store.product-card :product="$item" :index="$loop->index" />
                    @endforeach
                </div>
            </section>
        @endif
    </section>
@endsection
