@props(['page'])
@php
    $image = $page->heroImage()->toFile();
@endphp
<section id="inicio" class="relative isolate overflow-hidden bg-ink-950 text-white">
    @if ($image)
        <img src="{{ $image->url() }}" alt="" class="absolute inset-0 -z-20 size-full object-cover opacity-40" />
    @endif
    <div class="absolute inset-0 -z-10 bg-linear-to-b from-ink-950/60 via-ink-950/80 to-ink-950"></div>
    <div class="absolute -top-40 left-1/2 -z-10 h-[32rem] w-[48rem] -translate-x-1/2 rounded-full bg-brand-500/20 blur-3xl"></div>
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3.5rem_3.5rem] mask-[radial-gradient(ellipse_at_center,black_30%,transparent_75%)]"></div>

    <div class="container-x px-4 pt-20 pb-16 text-center sm:px-6 sm:pt-28 lg:px-8 lg:pt-32">
        @if ($page->heroBadge()->isNotEmpty())
            <span class="inline-flex animate-fade-up items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-[0.7rem] font-bold tracking-[0.15em] text-slate-200 uppercase backdrop-blur">
                <x-icon :name="$page->heroBadgeIcon()->value() ?: 'shield-check'" class="size-4 text-brand-400" />
                {{ $page->heroBadge() }}
            </span>
        @endif

        <h1 class="mx-auto mt-8 max-w-4xl animate-fade-up text-4xl leading-[1.08] font-extrabold [animation-delay:100ms] sm:text-5xl lg:text-6xl">
            {{ $page->heroTitleStart() }}
            <span class="bg-linear-to-r from-brand-400 to-brand-600 bg-clip-text text-transparent">{{ $page->heroTitleHighlight() }}</span>
            {{ $page->heroTitleEnd() }}
        </h1>

        <p class="mx-auto mt-6 max-w-2xl animate-fade-up text-base leading-relaxed text-slate-300 [animation-delay:200ms] sm:text-lg">{{ $page->heroText() }}</p>

        <div class="mt-10 flex animate-fade-up flex-col items-center justify-center gap-3 [animation-delay:300ms] sm:flex-row">
            @if ($page->heroPrimaryLabel()->isNotEmpty())
                <a href="{{ $page->heroPrimaryUrl() }}" class="btn btn-primary w-full sm:w-auto">
                    {{ $page->heroPrimaryLabel() }}
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            @endif
            @if ($page->heroSecondaryLabel()->isNotEmpty())
                <a href="{{ $page->heroSecondaryUrl() }}" class="btn btn-ghost w-full sm:w-auto">{{ $page->heroSecondaryLabel() }}</a>
            @endif
        </div>

        <ul class="mx-auto mt-16 grid max-w-5xl gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($page->heroHighlights()->toStructure() as $item)
                <li x-reveal.{{ $loop->index * 100 }} class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 text-left backdrop-blur">
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-brand-500/15 text-brand-400">
                        <x-icon :name="$item->icon()->value() ?: 'check'" class="size-5" />
                    </span>
                    <span>
                        <span class="block text-sm font-bold text-white">{{ $item->title() }}</span>
                        <span class="block text-xs text-slate-400">{{ $item->text() }}</span>
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</section>
