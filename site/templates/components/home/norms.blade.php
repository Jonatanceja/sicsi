@props(['page'])
<section id="servicios" class="section bg-white">
    <div class="container-x">
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div class="max-w-2xl">
                <span x-reveal class="eyebrow">
                    <x-icon :name="$page->normsEyebrowIcon()->value() ?: 'document-text'" class="size-4" />
                    {{ $page->normsEyebrow() }}
                </span>
                <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->normsTitle() }}</h2>
                <p x-reveal.100 class="mt-4 text-slate-600">{{ $page->normsText() }}</p>
            </div>
            @if ($page->normsLinkLabel()->isNotEmpty())
                <a href="{{ $page->normsLinkUrl() }}" class="group inline-flex items-center gap-2 text-xs font-bold tracking-wider text-brand-700 uppercase">
                    {{ $page->normsLinkLabel() }}
                    <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" />
                </a>
            @endif
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($page->normsCards()->toStructure() as $card)
                <article x-reveal.{{ ($loop->index % 3) * 100 }} class="card flex flex-col">
                    <div class="flex items-center justify-between">
                        <span class="rounded-md bg-ink-900 px-2.5 py-1 font-mono text-[0.65rem] font-bold tracking-wider text-brand-400">{{ $card->code() }}</span>
                        <x-icon :name="$card->icon()->value() ?: 'document-text'" class="size-5 text-slate-400" />
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">{{ $card->title() }}</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">{{ $card->text() }}</p>
                    <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 border-t border-slate-100 pt-4 text-xs font-semibold text-slate-600">
                        <span class="flex items-center gap-1.5"><x-icon :name="$page->normsHoursIcon()->value() ?: 'clock'" class="size-4 text-brand-700" />{{ $card->hours() }}</span>
                        <span class="flex items-center gap-1.5"><x-icon :name="$page->normsProofIcon()->value() ?: 'check-circle'" class="size-4 text-emerald-600" />{{ $card->proof() }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
