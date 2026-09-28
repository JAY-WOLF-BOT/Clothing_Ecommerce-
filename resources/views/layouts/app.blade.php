<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrandName Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">

    <!-- Global Header / Navigation -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Store Logo -->
            <a href="/" class="font-extrabold text-xl tracking-tight text-gray-900">
                BRANDNAME
            </a>

            <!-- Category Navigation Links -->
            <nav class="hidden md:flex space-x-8 text-sm font-medium">
                <a href="/category/dresses" class="text-gray-600 hover:text-black transition">Dresses</a>
                <a href="/category/tops" class="text-gray-600 hover:text-black transition">Tops</a>
                <a href="/category/outerwear" class="text-gray-600 hover:text-black transition">Outerwear</a>
                <a href="/category/sale" class="text-gray-600 hover:text-black transition">Sale</a>
            </nav>

            <!-- Quick Cart Action -->
            <div class="flex items-center space-x-4">
                <a href="#" class="relative p-2 text-gray-700 hover:text-black transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="absolute top-1 right-1 bg-black text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">0</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Page Content Container -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 w-full">
        @yield('content')
    </main>

</body>
</html>