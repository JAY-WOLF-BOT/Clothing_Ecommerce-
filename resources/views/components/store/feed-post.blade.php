@props(['post', 'index' => 0])

@php
    $images = $post->images;
    $products = $post->products;
@endphp

<article class="card reveal overflow-hidden" style="--reveal-i: {{ $index }}">

    {{-- Post header: who posted, and how long ago. --}}
    <div class="flex items-center gap-3 px-4 py-3.5">
        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-ink text-paper">
            <x-icon name="mark" class="h-4 w-4" />
        </span>
        <div class="min-w-0">
            <p class="truncate text-xs font-bold text-ink">{{ config('store.name') }}</p>
            <p class="text-xs text-muted">
                {{ $post->place ? $post->place.' · ' : '' }}<time datetime="{{ $post->published_at?->toIso8601String() }}">{{ $post->relativeTime() }}</time>
            </p>
        </div>
        @if ($post->badge)
            <span class="ml-auto shrink-0">
                <x-store.badge :tone="$post->badge_tone ?? 'mist'" :label="$post->badge" />
            </span>
        @endif
    </div>

    {{-- Media --}}
    @if ($images->isNotEmpty())
        <div class="relative bg-mist" data-carousel>
            <div class="snap-track" data-carousel-track>
                @foreach ($images as $image)
                    <div class="snap-slide relative aspect-[4/5] w-full">
                        <img src="{{ $image->path }}"
                             alt="{{ $image->alt ?? 'Post image' }}"
                             width="1200" height="1500"
                             loading="lazy" decoding="async"
                             class="h-full w-full object-cover">
                    </div>
                @endforeach
            </div>

            @if ($images->count() > 1)
                <div class="pointer-events-none absolute inset-x-3 top-3 flex justify-end">
                    <span class="pointer-events-auto rounded-pill bg-ink/85 px-2.5 py-1 text-xs font-semibold tabular text-paper">
                        <span data-carousel-index>1</span>/{{ $images->count() }}
                    </span>
                </div>

                {{-- The bar is 6px; the button around it is 24px, so a thumb can
                     actually hit it. --}}
                <div class="absolute inset-x-0 bottom-0 flex items-center justify-center gap-0.5 pb-1">
                    @foreach ($images as $i => $image)
                        <button type="button"
                                data-carousel-dot="{{ $i }}"
                                @if ($i === 0) aria-current="true" @endif
                                class="flex h-6 items-center px-1"
                                aria-label="Show image {{ $i + 1 }} of {{ $images->count() }}">
                            <span data-carousel-bar
                                  class="block h-1.5 rounded-pill transition-all duration-300 ease-expo {{ $i === 0 ? 'w-6 bg-paper' : 'w-1.5 bg-paper/60' }}"></span>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- Caption --}}
    <div class="px-4 pt-4">
        <p class="text-[0.8125rem] leading-relaxed text-ink">
            <span class="font-bold">{{ config('store.name') }}</span>
            {{ $post->caption }}
        </p>
    </div>

    {{-- Shoppable garments: size is chosen here, so "add" is never a guess. --}}
    @if ($products->isNotEmpty())
        <div class="mt-4 space-y-2.5 px-4 pb-4">
            <p class="micro text-muted">
                Shop this post · {{ $products->count() }} {{ $products->count() === 1 ? 'piece' : 'pieces' }}
            </p>

            @foreach ($products as $product)
                <div class="flex items-center gap-3 rounded-control border border-line bg-mist/50 p-2.5">
                    <a href="{{ route('product.show', $product) }}" class="shrink-0">
                        @if ($product->primaryImageUrl())
                            <img src="{{ $product->primaryImageUrl() }}"
                                 alt="{{ $product->primaryImage()?->alt ?? $product->name }}"
                                 width="1100" height="1375"
                                 loading="lazy" decoding="async"
                                 class="h-14 w-12 rounded-[9px] object-cover">
                        @endif
                    </a>

                    <div class="min-w-0 flex-1">
                        <a href="{{ route('product.show', $product) }}"
                           class="link line-clamp-1 block py-1 text-xs font-semibold text-ink">{{ $product->name }}</a>
                        <div class="mt-1">
                            <x-store.price :product="$product" size="sm" />
                        </div>
                    </div>

                    <x-store.add-to-bag :product="$product" :id="$post->id.'-'.$product->id" class="shrink-0" />
                </div>
            @endforeach
        </div>
    @endif
</article>
