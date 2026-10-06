@props(['page'])
<section id="formulario" class="section bg-slate-50">
    <div class="container-x grid items-start gap-8 lg:grid-cols-5">
        <div class="space-y-6 lg:col-span-2">
            {{-- Channels --}}
            <div x-reveal class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="flex items-center gap-2.5 text-base font-bold text-slate-900">
                    <x-icon :name="$page->channelsIcon()->value() ?: 'phone'" class="size-5 text-brand-600" />
                    {{ $page->channelsTitle() }}
                </h2>
                <ul class="mt-5 space-y-3">
                    @foreach ($page->channels()->toStructure() as $channel)
                        @php($green = $channel->highlighted()->toBool())
                        <li>
                            <a href="{{ $channel->url()->or('#') }}" class="group block rounded-xl border p-4 transition hover:-translate-y-0.5 hover:shadow-md {{ $green ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-slate-50' }}">
                                <div class="flex items-start gap-3.5">
                                    <span class="grid size-10 shrink-0 place-items-center rounded-lg text-white {{ $green ? 'bg-emerald-600' : 'bg-ink-900' }}">
                                        <x-icon :name="$channel->icon()->value() ?: 'phone'" class="size-5" />
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-[0.6rem] font-bold tracking-wider uppercase {{ $green ? 'text-emerald-700' : 'text-slate-500' }}">{{ $channel->label() }}</span>
                                        <span class="block truncate text-base font-bold text-slate-900">{{ $channel->value() }}</span>
                                        @if ($channel->text()->isNotEmpty())
                                            <span class="mt-0.5 block text-xs text-slate-500">{{ $channel->text() }}</span>
                                        @endif
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>

                @if ($page->note()->isNotEmpty())
                    <div class="mt-4 rounded-xl border border-brand-500/20 bg-brand-500/5 p-4">
                        <p class="flex items-center gap-1.5 text-[0.6rem] font-bold tracking-wider text-brand-600 uppercase">
                            <x-icon :name="$page->noteIcon()->value() ?: 'shield-check'" class="size-4" />
                            {{ $page->noteTag() }}
                        </p>
                        <p class="mt-1.5 text-xs leading-relaxed text-slate-600">{{ $page->note() }}</p>
                    </div>
                @endif
            </div>

            {{-- Offices --}}
            <div x-reveal.100 class="rounded-2xl border border-slate-200 border-t-4 border-t-brand-600 bg-white p-6 shadow-sm">
                <h2 class="flex items-center gap-2.5 text-base font-bold text-slate-900">
                    <x-icon :name="$page->officesIcon()->value() ?: 'building-office'" class="size-5 text-brand-600" />
                    {{ $page->officesTitle() }}
                </h2>
                <ul class="mt-5 divide-y divide-slate-100">
                    @foreach ($page->offices()->toStructure() as $office)
                        <li class="flex items-start gap-3 py-3.5 first:pt-0 last:pb-0">
                            <x-icon :name="$office->icon()->value() ?: 'map-pin'" class="mt-0.5 size-5 shrink-0 text-brand-500" />
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $office->title() }}</p>
                                <p class="mt-1 text-xs leading-relaxed text-slate-500">{{ $office->text() }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Urgent notice --}}
            @if ($page->urgentTitle()->isNotEmpty())
                <div x-reveal.200 class="rounded-2xl border-l-4 border-l-brand-500 bg-ink-900 p-6 text-white">
                    <div class="flex items-start gap-3">
                        <x-icon :name="$page->urgentIcon()->value() ?: 'exclamation-triangle'" class="mt-0.5 size-6 shrink-0 text-brand-400" />
                        <div>
                            <h3 class="text-base font-bold">{{ $page->urgentTitle() }}</h3>
                            <p class="mt-2 text-xs leading-relaxed text-slate-300">{{ $page->urgentText() }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <x-quote-form x-reveal.100 class="lg:col-span-3" />
    </div>
</section>
