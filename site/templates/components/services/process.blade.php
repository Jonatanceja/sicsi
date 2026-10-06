@props(['page'])
<section id="proceso" class="section bg-slate-50">
    <div class="container-x">
        <div class="mx-auto max-w-3xl text-center">
            <span x-reveal class="eyebrow">{{ $page->processEyebrow() }}</span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->processTitle() }}</h2>
            <p x-reveal.100 class="mt-4 text-slate-600">{{ $page->processText() }}</p>
        </div>

        <ol class="mt-14 grid gap-4 md:grid-cols-2 lg:grid-cols-5">
            @foreach ($page->processSteps()->toStructure() as $step)
                @php($featured = $step->featured()->toBool())
                <li x-reveal.{{ $loop->index * 100 }} class="flex flex-col rounded-2xl border p-5 transition hover:-translate-y-1 {{ $featured ? 'border-ink-900 bg-ink-900 text-white shadow-xl shadow-ink-900/20' : 'border-slate-200 bg-white shadow-sm hover:shadow-lg' }}">
                    <div class="flex items-start justify-between">
                        <span class="font-display text-3xl font-extrabold {{ $featured ? 'text-brand-400' : 'text-slate-300' }}">{{ sprintf('%02d', $loop->iteration) }}</span>
                        <span class="grid size-8 place-items-center rounded-lg {{ $featured ? 'bg-white/10 text-brand-400' : 'bg-brand-500/10 text-brand-700' }}">
                            <x-icon :name="$step->icon()->value() ?: 'check-circle'" class="size-4" />
                        </span>
                    </div>
                    <h3 class="mt-4 text-base font-bold {{ $featured ? 'text-white' : 'text-slate-900' }}">{{ $step->title() }}</h3>
                    <p class="mt-2 flex-1 text-xs leading-relaxed {{ $featured ? 'text-slate-300' : 'text-slate-500' }}">{{ $step->text() }}</p>
                    @if ($step->tags()->isNotEmpty())
                        <ul class="mt-4 flex flex-wrap gap-1.5">
                            @foreach ($step->tags()->split() as $tag)
                                <li class="rounded-md px-2 py-1 text-[0.6rem] font-semibold {{ $featured ? 'bg-emerald-500/15 text-emerald-300' : 'bg-slate-100 text-slate-600' }}">{{ $tag }}</li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</section>
