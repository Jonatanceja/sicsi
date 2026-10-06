@props(['page'])
<section class="section bg-white">
    <div class="container-x">
        <span class="eyebrow">{{ $page->goalsEyebrow() }}</span>
        <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->goalsTitle() }}</h2>
        <p x-reveal.100 class="mt-3 text-slate-600">{{ $page->goalsText() }}</p>

        <div class="mt-12 grid gap-6 lg:grid-cols-3">
            @foreach ($page->goals()->toStructure() as $goal)
                <article x-reveal.{{ $loop->index * 100 }} class="card flex flex-col bg-slate-50 p-7">
                    <div class="flex items-start justify-between">
                        <p class="font-display text-5xl font-extrabold text-brand-600">{{ $goal->value() }}</p>
                        <span class="grid size-9 place-items-center rounded-lg bg-white text-emerald-600 shadow-sm">
                            <x-icon :name="$goal->icon()->value() ?: 'check-circle'" class="size-5" />
                        </span>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">{{ $goal->title() }}</h3>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ $goal->text() }}</p>
                    @if ($goal->tags()->isNotEmpty())
                        <ul class="mt-5 flex flex-wrap gap-2">
                            @foreach ($goal->tags()->split() as $tag)
                                <li class="rounded-md border border-slate-200 bg-white px-2.5 py-1 text-[0.65rem] font-semibold text-slate-600">{{ $tag }}</li>
                            @endforeach
                        </ul>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
