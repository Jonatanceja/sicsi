@props(['page'])
<section class="section bg-slate-50">
    <div class="container-x">
        <div class="mx-auto max-w-3xl text-center">
            <span x-reveal class="eyebrow">{{ $page->missionEyebrow() }}</span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->missionTitle() }}</h2>
            <p x-reveal.100 class="mt-4 text-slate-600">{{ $page->missionText() }}</p>
        </div>

        <div class="mt-14 grid gap-6 lg:grid-cols-2">
            @foreach ($page->missionCards()->toStructure() as $card)
                @php($dark = $loop->index % 2 === 1)
                <article x-reveal.{{ $loop->index * 100 }} class="card border-t-4 p-8 sm:p-10 {{ $dark ? 'border-t-ink-900' : 'border-t-brand-600' }}">
                    <div class="flex items-start justify-between gap-4">
                        <span class="grid size-12 place-items-center rounded-2xl {{ $dark ? 'bg-ink-900/5 text-ink-900' : 'bg-brand-500/10 text-brand-700' }}">
                            <x-icon :name="$card->icon()->value() ?: 'shield-check'" class="size-6" />
                        </span>
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-[0.6rem] font-bold tracking-wider text-slate-500 uppercase">{{ $card->tag() }}</span>
                    </div>
                    <h3 class="mt-6 text-2xl font-extrabold text-slate-900">{{ $card->title() }}</h3>
                    <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $card->text() }}</p>
                    @if ($card->footerLabel()->isNotEmpty())
                        <p class="mt-6 flex items-center gap-2 rounded-lg px-3 py-2.5 text-xs font-semibold {{ $dark ? 'bg-slate-100 text-slate-700' : 'bg-brand-500/10 text-brand-700' }}">
                            <x-icon :name="$card->footerIcon()->value() ?: 'check-circle'" class="size-4" />
                            {{ $card->footerLabel() }}
                        </p>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
