@extends('layouts.app')

@section('title', 'Checkout — '.config('store.name'))
@section('description', 'Confirm your details and send the order on WhatsApp.')

@php
    $whatsapp = preg_replace('/\D/', '', (string) config('store.whatsapp'));
    $pieces = collect($lines)->sum('quantity');

    // The message travels with the form. Without scripting the picker opens
    // WhatsApp carrying the order; with scripting the shopper's own details
    // are woven into the same message.
    $orderText = "Hello — I would like to order:\n"
        .collect($lines)->map(fn ($line) => '• '.$line['quantity'].'× '.$line['product']->name.' (size '.$line['size'].') — '.\App\Support\Money::format($line['total']))->implode("\n")
        ."\nSubtotal: ".\App\Support\Money::format($subtotal);
@endphp

@section('content')
    <section class="shell pt-8">

        <nav class="flex flex-wrap items-center gap-2 text-xs text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="link hover:text-ink">Home</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('bag.index') }}" class="link hover:text-ink">Bag</a>
            <span aria-hidden="true">/</span>
            <span class="text-ink">Checkout</span>
        </nav>

        <header class="mt-5 border-b border-line pb-6">
            <h1 class="font-display text-[1.9rem] font-extrabold tracking-[-0.035em] text-ink sm:text-[2.2rem]">
                Checkout
            </h1>

            {{-- Where the shopper is in the flow, stated plainly. --}}
            <ol class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs">
                @foreach ([
                    ['1', 'Bag', true],
                    ['2', 'Your details', true],
                    ['3', 'WhatsApp', false],
                ] as [$step, $label, $done])
                    <li class="flex items-center gap-2">
                        <span @class([
                            'tabular flex h-5 w-5 items-center justify-center rounded-full text-[0.6875rem] font-bold',
                            'bg-ink text-paper' => $done,
                            'border border-line text-muted' => ! $done,
                        ])>
                            @if ($done)
                                <x-icon name="check" class="h-3 w-3" />
                            @else
                                {{ $step }}
                            @endif
                        </span>
                        <span class="{{ $done ? 'font-semibold text-ink' : 'text-muted' }}">{{ $label }}</span>
                    </li>
                    @unless ($loop->last)
                        <li aria-hidden="true" class="text-line-strong">—</li>
                    @endunless
                @endforeach
            </ol>
        </header>

        <div class="mt-8 grid gap-10 lg:grid-cols-12 lg:gap-12">

            <form method="GET"
                  action="https://wa.me/{{ $whatsapp }}"
                  target="_blank"
                  rel="noopener"
                  data-order-form
                  class="lg:col-span-7">
                <input type="hidden" name="text" value="{{ $orderText }}" data-order-text>

                <div class="space-y-6">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="order-name" class="micro text-muted">Full name</label>
                            <input id="order-name"
                                   name="name"
                                   type="text"
                                   required
                                   autocomplete="name"
                                   data-order-name
                                   placeholder="Ama Mensah"
                                   class="field mt-2">
                        </div>

                        <div>
                            <label for="order-phone" class="micro text-muted">WhatsApp number</label>
                            <input id="order-phone"
                                   name="phone"
                                   type="tel"
                                   required
                                   autocomplete="tel"
                                   inputmode="tel"
                                   data-order-phone
                                   placeholder="024 000 0000"
                                   class="field mt-2">
                        </div>
                    </div>

                    <div>
                        <label for="order-area" class="micro text-muted">Delivery area</label>
                        <select id="order-area" name="area" data-order-area class="field mt-2">
                            @foreach ($deliveryAreas as $area)
                                <option value="{{ $area }}">{{ $area }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-muted">
                            Indicative only — the seller confirms coverage and the fee in the chat.
                        </p>
                    </div>

                    <div>
                        <label for="order-note" class="micro text-muted">Anything the seller should know</label>
                        <textarea id="order-note"
                                  name="note"
                                  rows="3"
                                  data-order-note
                                  placeholder="Colour preference, a landmark for delivery, or a question about fit."
                                  class="field mt-2 resize-y"></textarea>
                    </div>

                    <div class="flex items-start gap-3 rounded-card border border-line bg-mist/50 p-4">
                        <x-icon name="hand" class="mt-0.5 h-4 w-4 shrink-0 text-muted" />
                        <p class="text-xs leading-relaxed text-muted">
                            These details are not saved on this site. They are written into the WhatsApp
                            message and nowhere else.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <x-icon name="chat" class="h-4 w-4" />
                        Send this order on WhatsApp
                    </button>

                    <a href="{{ route('bag.index') }}" class="link block text-center text-xs font-semibold text-muted hover:text-ink">
                        Back to your bag
                    </a>
                </div>
            </form>

            <aside class="lg:col-span-5">
                <div class="card p-5 lg:sticky lg:top-24">
                    <div class="flex items-baseline justify-between gap-3">
                        <h2 class="font-display text-base font-extrabold tracking-[-0.02em] text-ink">Your order</h2>
                        <a href="{{ route('bag.index') }}" class="link text-xs font-semibold text-muted hover:text-ink">Edit</a>
                    </div>

                    <p class="tabular mt-1.5 text-xs text-muted">
                        {{ $pieces }} {{ $pieces === 1 ? 'piece' : 'pieces' }} · {{ count($lines) }} {{ count($lines) === 1 ? 'style' : 'styles' }}
                    </p>

                    <ul class="mt-5 space-y-4">
                        @foreach ($lines as $line)
                            <li class="flex gap-3">
                                @if ($line['product']->primaryImageUrl())
                                    <img src="{{ $line['product']->primaryImageUrl() }}"
                                         alt="{{ $line['product']->primaryImage()?->alt ?? $line['product']->name }}"
                                         width="1100" height="1375"
                                         loading="lazy" decoding="async"
                                         class="h-16 w-12 shrink-0 rounded-[9px] object-cover">
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-xs font-semibold text-ink">{{ $line['product']->name }}</p>
                                    <p class="mt-1 text-xs text-muted">
                                        Size {{ $line['size'] }} · <span class="tabular">Qty {{ $line['quantity'] }}</span>
                                    </p>
                                </div>
                                <p class="tabular shrink-0 text-xs font-semibold text-ink">
                                    {{ \App\Support\Money::format($line['total']) }}
                                </p>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="mt-5 space-y-3 border-t border-line pt-4 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-muted">Subtotal</dt>
                            <dd class="tabular font-semibold text-ink">{{ \App\Support\Money::format($subtotal) }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-muted">Delivery</dt>
                            <dd class="text-right text-xs text-muted">Confirmed in the chat</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 border-t border-line pt-3">
                            <dt class="font-semibold text-ink">Total</dt>
                            <dd class="tabular font-bold text-ink">{{ \App\Support\Money::format($subtotal) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-5 flex items-start gap-3 rounded-control bg-mist p-3.5">
                        <x-icon name="alert" class="mt-0.5 h-4 w-4 shrink-0 text-muted" />
                        <p class="text-xs leading-relaxed text-muted">
                            <span class="font-semibold text-ink">Paying online is not live yet.</span>
                            Sending the order opens WhatsApp; the seller confirms stock, delivery area
                            and the total, then takes payment there.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
