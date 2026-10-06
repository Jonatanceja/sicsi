@props(['page'])
<section class="section bg-slate-50">
    <div class="container-x">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="eyebrow">{{ $page->valuesEyebrow() }}</span>
                <h2 x-reveal class="mt-3 text-2xl font-extrabold text-slate-900 sm:text-3xl">{{ $page->valuesTitle() }}</h2>
            </div>
            <p class="max-w-xs text-xs leading-relaxed text-slate-500 md:text-right">{{ $page->valuesText() }}</p>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($page->values()->toStructure() as $value)
                <article x-reveal.{{ $loop->index * 100 }} class="card">
                    <span class="grid size-10 place-items-center rounded-xl bg-brand-500/10 text-brand-600">
                        <x-icon :name="$value->icon()->value() ?: 'star'" class="size-5" />
                    </span>
                    <h3 class="mt-4 text-base font-bold text-slate-900">{{ $value->title() }}</h3>
                    <p class="mt-2 text-xs leading-relaxed text-slate-500">{{ $value->text() }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
