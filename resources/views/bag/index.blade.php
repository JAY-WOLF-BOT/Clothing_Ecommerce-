@extends('layouts.app')

@section('title', 'Your bag — '.config('store.name'))
@section('description', 'Review your bag, then send the order on WhatsApp.')

@php
    $whatsapp = preg_replace('/\D/', '', (string) config('store.whatsapp'));
    $pieces = collect($lines)->sum('quantity');

    $orderText = "Hello — I would like to order:\n"
        .collect($lines)->map(fn ($line) => '• '.$line['quantity'].'× '.$line['product']->name.' (size '.$line['size'].') — '.\App\Support\Money::format($line['total']))->implode("\n")
        ."\nSubtotal: ".\App\Support\Money::format($subtotal);
@endphp

@section('content')
    <section class="shell pt-8">

        <nav class="flex items-center gap-2 text-xs text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="link hover:text-ink">Home</a>
            <span aria-hidden="true">/</span>
            <span class="text-ink">Bag</span>
        </nav>

        <header class="mt-5 flex flex-wrap items-end justify-between gap-3 border-b border-line pb-6">
            <h1 class="font-display text-[1.9rem] font-extrabold tracking-[-0.035em] text-ink sm:text-[2.2rem]">
                Your bag
            </h1>
            @if ($lines)
                <p class="tabular text-xs text-muted">
                    {{ $pieces }} {{ $pieces === 1 ? 'piece' : 'pieces' }} · {{ count($lines) }} {{ count($lines) === 1 ? 'style' : 'styles' }}
                </p>
            @endif
        </header>

        @if (empty($lines))
            <div class="mt-8">
                <x-store.empty-state icon="bag"
                                     title="Nothing in the bag yet"
                                     body="Take a garment from a post on the home feed, or browse a category, and it will wait here.">
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to the feed</a>
                </x-store.empty-state>
            </div>
        @else
            <div class="mt-8 grid gap-10 lg:grid-cols-12 lg:gap-12">

                <div class="lg:col-span-7 xl:col-span-8" data-bag-lines>
                    @foreach ($lines as $line)
                        @php($product = $line['product'])
                        <article class="flex gap-4 border-b border-line py-5 first:pt-0 sm:gap-5" data-bag-line="{{ $line['key'] }}">

                            <a href="{{ route('product.show', $product) }}" class="shrink-0">
                                @if ($product->primaryImageUrl())
                                    <img src="{{ $product->primaryImageUrl() }}"
                                         alt="{{ $product->primaryImage()?->alt ?? $product->name }}"
                                         width="1100" height="1375"
                                         loading="lazy" decoding="async"
                                         class="h-32 w-24 rounded-control object-cover sm:h-36 sm:w-28">
                                @endif
                            </a>

                            <div class="flex min-w-0 flex-1 flex-col">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        @if ($product->series)
                                            <p class="micro text-muted">{{ $product->series }}</p>
                                        @endif
                                        <a href="{{ route('product.show', $product) }}"
                                           class="link mt-1 block font-display text-[0.9375rem] font-bold tracking-[-0.015em] text-ink">
                                            {{ $product->name }}
                                        </a>
                                        <p class="mt-1.5 text-xs text-muted">
                                            Size {{ $line['size'] }}
                                            · <span class="tabular">{{ $line['stock'] }} left</span>
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="tabular text-[0.9375rem] font-semibold text-ink" data-line-total>
                                            {{ \App\Support\Money::format($line['total']) }}
                                        </p>
                                        <p class="tabular mt-1 text-xs text-muted">{{ \App\Support\Money::format($line['unit_price']) }} each</p>
                                    </div>
                                </div>

                                <div class="mt-auto flex flex-wrap items-center gap-3 pt-4">
                                    <form method="POST"
                                          action="{{ route('bag.update', $line['key']) }}"
                                          data-bag-qty
                                          data-key="{{ $line['key'] }}"
                                          data-stock="{{ $line['stock'] }}"
                                          class="button-group">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                name="quantity"
                                                value="{{ max(1, $line['quantity'] - 1) }}"
                                                @disabled($line['quantity'] <= 1)
                                                class="btn btn-secondary btn-icon">
                                            <x-icon name="minus" class="h-4 w-4" />
                                            <span class="sr-only">Reduce quantity of {{ $product->name }}</span>
                                        </button>

                                        <span class="button-group-text tabular w-10" data-line-qty>
                                            {{ $line['quantity'] }}
                                        </span>

                                        <button type="submit"
                                                name="quantity"
                                                value="{{ min($line['stock'], $line['quantity'] + 1) }}"
                                                @disabled($line['quantity'] >= $line['stock'])
                                                class="btn btn-secondary btn-icon">
                                            <x-icon name="plus" class="h-4 w-4" />
                                            <span class="sr-only">Increase quantity of {{ $product->name }}</span>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('bag.destroy', $line['key']) }}" data-bag-remove data-key="{{ $line['key'] }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="link inline-flex items-center gap-1.5 text-xs font-semibold text-muted transition hover:text-signal">
                                            <x-icon name="trash" class="h-3.5 w-3.5" />
                                            Remove
                                        </button>
                                    </form>

                                    @if ($line['quantity'] >= $line['stock'])
                                        <p class="text-xs text-muted">That is all we have left in this size.</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="lg:col-span-5 xl:col-span-4">
                    <div class="card p-5 lg:sticky lg:top-24">
                        <h2 class="font-display text-base font-extrabold tracking-[-0.02em] text-ink">Summary</h2>

                        <dl class="mt-5 space-y-3 text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-muted">Subtotal</dt>
                                <dd class="tabular font-semibold text-ink" data-bag-subtotal>{{ \App\Support\Money::format($subtotal) }}</dd>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-muted">Delivery</dt>
                                <dd class="text-right text-xs text-muted">Confirmed by the seller in the chat</dd>
                            </div>
                            <div class="flex items-center justify-between gap-4 border-t border-line pt-3">
                                <dt class="font-semibold text-ink">Total</dt>
                                <dd class="tabular font-bold text-ink" data-bag-total>{{ \App\Support\Money::format($subtotal) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 space-y-3">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block">
                                Continue to checkout
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>

                            <a href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode($orderText) }}"
                               rel="noopener"
                               class="btn btn-secondary btn-block">
                                <x-icon name="chat" class="h-4 w-4" />
                                Ask about this order
                            </a>
                        </div>

                        <p class="mt-4 text-xs leading-relaxed text-muted">
                            Online payment is not live yet. Sending the order opens WhatsApp with your
                            basket, and the seller confirms stock, delivery and the total there.
                        </p>
                    </div>
                </aside>
            </div>
        @endif
    </section>
@endsection
