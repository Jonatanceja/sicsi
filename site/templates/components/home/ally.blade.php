@props(['page'])
@php
    $image = $page->allyImage()->toFile();
@endphp
<section id="nosotros" class="section bg-white">
    <div class="container-x grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
        <div x-reveal class="relative">
            <div class="absolute -inset-4 -z-10 rounded-[2rem] bg-linear-to-br from-brand-500/20 to-transparent blur-2xl"></div>
            <div class="relative aspect-[4/3] overflow-hidden rounded-3xl bg-ink-800 shadow-2xl shadow-slate-900/20">
                @if ($image)
                    <img src="{{ $image->url() }}" alt="{{ $image->alt()->or($page->allyTitle()) }}" class="size-full object-cover" loading="lazy" />
                @else
                    <div class="grid size-full place-items-center bg-linear-to-br from-ink-800 to-ink-950">
                        <x-icon name="user-group" class="size-20 text-white/10" />
                    </div>
                @endif
                @if ($page->allyImageTag()->isNotEmpty())
                    <span class="absolute top-4 left-4 rounded-md bg-ink-950/80 px-3 py-1 text-[0.65rem] font-bold tracking-wider text-white uppercase backdrop-blur">{{ $page->allyImageTag() }}</span>
                @endif
            </div>
            <div class="relative z-10 -mt-12 ml-4 max-w-sm rounded-2xl border border-white/10 bg-ink-900 p-5 text-white shadow-xl sm:ml-8">
                <div class="flex items-center gap-3">
                    <span class="grid size-9 place-items-center rounded-lg bg-brand-500/20 text-brand-400">
                        <x-icon :name="$page->allyCardIcon()->value() ?: 'shield-check'" class="size-5" />
                    </span>
                    <p class="font-display text-sm font-bold">{{ $page->allyCardTitle() }}</p>
                </div>
                <p class="mt-3 text-xs leading-relaxed text-slate-400">{{ $page->allyCardText() }}</p>
            </div>
        </div>

        <div>
            <span class="eyebrow">{{ $page->allyEyebrow() }}</span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->allyTitle() }}</h2>
            <p x-reveal.100 class="mt-4 leading-relaxed text-slate-600">{{ $page->allyText() }}</p>

            <ul class="mt-8 grid gap-4 sm:grid-cols-3">
                @foreach ($page->allyItems()->toStructure() as $item)
                    <li x-reveal.{{ $loop->index * 100 }} class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-brand-500/40 hover:bg-white">
                        <x-icon :name="$item->icon()->value() ?: 'check-circle'" class="size-6 text-brand-600" />
                        <h3 class="mt-3 text-sm font-bold text-slate-900">{{ $item->title() }}</h3>
                        <p class="mt-1.5 text-xs leading-relaxed text-slate-500">{{ $item->text() }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
