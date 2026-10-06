@props(['page'])
<section class="section bg-white">
    <div class="container-x max-w-4xl">
        <div class="text-center">
            <span x-reveal class="eyebrow">{{ $page->faqEyebrow() }}</span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $page->faqTitle() }}</h2>
            <p x-reveal.100 class="mx-auto mt-4 max-w-2xl text-slate-600">{{ $page->faqText() }}</p>
        </div>

        <div x-data="{ open: null }" class="mt-12 space-y-3">
            @foreach ($page->faqItems()->toStructure() as $item)
                <div x-reveal.{{ $loop->index * 80 }} class="rounded-xl border bg-white shadow-sm transition" :class="open === {{ $loop->index }} ? 'border-brand-500/40 shadow-md' : 'border-slate-200'">
                    <h3>
                        <button type="button" @click="open = open === {{ $loop->index }} ? null : {{ $loop->index }}" :aria-expanded="open === {{ $loop->index }}" class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left text-sm font-bold text-slate-900 sm:text-base">
                            {{ $item->question() }}
                            <x-icon name="chevron-down" class="size-5 shrink-0 text-brand-700 transition duration-300" ::class="open === {{ $loop->index }} && 'rotate-180'" />
                        </button>
                    </h3>
                    <div x-show="open === {{ $loop->index }}" x-collapse x-cloak>
                        <p class="px-5 pb-5 text-sm leading-relaxed text-slate-600">{{ $item->answer() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
