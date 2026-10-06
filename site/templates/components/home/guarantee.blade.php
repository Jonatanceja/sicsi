@props(['page'])
<section class="section bg-slate-50">
    <div class="container-x">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                @if ($page->guaranteeBadge()->isNotEmpty())
                    <span class="eyebrow !text-emerald-700">
                        <x-icon :name="$page->guaranteeBadgeIcon()->value() ?: 'check-circle'" class="size-4" />
                        {{ $page->guaranteeBadge() }}
                    </span>
                @endif
                <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->guaranteeTitle() }}</h2>
                <p x-reveal.100 class="mt-4 text-base leading-relaxed text-slate-600">{{ $page->guaranteeText() }}</p>
            </div>
            @if ($page->guaranteeRegistry()->isNotEmpty())
                <span class="inline-flex items-center gap-2 self-start rounded-xl border border-emerald-200 bg-white px-4 py-2.5 text-xs font-bold text-emerald-700 shadow-sm lg:self-auto">
                    <x-icon :name="$page->guaranteeRegistryIcon()->value() ?: 'check-circle'" class="size-4" />
                    {{ $page->guaranteeRegistry() }}
                </span>
            @endif
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($page->guaranteeStats()->toStructure() as $stat)
                <article x-reveal.{{ $loop->index * 100 }} class="card">
                    <span class="grid size-11 place-items-center rounded-xl bg-brand-500/10 text-brand-600">
                        <x-icon :name="$stat->icon()->value() ?: 'chart-bar'" class="size-5" />
                    </span>
                    <p class="mt-5 font-display text-4xl font-extrabold text-slate-900">{{ $stat->value() }}</p>
                    <h3 class="mt-1 text-sm font-bold text-slate-800">{{ $stat->label() }}</h3>
                    <p class="mt-2 text-xs leading-relaxed text-slate-500">{{ $stat->text() }}</p>
                </article>
            @endforeach
        </div>

        <ul class="mt-5 grid gap-5 md:grid-cols-3">
            @foreach ($page->guaranteeChecks()->toStructure() as $check)
                <li x-reveal.{{ $loop->index * 100 }} class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-5">
                    <x-icon :name="$check->icon()->value() ?: 'check-circle'" class="mt-0.5 size-6 shrink-0 text-emerald-600" />
                    <span>
                        <span class="block text-sm font-bold text-slate-900">{{ $check->title() }}</span>
                        <span class="block text-xs text-slate-500">{{ $check->text() }}</span>
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</section>
