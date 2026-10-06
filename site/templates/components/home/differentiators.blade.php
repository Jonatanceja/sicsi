@props(['page'])
<section class="section bg-slate-50">
    <div class="container-x">
        <div class="mx-auto max-w-3xl text-center">
            <span class="eyebrow">{{ $page->diffEyebrow() }}</span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->diffTitle() }}</h2>
            <p x-reveal.100 class="mt-4 text-slate-600">{{ $page->diffText() }}</p>
        </div>

        <div class="mt-14 grid gap-6 lg:grid-cols-3">
            @foreach ($page->diffCards()->toStructure() as $card)
                <article x-reveal.{{ $loop->index * 100 }} class="card group flex flex-col p-8">
                    <span class="grid size-12 place-items-center rounded-2xl bg-ink-900 text-brand-400 transition group-hover:bg-brand-500 group-hover:text-white">
                        <x-icon :name="$card->icon()->value() ?: 'star'" class="size-6" />
                    </span>
                    <p class="mt-6 text-[0.65rem] font-bold tracking-[0.18em] text-brand-600 uppercase">{{ $card->tag() }}</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-900">{{ $card->title() }}</h3>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ $card->text() }}</p>
                    @if ($card->footerLabel()->isNotEmpty())
                        <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-4 text-xs font-semibold text-slate-700">
                            <span class="flex items-center gap-2">
                                <x-icon :name="$card->footerIcon()->value() ?: 'check-circle'" class="size-4 text-emerald-600" />
                                {{ $card->footerLabel() }}
                            </span>
                            <x-icon name="arrow-right" class="size-4 text-brand-600 transition group-hover:translate-x-1" />
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
