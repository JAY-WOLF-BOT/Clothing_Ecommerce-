@php
    $navCategories = app(\App\Support\Navigation::class)->categories();
    $bagCount = app(\App\Support\Bag::class)->count();
    $activeCategory = request()->routeIs('category.show') ? request()->route('category') : null;
@endphp

<header class="sticky top-0 z-40 border-b border-line bg-paper/95">
    <div class="shell flex h-16 items-center gap-3">

        <button type="button"
                data-drawer-open
                aria-controls="site-nav"
                aria-expanded="false"
                class="-ml-2 rounded-control p-2 text-ink transition hover:bg-mist lg:hidden">
            <x-icon name="menu" class="h-5 w-5" />
            <span class="sr-only">Open menu</span>
        </button>

        <a href="{{ route('home') }}"
           class="py-1 font-display text-[0.9375rem] font-extrabold uppercase tracking-[-0.02em] text-ink">
            {{ config('store.name') }}
        </a>

        <nav class="ml-5 hidden items-center gap-7 text-sm lg:flex" aria-label="Shop">
            @foreach ($navCategories as $category)
                @php($isActive = $activeCategory && $activeCategory->is($category))
                <a href="{{ route('category.show', $category) }}"
                   @if ($isActive) aria-current="page" @endif
                   class="link py-2 {{ $isActive ? 'font-semibold text-ink' : 'text-muted hover:text-ink' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </nav>

        <div class="ml-auto flex items-center gap-1">
            <a href="{{ route('bag.index') }}"
               class="relative rounded-control p-2.5 text-ink transition hover:bg-mist"
               aria-label="Your bag">
                <x-icon name="bag" class="h-5 w-5" />
                <span data-bag-count
                      @class([
                          'absolute -right-0.5 -top-0.5 flex h-[1.15rem] min-w-[1.15rem] items-center justify-center rounded-pill bg-ink px-[0.25rem] text-[0.6875rem] font-bold tabular text-paper',
                          'hidden' => $bagCount === 0,
                      ])>{{ $bagCount }}</span>
            </a>
        </div>
    </div>
</header>

<div id="site-nav" data-drawer hidden class="lg:hidden">
    <div class="fixed inset-0 z-50 flex">
        <button type="button"
                data-drawer-close
                class="absolute inset-0 cursor-default bg-ink/45"
                aria-label="Close menu"></button>

        <div class="drawer-in relative z-10 flex h-full w-[86%] max-w-sm flex-col border-r border-line bg-paper shadow-sheet">
            <div class="flex h-16 items-center justify-between border-b border-line px-5">
                <span class="font-display text-[0.9375rem] font-extrabold uppercase tracking-[-0.02em]">
                    {{ config('store.name') }}
                </span>
                <button type="button"
                        data-drawer-close
                        class="rounded-control p-2 text-ink transition hover:bg-mist">
                    <x-icon name="close" class="h-5 w-5" />
                    <span class="sr-only">Close menu</span>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-5 py-6" aria-label="Shop">
                <p class="micro mb-4 text-muted">Shop</p>
                <ul class="space-y-1">
                    @foreach ($navCategories as $category)
                        @php($isActive = $activeCategory && $activeCategory->is($category))
                        <li>
                            <a href="{{ route('category.show', $category) }}"
                               @if ($isActive) aria-current="page" @endif
                               class="flex items-baseline justify-between rounded-control px-3 py-3 font-display text-xl font-bold tracking-[-0.02em] transition hover:bg-mist {{ $isActive ? 'text-ink' : 'text-ink/85' }}">
                                {{ $category->name }}
                                <x-icon name="arrow-up-right" class="h-4 w-4 shrink-0 text-muted" />
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-8 border-t border-line pt-6">
                    <p class="micro mb-4 text-muted">Orders</p>
                    <a href="{{ route('bag.index') }}"
                       class="flex items-center gap-3 rounded-control px-3 py-3 text-sm font-semibold transition hover:bg-mist">
                        <x-icon name="bag" class="h-5 w-5" />
                        Your bag
                        <span data-bag-count-text class="ml-auto text-muted">{{ $bagCount }} item{{ $bagCount === 1 ? '' : 's' }}</span>
                    </a>
                </div>
            </nav>

            <div class="border-t border-line px-5 py-4">
                <p class="text-xs leading-relaxed text-muted">
                    Prices in cedis. Checkout is by WhatsApp while online payment is being built.
                </p>
            </div>
        </div>
    </div>
</div>
