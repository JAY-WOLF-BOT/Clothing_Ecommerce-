@extends('layouts.app')

@section('content')
<!-- Back Button -->
    <a href="/" class="inline-flex items-center space-x-2 text-xs font-semibold text-gray-600 hover:text-black mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Back to Home Feed</span>
    </a>
<div class="py-6 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-6 flex items-center space-x-2">
        <a href="/" class="hover:text-black">Home</a>
        <span>/</span>
        <a href="/category/dresses" class="hover:text-black">Dresses</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Minimalist Silk Dress</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Product Image Gallery -->
        <div class="space-y-4">
            <div class="aspect-[4/5] bg-gray-100 rounded-2xl overflow-hidden">
                <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Product Details -->
        <div class="flex flex-col justify-between">
            <div>
                <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold">New Arrival</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1 mb-2">Minimalist Silk Dress</h1>
                <p class="text-xl font-bold text-gray-900 mb-6">$120.00</p>

                <p class="text-xs text-gray-600 leading-relaxed mb-6">
                    Crafted from 100% premium silk, this versatile piece transitions seamlessly from day to night. Features a sleek silhouette with an adjustable back link.
                </p>

                <!-- Size Selection -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-900 mb-2 uppercase">Select Size</label>
                    <div class="flex space-x-2">
                        <button class="w-10 h-10 border border-gray-300 rounded-lg text-xs font-semibold hover:border-black">S</button>
                        <button class="w-10 h-10 border-2 border-black rounded-lg text-xs font-semibold bg-black text-white">M</button>
                        <button class="w-10 h-10 border border-gray-300 rounded-lg text-xs font-semibold hover:border-black">L</button>
                    </div>
                </div>
            </div>

            <!-- Call to Action Buttons -->
            <div class="space-y-3 pt-6 border-t border-gray-100">
                <button class="w-full bg-black text-white py-3.5 rounded-xl font-bold text-sm hover:bg-gray-800 transition">
                    Add to Bag
                </button>
                <button class="w-full border border-gray-300 text-gray-900 py-3 rounded-xl font-bold text-sm hover:bg-gray-50 transition">
                    Order via WhatsApp
                </button>
            </div>
        </div>
    </div>
</div>
@endsection