<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('store.name'))</title>
    <meta name="description" content="@yield('description', 'Ghanaian womenswear, priced in cedis. Shop the collection, then send your order on WhatsApp.')">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <script>
        // Scripting is advertised to CSS, and revoked if the bundle never boots:
        // a failed script must leave the catalogue visible, never blank.
        document.documentElement.classList.replace('no-js', 'js');
        window.setTimeout(function () {
            if (!window.__revealReady) {
                document.documentElement.classList.remove('js');
            }
        }, 2500);
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-paper">

    <a href="#main"
       class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-control focus:bg-ink focus:px-4 focus:py-3 focus:text-sm focus:font-semibold focus:text-paper">
        Skip to content
    </a>

    @if (config('store.preview'))
        <div class="bg-ink text-on-ink">
            <div class="shell flex flex-col gap-1 py-2.5 text-xs leading-relaxed sm:flex-row sm:items-center sm:gap-3">
                <span class="chip bg-paper/10 text-on-ink shrink-0 self-start">Preview</span>
                <p class="text-on-ink-muted">
                    Placeholder build: the catalogue, prices, photography and brand name are illustrative — not this store's real stock.
                    Orders are real only once the seller confirms them on WhatsApp.
                </p>
            </div>
        </div>
    @endif

    <x-store.header />

    <main id="main" class="flex-1 pb-24">
        @yield('content')
    </main>

    <x-store.footer />

    <x-toasts />
</body>
</html>
