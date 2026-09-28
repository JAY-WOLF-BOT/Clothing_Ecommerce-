@extends('layouts.app')

@section('content')
<div class="py-4">
    <!-- Back Button -->
    <a href="/" class="inline-flex items-center space-x-2 text-xs font-semibold text-gray-600 hover:text-black mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Back to Home Feed</span>
    </a>

    <!-- Category Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 capitalize">{{ $category }} Collection</h1>
        <p class="text-sm text-gray-500 mt-1">Explore our exclusive selection of {{ $category }}.</p>
    </div>

    <!-- Filters & Sort Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-8 border-b border-gray-200">
        <div class="flex items-center space-x-3 text-xs">
            <span class="font-semibold text-gray-700">Filter By:</span>
            <select class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:ring-black focus:border-black">
                <option>Size (All)</option>
                <option>Small (S)</option>
                <option>Medium (M)</option>
                <option>Large (L)</option>
            </select>
            <select class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:ring-black focus:border-black">
                <option>Color (All)</option>
                <option>Black</option>
                <option>White</option>
                <option>Beige</option>
            </select>
        </div>

        <div class="flex items-center space-x-2 text-xs">
            <span class="font-semibold text-gray-700">Sort By:</span>
            <select class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:ring-black focus:border-black">
                <option>Newest</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
            </select>
        </div>
    </div>

    <!-- Dynamic Category Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">

        @if($category === 'dresses')
            <!-- DRESSES COLLECTION -->
            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <span class="absolute top-3 left-3 bg-white text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm">Best Seller</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Silk Series</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Minimalist Silk Dress</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$120.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Evening Wear</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Satin Wrap Gown</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$160.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Casual</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Floral Tiered Midi Dress</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$95.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

        @elseif($category === 'tops')
            <!-- TOPS COLLECTION -->
            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <span class="absolute top-3 left-3 bg-white text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm">New</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Basics</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Classic White Tee</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$45.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Workwear</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Oversized Linen Shirt</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$75.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Knitwear</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Ribbed Cropped Top</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$50.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

        @elseif($category === 'outerwear')
            <!-- OUTERWEAR COLLECTION -->
            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <span class="absolute top-3 left-3 bg-white text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm">Trending</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Coats</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Classic Trench Coat</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$210.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Jackets</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Vintage Leather Biker Jacket</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$280.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>

            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1548883354-7622d03aca27?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tailored</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Structured Wool Blazer</h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-bold text-gray-900">$190.00</span>
                        <span class="bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-lg">View</span>
                    </div>
                </div>
            </a>
        @elseif($category === 'sale')
            <!-- SALE COLLECTION -->
            <a href="/product/1" class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">35% OFF</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-red-600 font-semibold uppercase tracking-wider mb-1">Clearance</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-gray-600 transition">Minimalist Silk Dress</h3>
                    <div class="flex items-center justify-between mt-3">
                        <div>
                            <span class="font-bold text-red-600">$78.00</span>
                            <span class="text-xs text-gray-400 line-through ml-1">$120.00</span>
                        </div>
                        <span class="bg-black text-white text-xs font-medium px-3 py-2 rounded-lg">Grab Deal</span>
                    </div>
                </div>
            </a> 

        @else
            <!-- DEFAULT / ALL ITEMS FALLBACK -->
            <div class="col-span-full py-12 text-center text-gray-500">
                <p>Select a category from the top navigation menu to view products.</p>
            </div>
        @endif

    </div>
</div>
@endsection