@extends('layouts.app')

@section('title', config('store.name').' — womenswear, priced in cedis')
@section('description', 'Browse the collection, take a size, and send your order on WhatsApp. Prices in Ghanaian cedis.')

@php($whatsapp = preg_replace('/\D/', '', (string) config('store.whatsapp')))

@section('content')

    {{-- FIRST VIEWPORT — the store's own latest post, at the scale it has in the
         feed, with the garment taken straight out of it. --}}
    <section class="shell pt-8 sm:pt-12">
        <div class="grid gap-8 lg:grid-cols-12 lg:gap-10">

            <div class="lg:col-span-7 xl:col-span-8">
                @if ($heroPost)
                    @php($heroImage = $heroPost->images->first())
                    <div class="reveal relative overflow-hidden rounded-card bg-ink">
                        @if ($heroImage)
                            <img src="{{ $heroImage->path }}"
                                 alt="{{ $heroImage->alt ?? 'Latest post' }}"
                                 width="1200" height="1500"
                                 fetchpriority="high" decoding="async"
                                 class="h-96 w-full object-cover sm:h-124 lg:h-140">
                        @endif

                        <div class="absolute left-4 top-4 flex flex-wrap items-center gap-2">
                            <span class="chip bg-ink/85 text-paper">Latest post</span>
                            @if ($heroPost->badge)
                                <x-store.badge tone="paper" :label="$heroPost->badge" />
                            @endif
                        </div>

                        @if ($heroProduct)
                            <div class="absolute inset-x-3 bottom-3 sm:inset-x-4 sm:bottom-4">
                                <div class="card flex flex-wrap items-center gap-3 border-transparent p-3 shadow-lift sm:gap-4 sm:p-4">
                                    <div class="min-w-0 flex-1">
                                        @if ($heroProduct->series)
                                            <p class="micro text-muted">{{ $heroProduct->series }}</p>
                                        @endif
                                        <a href="{{ route('product.show', $heroProduct) }}"
                                           class="link mt-1 line-clamp-2 font-display text-[0.9375rem] font-bold tracking-[-0.015em] text-ink">
                                            {{ $heroProduct->name }}
                                        </a>
                                    </div>

                                    <x-store.price :product="$heroProduct" />

                                    <x-store.add-to-bag :product="$heroProduct" id="hero" class="shrink-0" />
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="lg:col-span-5 xl:col-span-4">
                <h1 class="font-display text-[1.9rem] font-extrabold leading-[1.06] tracking-[-0.035em] text-ink sm:text-[2.4rem]">
                    Womenswear, priced in cedis.
                </h1>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-muted">
                    This is where the collection lives now. Take the garment straight out of the post,
                    take your size, and send the order on WhatsApp — the way you already buy from us.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#collection" class="btn btn-primary">
                        Shop the collection
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('bag.index') }}" class="btn btn-secondary">
                        <x-icon name="bag" class="h-4 w-4" />
                        Your bag
                    </a>
                </div>

                <dl class="mt-9 grid grid-cols-2 gap-x-6 gap-y-5 border-t border-line pt-6">
                    @foreach ([
                        ['Currency', 'Cedis (GH₵)'],
                        ['Checkout', 'WhatsApp today'],
                        ['In stock', $piecesInStock.' pieces'],
                        ['Delivery', 'Confirmed in chat'],
                    ] as [$label, $value])
                        <div>
                            <dt class="micro text-muted">{{ $label }}</dt>
                            <dd class="tabular mt-1.5 text-sm font-semibold text-ink">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </section>

    {{-- THE FEED — the spine of this storefront. --}}
    @if ($posts->count() > 1)
        <section id="feed" class="shell mt-20 sm:mt-24">
            <div class="flex flex-wrap items-end justify-between gap-3 border-b border-line pb-4">
                <h2 class="font-display text-xl font-extrabold tracking-tight text-ink sm:text-2xl">
                    From the feed
                </h2>
                <p class="text-xs text-muted">The channel you already shop us from, now shoppable in place</p>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($posts->skip(1) as $post)
                    <x-store.feed-post :post="$post" :index="$loop->index" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- IN STOCK --}}
    @if ($featured->isNotEmpty())
        <section id="collection" class="shell mt-20 sm:mt-24">
            <div class="flex flex-wrap items-end justify-between gap-3 border-b border-line pb-4">
                <h2 class="font-display text-xl font-extrabold tracking-tight text-ink sm:text-2xl">
                    In stock now
                </h2>
                <a href="{{ route('category.show', $categories->firstWhere('slug', 'dresses') ?? $categories->first()) }}"
                   class="link inline-flex items-center gap-1.5 py-1 text-sm font-semibold text-ink">
                    Browse everything
                    <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $product)
                    <x-store.product-card :product="$product" :index="$loop->index" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- CATEGORIES --}}
    <section class="shell mt-20 sm:mt-24">
        <div class="border-b border-line pb-4">
            <h2 class="font-display text-xl font-extrabold tracking-tight text-ink sm:text-2xl">
                Shop by category
            </h2>
        </div>

        <div class="mt-8 grid gap-5 sm:grid-cols-2">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category) }}"
                   class="card card-interactive reveal group flex items-start justify-between gap-4 p-5"
                   style="--reveal-i: {{ $loop->index }}">
                    <span class="block">
                        <span class="block font-display text-lg font-bold tracking-[-0.02em] text-ink">
                            {{ $category->name }}
                        </span>
                        @if ($category->tagline)
                            <span class="mt-1.5 block max-w-sm text-xs leading-relaxed text-muted">
                                {{ $category->tagline }}
                            </span>
                        @endif
                    </span>
                    <x-icon name="arrow-up-right"
                            class="h-4 w-4 shrink-0 text-muted transition duration-300 ease-expo group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-ink" />
                </a>
            @endforeach
        </div>
    </section>

    {{-- CLOSE --}}
    <section class="shell mt-20 sm:mt-24">
        <div class="reveal grid gap-6 rounded-card bg-ink px-6 py-10 text-on-ink sm:grid-cols-[1.4fr_1fr] sm:items-end sm:px-10 sm:py-12">
            <div>
                <h2 class="font-display text-2xl font-extrabold tracking-[-0.03em] sm:text-3xl">
                    Every order finishes in a conversation.
                </h2>
                <p class="mt-3 max-w-lg text-sm leading-relaxed text-on-ink-muted">
                    Stock, the delivery area and the total are confirmed by the seller in the chat.
                    Online payment is being built — until it lands, WhatsApp is the only way to pay.
                </p>
            </div>
            <div class="flex flex-wrap gap-3 sm:justify-end">
                <a href="https://wa.me/{{ $whatsapp }}" rel="noopener" class="btn btn-inverse">
                    <x-icon name="chat" class="h-4 w-4" />
                    Open WhatsApp
                </a>
                <a href="{{ route('bag.index') }}"
                   class="btn border border-white/25 text-on-ink transition hover:border-white/60">
                    Review your bag
                </a>
            </div>
        </div>
    </section>
@endsection
