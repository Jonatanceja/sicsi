<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="@csrf()" />

    @if ($favicon = site()->brandFavicon()->toFile())
        <link rel="icon" href="{{ $favicon->url() }}" type="{{ $favicon->mime() }}" />
    @endif

    <x-seo />

    {{-- Fonts load without blocking the first paint (display=swap + print/onload swap) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700;800&display=swap" media="print" onload="this.media='all'" />
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700;800&display=swap" /></noscript>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body x-data>
    <a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-ink-900 focus:shadow-lg">Saltar al contenido</a>

    <x-site-header />

    <main id="contenido" tabindex="-1" class="focus:outline-none">
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>
