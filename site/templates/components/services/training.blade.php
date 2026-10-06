@props(['page'])
<section id="capacitacion" class="section bg-white">
    <div class="container-x">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <span class="eyebrow before:size-1.5 before:rounded-full before:bg-brand-500 before:content-['']">{{ $page->trainingEyebrow() }}</span>
                <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->trainingTitle() }}</h2>
                <p x-reveal.100 class="mt-4 text-slate-600">{{ $page->trainingText() }}</p>
            </div>
            @if ($page->trainingBadge()->isNotEmpty())
                <span class="inline-flex items-center gap-2 self-start rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-[0.7rem] font-bold tracking-wide text-emerald-700 uppercase">
                    <x-icon :name="$page->trainingBadgeIcon()->value() ?: 'check-circle'" class="size-4" />
                    {{ $page->trainingBadge() }}
                </span>
            @endif
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($page->trainingCards()->toStructure() as $card)
                <article x-reveal.{{ ($loop->index % 3) * 100 }} class="card flex flex-col">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[0.65rem] font-bold tracking-wider text-brand-600">{{ $card->code() }}</span>
                        <span class="flex items-center gap-1 text-[0.65rem] font-semibold text-slate-400">
                            <x-icon name="clock" class="size-3.5" />
                            {{ $card->hours() }}
                        </span>
                    </div>
                    <h3 class="mt-3 text-lg font-bold text-slate-900">{{ $card->title() }}</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">{{ $card->text() }}</p>
                    @if ($card->note()->isNotEmpty())
                        <p class="mt-4 flex items-start gap-2 rounded-lg bg-slate-50 px-3 py-2.5 text-xs text-slate-600">
                            <x-icon :name="$page->trainingNoteIcon()->value() ?: 'check-circle'" class="mt-0.5 size-4 shrink-0 text-emerald-600" />
                            {{ $card->note() }}
                        </p>
                    @endif
                    <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4 text-xs font-bold">
                        <span class="flex items-center gap-1.5 text-emerald-600">
                            <x-icon :name="$page->trainingProofIcon()->value() ?: 'check-circle'" class="size-4" />
                            {{ $card->proof() }}
                        </span>
                        @if ($page->trainingCtaLabel()->isNotEmpty())
                            <a href="{{ url($page->trainingCtaUrl()->or('/#cotizar')->value()) }}" class="group inline-flex items-center gap-1 text-brand-600">
                                {{ $page->trainingCtaLabel() }}
                                <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
