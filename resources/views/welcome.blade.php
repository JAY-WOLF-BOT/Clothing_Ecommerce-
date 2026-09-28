@extends('layouts.app')

@section('content')
    <!-- Hero Banner -->
    <div class="relative bg-black text-white rounded-2xl overflow-hidden mb-10 p-8 sm:p-12 flex flex-col items-start justify-center min-h-[240px]">
        <span class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-semibold">Welcome to BrandName</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-4 max-w-xl leading-tight">See What's Trending Right Now</h1>
        <a href="/category/all" class="bg-white text-black font-semibold px-6 py-2.5 rounded-full hover:bg-gray-200 transition text-sm">
            Browse Full Catalog →
        </a>
    </div>

    <!-- Admin Feed Section -->
    <div class="mb-16">
        @include('components.admin-feed')
    </div>

    <!-- Quick Footer -->
    <footer class="border-t border-gray-200 pt-8 pb-4 text-center text-xs text-gray-500">
        <p>&copy; 2026 BrandName Store. All rights reserved.</p>
    </footer>
@endsection