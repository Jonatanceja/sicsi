@props(['page'])
<section id="brigadas" class="section bg-slate-50">
    <div class="container-x">
        <span class="eyebrow before:size-1.5 before:rounded-full before:bg-brand-500 before:content-['']">{{ $page->brigadesEyebrow() }}</span>
        <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->brigadesTitle() }}</h2>
        <p x-reveal.100 class="mt-4 max-w-3xl text-slate-600">{{ $page->brigadesText() }}</p>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($page->brigadesCards()->toStructure() as $card)
                <article x-reveal.{{ $loop->index * 100 }} class="card flex flex-col">
                    <span class="grid size-11 place-items-center rounded-xl bg-brand-500/10 text-brand-600">
                        <x-icon :name="$card->icon()->value() ?: 'shield-check'" class="size-5" />
                    </span>
                    <h3 class="mt-5 text-base font-bold text-slate-900">{{ $card->title() }}</h3>
                    <p class="mt-2 flex-1 text-xs leading-relaxed text-slate-500">{{ $card->text() }}</p>
                    @if ($card->tag()->isNotEmpty())
                        <p class="mt-4 border-t border-slate-100 pt-3 text-[0.65rem] font-semibold text-slate-500">{{ $card->tag() }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
