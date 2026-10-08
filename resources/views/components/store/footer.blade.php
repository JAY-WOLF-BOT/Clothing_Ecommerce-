@php
    $navCategories = app(\App\Support\Navigation::class)->categories();
    $whatsapp = preg_replace('/\D/', '', (string) config('store.whatsapp'));
@endphp

<footer class="border-t border-line bg-mist/60">
    <div class="shell grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-4">

        <div class="sm:col-span-2 lg:col-span-1">
            <p class="font-display text-base font-extrabold uppercase tracking-[-0.02em]">
                {{ config('store.name') }}
            </p>
            <p class="mt-3 max-w-xs text-sm leading-relaxed text-muted">
                Womenswear priced in cedis. We sell every day on Instagram and WhatsApp, and this
                site is where the collection now lives.
            </p>
        </div>

        <div>
            <p class="micro text-muted">Shop</p>
            <ul class="mt-4 space-y-2.5 text-sm">
                @foreach ($navCategories as $category)
                    <li>
                        <a href="{{ route('category.show', $category) }}" class="link text-ink/80 hover:text-ink">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <p class="micro text-muted">Orders</p>
            <ul class="mt-4 space-y-2.5 text-sm text-muted">
                <li>
                    <a href="https://wa.me/{{ $whatsapp }}" rel="noopener" class="link inline-flex items-center gap-2 text-ink/80 hover:text-ink">
                        <x-icon name="chat" class="h-4 w-4 shrink-0" />
                        Ask on WhatsApp
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center rounded-md bg-ink px-3 py-1.5 text-sm font-medium text-paper transition hover:bg-ink/90">
                        Admin dashboard
                    </a>
                </li>
                <li class="leading-relaxed">
                    The seller confirms stock, the delivery area and the total in the chat. Delivery
                    coverage and fees are not finalised yet.
                </li>
                <li class="leading-relaxed">
                    Online payment is being built — until it lands, WhatsApp is the only way to pay.
                </li>
            </ul>
        </div>

        <div>
            <p class="micro text-muted">About this build</p>
            <ul class="mt-4 space-y-2.5 text-sm leading-relaxed text-muted">
                <li>The brand name, catalogue, prices and photography are placeholders.</li>
                <li>Garments shown are stock images, and stock counts are illustrative.</li>
                <li>Nothing here should be read as this store's real offer.</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-line">
        <div class="shell flex flex-col gap-2 py-6 text-xs text-muted sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ config('store.name') }} — placeholder identity.</p>
            <p class="tabular">Prices shown in {{ config('store.currency.code') }}</p>
        </div>
    </div>
</footer>
