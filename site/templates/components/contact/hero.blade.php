@props(['page'])
@php
    $image = $page->heroImage()->toFile();
@endphp
<section class="relative isolate overflow-hidden bg-ink-950 text-white">
    @if ($image)
        <img src="{{ $image->url() }}" alt="" class="absolute inset-0 -z-20 size-full object-cover opacity-40" />
    @endif
    <div class="absolute inset-0 -z-10 bg-linear-to-b from-ink-950/60 via-ink-950/80 to-ink-950"></div>
    <div class="absolute -top-40 -right-20 -z-10 h-[28rem] w-[40rem] rounded-full bg-brand-500/15 blur-3xl"></div>
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3.5rem_3.5rem] mask-[radial-gradient(ellipse_at_left,black_20%,transparent_75%)]"></div>

    <div class="container-x px-4 pt-20 pb-14 sm:px-6 sm:pt-24 lg:px-8">
        @if ($page->heroBadge()->isNotEmpty())
            <span class="eyebrow animate-fade-up !text-brand-400 before:size-1.5 before:rounded-full before:bg-brand-500 before:content-['']">{{ $page->heroBadge() }}</span>
        @endif

        <h1 class="mt-5 max-w-3xl animate-fade-up text-4xl leading-[1.1] font-extrabold [animation-delay:100ms] sm:text-5xl">
            {{ $page->heroTitleStart() }}
            <span class="text-brand-500">{{ $page->heroTitleHighlight() }}</span>
            {{ $page->heroTitleEnd() }}
        </h1>
        <p class="mt-5 max-w-2xl animate-fade-up text-base leading-relaxed text-slate-300 [animation-delay:200ms]">{{ $page->heroText() }}</p>

        <ul class="mt-8 grid animate-fade-up gap-3 [animation-delay:300ms] sm:grid-cols-3">
            @foreach ($page->heroChips()->toStructure() as $chip)
                <li class="flex items-center gap-2.5 rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-xs font-semibold text-slate-200 backdrop-blur">
                    <x-icon :name="$chip->icon()->value() ?: 'check-circle'" class="size-5 shrink-0 text-brand-400" />
                    {{ $chip->text() }}
                </li>
            @endforeach
        </ul>
    </div>
</section>
