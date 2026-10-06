@php
    $site = site();
    $isActive = fn ($url) => $url === '/' ? page()->isHomePage() : (! str_contains($url, '#') && rtrim(url($url), '/') === rtrim(page()->url(), '/'));
@endphp
<header x-data="siteHeader" @scroll.window.passive="onScroll" @keydown.escape.window="close" class="sticky top-0 z-50 transition-transform duration-300 ease-out" :class="!topBar && !open && 'md:-translate-y-[2.3rem]'">
    {{-- Top bar --}}
    <div class="hidden border-b border-white/5 bg-ink-950 text-xs text-slate-400 md:block">
        <div class="container-x flex h-9 items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6">
                @if ($site->topBarPhone()->isNotEmpty())
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $site->topBarPhone()) }}" class="flex items-center gap-1.5 transition hover:text-white">
                        <x-icon :name="$site->topBarPhoneIcon()->value() ?: 'phone'" class="size-3.5 text-brand-400" />
                        {{ $site->topBarPhone() }}
                    </a>
                @endif
                @if ($site->topBarEmail()->isNotEmpty())
                    <a href="mailto:{{ $site->topBarEmail() }}" class="flex items-center gap-1.5 transition hover:text-white">
                        <x-icon :name="$site->topBarEmailIcon()->value() ?: 'envelope'" class="size-3.5 text-brand-400" />
                        {{ $site->topBarEmail() }}
                    </a>
                @endif
            </div>
            <div class="flex items-center gap-6">
                @if ($site->topBarTag()->isNotEmpty())
                    <span class="flex items-center gap-1.5 font-semibold tracking-wide text-slate-300 uppercase">
                        <x-icon :name="$site->topBarTagIcon()->value() ?: 'shield-check'" class="size-3.5 text-brand-400" />
                        {{ $site->topBarTag() }}
                    </span>
                @endif
                @if ($site->topBarCoverage()->isNotEmpty())
                    <span class="flex items-center gap-1.5">
                        <x-icon :name="$site->topBarCoverageIcon()->value() ?: 'globe'" class="size-3.5 text-brand-400" />
                        {{ $site->topBarCoverage() }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Main bar --}}
    <div :class="scrolled && 'shadow-lg shadow-slate-900/10'" class="border-b border-slate-200 bg-white/80 backdrop-blur-xl transition duration-300">
        <div class="container-x flex items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ $site->url() }}" class="flex items-center gap-3">
                @if ($logo = $site->brandLogo()->toFile())
                    <img src="{{ $logo->url() }}" alt="{{ $site->brandName() }}" class="h-10 w-auto sm:h-11" />
                @else
                    <span class="grid size-9 place-items-center rounded-lg bg-brand-500 text-white">
                        <x-icon name="shield-check" class="size-5" />
                    </span>
                    <span class="leading-none">
                        <span class="block font-display text-lg font-extrabold tracking-tight text-ink-900">{{ $site->brandName() }}</span>
                        @if ($site->brandTagline()->isNotEmpty())
                            <span class="mt-0.5 hidden text-[0.6rem] font-medium tracking-wider text-slate-500 uppercase sm:block">{{ $site->brandTagline() }}</span>
                        @endif
                    </span>
                @endif
            </a>

            <nav class="hidden items-center gap-1 rounded-full border border-slate-200 bg-slate-50 p-1 md:flex" aria-label="Principal">
                @foreach ($site->navItems()->toStructure() as $item)
                    <a href="{{ url($item->url()->value()) }}" @if ($isActive($item->url()->value())) aria-current="page" @endif class="rounded-full px-4 py-1.5 text-sm font-semibold transition hover:bg-white hover:text-brand-600 hover:shadow-sm {{ $isActive($item->url()->value()) ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-700' }}">{{ $item->label() }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                @if ($site->navCtaLabel()->isNotEmpty())
                    <a href="{{ url($site->navCtaUrl()->value()) }}" class="btn btn-primary hidden px-4 py-2.5 text-xs sm:inline-flex">
                        {{ $site->navCtaLabel() }}
                        <x-icon :name="$site->navCtaIcon()->value() ?: 'arrow-right'" class="size-4" />
                    </a>
                @endif
                <button type="button" @click="toggle" class="grid size-10 place-items-center rounded-lg border border-slate-300 text-slate-700 md:hidden" :aria-expanded="open" aria-label="Menú">
                    <x-icon name="bars-3" x-show="!open" />
                    <x-icon name="x-mark" x-show="open" x-cloak />
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <nav x-show="open" x-cloak x-transition.opacity @click.outside="close" class="border-t border-slate-200 bg-white px-4 py-4 md:hidden" aria-label="Móvil">
            <ul class="space-y-1">
                @foreach ($site->navItems()->toStructure() as $item)
                    <li><a href="{{ url($item->url()->value()) }}" @click="close" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">{{ $item->label() }}</a></li>
                @endforeach
            </ul>
            @if ($site->navCtaLabel()->isNotEmpty())
                <a href="{{ url($site->navCtaUrl()->value()) }}" @click="close" class="btn btn-primary mt-4 w-full">{{ $site->navCtaLabel() }}</a>
            @endif
        </nav>
    </div>
</header>
