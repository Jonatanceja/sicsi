@props(['page'])
<section class="relative overflow-hidden border-t-4 border-t-brand-600 bg-ink-950 px-4 py-14 text-white sm:px-6 lg:px-8">
    <div class="container-x flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex max-w-2xl items-start gap-4">
            <span class="grid size-12 shrink-0 place-items-center rounded-xl border border-brand-500/40 bg-brand-500/10 text-brand-400">
                <x-icon :name="$page->ctaIcon()->value() ?: 'exclamation-triangle'" class="size-6" />
            </span>
            <div>
                <h2 class="text-2xl font-extrabold sm:text-3xl">{{ $page->ctaTitle() }}</h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-300">{{ $page->ctaText() }}</p>
            </div>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row">
            @if ($page->ctaPrimaryLabel()->isNotEmpty())
                <a href="{{ $page->ctaPrimaryUrl() }}" class="btn btn-primary">
                    <x-icon :name="$page->ctaPrimaryIcon()->value() ?: 'phone'" class="size-4" />
                    {{ $page->ctaPrimaryLabel() }}
                </a>
            @endif
            @if ($page->ctaSecondaryLabel()->isNotEmpty())
                <a href="{{ $page->ctaSecondaryUrl() }}" class="btn bg-emerald-600 text-white shadow-lg shadow-emerald-600/25 hover:-translate-y-0.5 hover:bg-emerald-700">
                    <x-icon :name="$page->ctaSecondaryIcon()->value() ?: 'chat-bubble'" class="size-4" />
                    {{ $page->ctaSecondaryLabel() }}
                </a>
            @endif
        </div>
    </div>
</section>
