@props(['page'])
<section id="consultoria" class="section bg-white">
    <div class="container-x">
        <span x-reveal class="eyebrow before:size-1.5 before:rounded-full before:bg-brand-500 before:content-['']">{{ $page->consultingEyebrow() }}</span>
        <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->consultingTitle() }}</h2>
        <p x-reveal.100 class="mt-4 max-w-3xl text-slate-600">{{ $page->consultingText() }}</p>

        <div class="mt-12 grid gap-6 lg:grid-cols-2">
            @foreach ($page->consultingCards()->toStructure() as $card)
                <article x-reveal.{{ ($loop->index % 2) * 100 }} class="card flex flex-col p-7">
                    <div class="flex items-start gap-4">
                        <span class="grid size-12 shrink-0 place-items-center rounded-xl bg-brand-500/10 text-brand-700">
                            <x-icon :name="$card->icon()->value() ?: 'document-text'" class="size-6" />
                        </span>
                        <div>
                            <p class="text-[0.65rem] font-bold tracking-[0.18em] text-brand-700 uppercase">{{ $card->tag() }}</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">{{ $card->title() }}</h3>
                        </div>
                    </div>
                    <p class="mt-4 flex-1 text-sm leading-relaxed text-slate-600">{{ $card->text() }}</p>
                    @if ($card->features()->isNotEmpty())
                        <ul class="mt-5 grid gap-x-4 gap-y-2 sm:grid-cols-2">
                            @foreach ($card->features()->split() as $feature)
                                <li class="flex items-center gap-2 text-xs font-medium text-slate-700">
                                    <x-icon :name="$page->consultingCheckIcon()->value() ?: 'check'" class="size-4 shrink-0 text-emerald-600" />
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($card->ctaLabel()->isNotEmpty())
                        <a href="{{ url($card->ctaUrl()->or('/#cotizar')->value()) }}" class="group mt-6 inline-flex items-center gap-2 border-t border-slate-100 pt-4 text-xs font-bold text-brand-700">
                            {{ $card->ctaLabel() }}
                            <x-icon :name="$page->consultingCtaIcon()->value() ?: 'arrow-right'" class="size-4 transition group-hover:translate-x-1" />
                        </a>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
