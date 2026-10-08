@extends('layouts.app')

@section('title', 'Page not found — '.config('store.name'))
@section('description', 'That page does not exist. Browse the collection instead.')

@section('content')
    @php($categories = app(\App\Support\Navigation::class)->categories())

    <section class="shell py-14 sm:py-20">
        <div class="grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <h1 class="font-display text-[2rem] font-extrabold leading-[1.06] tracking-[-0.035em] text-ink sm:text-[2.6rem]">
                    That page is not on the rail.
                </h1>

                <p class="mt-4 max-w-lg text-sm leading-relaxed text-muted">
                    The link is broken, or the piece it pointed at has been taken down — nothing lives
                    at this address (404). The collection is still here.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        Back to the feed
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('bag.index') }}" class="btn btn-secondary">
                        <x-icon name="bag" class="h-4 w-4" />
                        Your bag
                    </a>
                </div>
            </div>

            @if ($categories->isNotEmpty())
                <div class="lg:col-span-5">
                    <p class="micro text-muted">Shop instead</p>
                    <ul class="mt-4 divide-y divide-line border-y border-line">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('category.show', $category) }}"
                                   class="group flex items-center justify-between gap-4 py-3.5 transition">
                                    <span>
                                        <span class="block font-display text-base font-bold tracking-[-0.02em] text-ink">
                                            {{ $category->name }}
                                        </span>
                                        @if ($category->tagline)
                                            <span class="mt-0.5 block text-xs text-muted">{{ $category->tagline }}</span>
                                        @endif
                                    </span>
                                    <x-icon name="arrow-up-right"
                                            class="h-4 w-4 shrink-0 text-muted transition duration-300 ease-expo group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-ink" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endsection
