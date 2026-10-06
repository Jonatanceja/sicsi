@props(['page'])
@php
    $image = $page->storyImage()->toFile();
    $tones = ['brand' => 'text-brand-600', 'dark' => 'text-ink-900', 'green' => 'text-emerald-600'];
@endphp
<section id="historia" class="section bg-white">
    <div class="container-x">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div>
                <span class="eyebrow before:h-0.5 before:w-8 before:bg-brand-500 before:content-['']">{{ $page->storyEyebrow() }}</span>
                <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->storyTitle() }}</h2>

                <div x-reveal.100 class="mt-5 space-y-4 text-sm leading-relaxed text-slate-600 sm:text-base">
                    @foreach (preg_split('/\R{2,}/', trim($page->storyText()->value())) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <dl class="mt-8 grid grid-cols-2 gap-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 sm:grid-cols-4">
                    @foreach ($page->storyStats()->toStructure() as $stat)
                        <div>
                            <dd class="font-display text-3xl font-extrabold {{ $tones[$stat->tone()->value()] ?? $tones['brand'] }}">{{ $stat->value() }}</dd>
                            <dt class="mt-1 text-[0.7rem] leading-snug text-slate-500">{{ $stat->label() }}</dt>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div x-reveal.100 class="relative">
                <div class="absolute -inset-4 -z-10 rounded-[2rem] bg-linear-to-br from-brand-500/20 to-transparent blur-2xl"></div>
                <div class="relative aspect-[4/3] overflow-hidden rounded-3xl bg-ink-800 shadow-2xl shadow-slate-900/20">
                    @if ($image)
                        <img src="{{ $image->url() }}" alt="{{ $image->alt()->or($page->storyTitle()) }}" class="size-full object-cover" loading="lazy" />
                    @else
                        <div class="grid size-full place-items-center bg-linear-to-br from-ink-800 to-ink-950">
                            <x-icon name="building-office" class="size-20 text-white/10" />
                        </div>
                    @endif
                    <div class="absolute inset-x-4 bottom-4 flex items-center gap-3 rounded-2xl border border-white/10 bg-ink-950/85 p-4 text-white backdrop-blur">
                        <x-icon :name="$page->storyCardIcon()->value() ?: 'shield-check'" class="size-7 shrink-0 text-emerald-400" />
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold">{{ $page->storyCardTitle() }}</p>
                            <p class="text-xs text-slate-400">{{ $page->storyCardText() }}</p>
                        </div>
                        @if ($page->storyCardStatus()->isNotEmpty())
                            <span class="rounded-md bg-emerald-500/15 px-2 py-1 text-[0.6rem] font-bold tracking-wider text-emerald-400 uppercase">{{ $page->storyCardStatus() }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div id="ejes" class="mt-20">
            <h3 x-reveal class="text-xl font-extrabold text-slate-900 sm:text-2xl">{{ $page->pillarsTitle() }}</h3>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach ($page->pillars()->toStructure() as $pillar)
                    <article x-reveal.{{ $loop->index * 100 }} class="card group border-t-4 {{ $loop->index === 1 ? 'border-t-ink-900' : 'border-t-brand-600' }}">
                        <span class="grid size-11 place-items-center rounded-xl bg-brand-500/10 text-brand-600">
                            <x-icon :name="$pillar->icon()->value() ?: 'star'" class="size-5" />
                        </span>
                        <p class="mt-5 text-[0.65rem] font-bold tracking-[0.18em] text-brand-600 uppercase">{{ $pillar->tag() }}</p>
                        <h4 class="mt-1 text-lg font-bold text-slate-900">{{ $pillar->title() }}</h4>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $pillar->text() }}</p>
                        @if ($pillar->footerLabel()->isNotEmpty())
                            <p class="mt-5 flex items-center gap-2 text-xs font-semibold text-brand-600">
                                <x-icon :name="$pillar->footerIcon()->value() ?: 'check-circle'" class="size-4" />
                                {{ $pillar->footerLabel() }}
                            </p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
