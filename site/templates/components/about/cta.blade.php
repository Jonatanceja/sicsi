@props(['page'])
<section class="section relative overflow-hidden bg-ink-950 text-white">
    <div class="absolute -right-32 -bottom-32 size-[30rem] rounded-full bg-brand-500/15 blur-3xl"></div>
    <div class="container-x relative flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-2xl">
            <span x-reveal class="eyebrow !text-brand-400">
                @if ($page->ctaEyebrowIcon()->isNotEmpty())
                    <x-icon :name="$page->ctaEyebrowIcon()->value()" class="size-4" />
                @endif
                {{ $page->ctaEyebrow() }}
            </span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold sm:text-4xl">{{ $page->ctaTitle() }}</h2>
            <p x-reveal.100 class="mt-4 text-slate-300">{{ $page->ctaText() }}</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row lg:flex-col xl:flex-row">
            @if ($page->ctaPrimaryLabel()->isNotEmpty())
                <a href="{{ $page->ctaPrimaryUrl() }}" class="btn btn-primary">
                    {{ $page->ctaPrimaryLabel() }}
                    <x-icon :name="$page->ctaPrimaryIcon()->value() ?: 'arrow-right'" class="size-4" />
                </a>
            @endif
            @if ($page->ctaSecondaryLabel()->isNotEmpty())
                <a href="{{ $page->ctaSecondaryUrl() }}" class="btn btn-ghost">{{ $page->ctaSecondaryLabel() }}</a>
            @endif
        </div>
    </div>
</section>
