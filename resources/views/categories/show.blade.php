@extends('layouts.app')

@section('title', $category->name.' — '.config('store.name'))
@section('description', $category->tagline ?? 'Browse the '.$category->name.' collection.')

@section('content')
    <section class="shell pt-6">

        <nav class="flex items-center gap-2 text-xs text-muted" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="link hover:text-ink">Home</a>
            <span aria-hidden="true">/</span>
            <span class="text-ink">{{ $category->name }}</span>
        </nav>

        <header class="mt-5 border-b border-line pb-6">
            <h1 class="font-display text-[1.9rem] font-extrabold leading-tight tracking-[-0.035em] text-ink sm:text-[2.4rem]">
                {{ $category->name }}
            </h1>
            @if ($category->tagline)
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-muted">{{ $category->tagline }}</p>
            @endif
        </header>

        {{-- Filters are a plain GET form: they work without JavaScript, and
             auto-submit where scripting is available. --}}
        <form method="GET" action="{{ route('category.show', $category) }}" data-filter-form class="mt-6">
            @php
                $sizeOptions = ['' => 'All sizes'] + $sizes->mapWithKeys(fn ($size) => [$size => $size])->all();
                $colourOptions = ['' => 'All colours'] + $colours->mapWithKeys(fn ($colour) => [$colour => $colour])->all();
            @endphp

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 text-xs font-semibold text-muted">
                    <x-icon name="filter" class="h-4 w-4" />
                    <span class="micro">Filter</span>
                </div>

                <label id="filter-size-label" for="filter-size" class="sr-only">Size</label>
                <x-store.select name="size"
                                id="filter-size"
                                tone="sm"
                                :options="$sizeOptions"
                                :selected="$activeSize"
                                labelledby="filter-size-label" />

                <label id="filter-colour-label" for="filter-colour" class="sr-only">Colour</label>
                <x-store.select name="colour"
                                id="filter-colour"
                                tone="sm"
                                :options="$colourOptions"
                                :selected="$activeColour"
                                labelledby="filter-colour-label" />

                <label id="filter-sort-label" for="filter-sort" class="sr-only">Sort by</label>
                <x-store.select name="sort"
                                id="filter-sort"
                                tone="sm"
                                class="sm:ml-auto"
                                :options="$sorts"
                                :selected="$activeSort"
                                labelledby="filter-sort-label" />

                <button type="submit" class="btn btn-secondary btn-sm" data-filter-submit>Apply</button>

                @if ($activeSize || $activeColour || $activeSort !== 'curated')
                    <a href="{{ route('category.show', $category) }}" class="link text-xs font-semibold text-muted hover:text-ink">
                        Clear
                    </a>
                @endif
            </div>

            <p class="mt-4 text-xs text-muted" data-filter-count aria-live="polite">
                {{ $products->total() }} {{ $products->total() === 1 ? 'piece' : 'pieces' }}
                @if ($activeSize || $activeColour)
                    matching your filters
                @endif
            </p>
        </form>

        <div class="mt-8" data-filter-results>
            @if ($products->isEmpty())
                <x-store.empty-state icon="filter"
                                     title="Nothing matches those filters"
                                     :body="'Try a different size or colour — or clear the filters to see the whole '.strtolower($category->name).' collection.'">
                    <a href="{{ route('category.show', $category) }}" class="btn btn-primary">Clear filters</a>
                </x-store.empty-state>
            @else
                {{-- Keeps the document outline honest: the grid is a section of
                     this category, so its cards hang off this heading. --}}
                <h2 class="sr-only">{{ $category->name }} in stock</h2>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $product)
                        <x-store.product-card :product="$product" :index="$loop->index" />
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
