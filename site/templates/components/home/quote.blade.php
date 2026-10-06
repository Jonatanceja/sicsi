@props(['page'])
<section id="cotizar" class="section relative overflow-hidden bg-ink-950 text-white">
    <div class="absolute -right-40 -bottom-40 size-[36rem] rounded-full bg-brand-500/15 blur-3xl"></div>
    <div class="container-x relative grid items-start gap-12 lg:grid-cols-2 lg:gap-16">
        <div class="lg:pt-8">
            <span class="eyebrow !text-brand-400">{{ $page->quoteEyebrow() }}</span>
            <h2 x-reveal class="mt-3 text-3xl font-extrabold sm:text-4xl lg:text-5xl">{{ $page->quoteTitle() }}</h2>
            <p x-reveal.100 class="mt-5 max-w-lg leading-relaxed text-slate-300">{{ $page->quoteText() }}</p>

            <ul class="mt-8 space-y-3">
                @foreach ($page->quoteContacts()->toStructure() as $contact)
                    <li>
                        <a href="{{ $contact->url() }}" class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-brand-500/50 hover:bg-white/10">
                            <span class="grid size-12 place-items-center rounded-xl bg-brand-500/15 text-brand-400">
                                <x-icon :name="$contact->icon()->value() ?: 'phone'" class="size-6" />
                            </span>
                            <span>
                                <span class="block text-[0.65rem] font-bold tracking-wider text-slate-400 uppercase">{{ $contact->label() }}</span>
                                <span class="block font-display text-lg font-bold text-white">{{ $contact->value() }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>

            @if ($page->quoteNote()->isNotEmpty())
                <p class="mt-6 flex items-center gap-2 text-xs text-slate-400">
                    <x-icon :name="$page->quoteNoteIcon()->value() ?: 'shield-check'" class="size-4 shrink-0 text-brand-400" />
                    {{ $page->quoteNote() }}
                </p>
            @endif
        </div>

        <x-quote-form x-reveal.100 />
    </div>
</section>
