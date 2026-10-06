@props(['page'])
<section class="section relative overflow-hidden bg-ink-950 text-white">
    <div class="absolute inset-x-0 top-0 -z-0 h-px bg-linear-to-r from-transparent via-brand-500/60 to-transparent"></div>
    <div class="container-x relative">
        <div class="mx-auto max-w-3xl text-center">
            <span class="eyebrow !text-brand-400">{{ $page->methodEyebrow() }}</span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold sm:text-4xl">{{ $page->methodTitle() }}</h2>
            <p x-reveal.100 class="mt-4 text-slate-400">{{ $page->methodText() }}</p>
        </div>

        <ol class="relative mt-16 grid gap-4 md:grid-cols-2 lg:grid-cols-5">
            @foreach ($page->methodSteps()->toStructure() as $step)
                <li x-reveal.{{ $loop->index * 100 }} class="group relative rounded-2xl border border-white/10 bg-ink-800/60 p-5 transition hover:-translate-y-1 hover:border-brand-500/50">
                    <div class="flex items-center justify-between">
                        <span class="grid size-9 place-items-center rounded-lg bg-brand-500 font-display text-sm font-extrabold text-white">{{ $loop->iteration }}</span>
                        <x-icon :name="$step->icon()->value() ?: 'check-circle'" class="size-5 text-slate-500 transition group-hover:text-brand-400" />
                    </div>
                    <h3 class="mt-5 text-base font-bold">{{ $step->title() }}</h3>
                    <p class="mt-2 text-xs leading-relaxed text-slate-400">{{ $step->text() }}</p>
                    <p class="mt-4 text-[0.6rem] font-bold tracking-[0.18em] text-brand-400 uppercase">{{ $step->phase() }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
