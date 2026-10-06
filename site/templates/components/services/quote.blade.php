@props(['page'])
<section id="cotizar" class="section bg-slate-50">
    <div class="container-x grid items-start gap-6 lg:grid-cols-5">
        <div x-reveal.left class="relative overflow-hidden rounded-3xl bg-ink-950 p-8 text-white sm:p-10 lg:col-span-2">
            <div class="absolute -top-20 -left-20 size-72 rounded-full bg-brand-500/15 blur-3xl"></div>
            <div class="relative">
                <span x-reveal class="eyebrow !text-brand-400">{{ $page->quoteEyebrow() }}</span>
                <h2 class="mt-3 text-3xl leading-tight font-extrabold">{{ $page->quoteTitle() }}</h2>
                <p class="mt-4 text-sm leading-relaxed text-slate-300">{{ $page->quoteText() }}</p>

                <ul class="mt-8 space-y-3">
                    @foreach ($page->quoteContacts()->toStructure() as $contact)
                        <li>
                            <a href="{{ $contact->url()->or('#') }}" class="group flex items-center gap-4 rounded-xl border border-white/10 bg-white/5 p-3.5 transition hover:border-brand-500/50">
                                <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-brand-500/15 text-brand-400">
                                    <x-icon :name="$contact->icon()->value() ?: 'phone'" class="size-5" />
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-[0.6rem] font-bold tracking-wider text-slate-400 uppercase">{{ $contact->label() }}</span>
                                    <span class="block truncate text-sm font-bold text-white">{{ $contact->value() }}</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                @if ($page->quoteNote()->isNotEmpty())
                    <div class="mt-6 rounded-xl border border-white/10 bg-white/5 p-4">
                        <p class="text-[0.6rem] font-bold tracking-wider text-brand-400 uppercase">{{ $page->quoteNoteTag() }}</p>
                        <p class="mt-1.5 text-xs leading-relaxed text-slate-300">{{ $page->quoteNote() }}</p>
                    </div>
                @endif
            </div>
        </div>

        <x-quote-form x-reveal.right.100 class="lg:col-span-3" />
    </div>
</section>
