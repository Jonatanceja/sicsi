@props(['page'])
@php
    $input = 'w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-brand-500 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:outline-none';
    $label = 'mb-1.5 block text-xs font-semibold text-slate-700';
    $clean = fn ($text) => trim(str_replace('*', '', $text));
@endphp
<section id="cotizar" class="section bg-slate-50">
    <div class="container-x overflow-hidden rounded-3xl bg-white shadow-2xl shadow-slate-900/10 lg:grid lg:grid-cols-5">
        <div class="relative bg-ink-950 p-8 text-white sm:p-10 lg:col-span-2">
            <div class="absolute -top-20 -left-20 size-72 rounded-full bg-brand-500/15 blur-3xl"></div>
            <div class="relative">
                <span class="eyebrow !text-brand-400">{{ $page->quoteEyebrow() }}</span>
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

        <form
            x-data="quoteForm({{ json_encode([
                'endpoint' => url('cotizar'),
                'success' => $page->formSuccess()->value(),
                'error' => $page->formError()->value(),
                'extras' => [
                    'service' => $clean($page->formServiceLabel()->value()),
                    'location' => $clean($page->formLocationLabel()->value()),
                    'people' => $clean($page->formPeopleLabel()->value()),
                    'modality' => $clean($page->formModalityLabel()->value()),
                    'comments' => $clean($page->formCommentsLabel()->value()),
                ],
            ], JSON_UNESCAPED_UNICODE) }})"
            @submit.prevent="submit"
            novalidate
            class="grid gap-4 p-8 sm:grid-cols-2 sm:p-10 lg:col-span-3"
        >
            <div>
                <label for="q-name" class="{{ $label }}">{{ $page->formNameLabel() }}</label>
                <input id="q-name" type="text" x-model="fields.name" :class="errors.name && 'border-red-400'" placeholder="{{ $page->formNamePlaceholder() }}" autocomplete="name" class="{{ $input }}" />
            </div>
            <div>
                <label for="q-company" class="{{ $label }}">{{ $page->formCompanyLabel() }}</label>
                <input id="q-company" type="text" x-model="fields.company" :class="errors.company && 'border-red-400'" placeholder="{{ $page->formCompanyPlaceholder() }}" autocomplete="organization" class="{{ $input }}" />
            </div>
            <div>
                <label for="q-email" class="{{ $label }}">{{ $page->formEmailLabel() }}</label>
                <input id="q-email" type="email" x-model="fields.email" :class="errors.email && 'border-red-400'" placeholder="{{ $page->formEmailPlaceholder() }}" autocomplete="email" class="{{ $input }}" />
            </div>
            <div>
                <label for="q-phone" class="{{ $label }}">{{ $page->formPhoneLabel() }}</label>
                <input id="q-phone" type="tel" x-model="fields.phone" :class="errors.phone && 'border-red-400'" placeholder="{{ $page->formPhonePlaceholder() }}" autocomplete="tel" class="{{ $input }}" />
            </div>
            <div class="sm:col-span-2">
                <label for="q-service" class="{{ $label }}">{{ $page->formServiceLabel() }}</label>
                <select id="q-service" x-model="fields.service" class="{{ $input }}">
                    @foreach ($page->formServiceOptions()->toStructure() as $option)
                        <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="q-location" class="{{ $label }}">{{ $page->formLocationLabel() }}</label>
                <input id="q-location" type="text" x-model="fields.location" placeholder="{{ $page->formLocationPlaceholder() }}" class="{{ $input }}" />
            </div>
            <div>
                <label for="q-people" class="{{ $label }}">{{ $page->formPeopleLabel() }}</label>
                <select id="q-people" x-model="fields.people" class="{{ $input }}">
                    @foreach ($page->formPeopleOptions()->toStructure() as $option)
                        <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label for="q-modality" class="{{ $label }}">{{ $page->formModalityLabel() }}</label>
                <select id="q-modality" x-model="fields.modality" class="{{ $input }}">
                    @foreach ($page->formModalityOptions()->toStructure() as $option)
                        <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label for="q-comments" class="{{ $label }}">{{ $page->formCommentsLabel() }}</label>
                <textarea id="q-comments" rows="3" x-model="fields.comments" placeholder="{{ $page->formCommentsPlaceholder() }}" class="{{ $input }}"></textarea>
            </div>

            <button type="submit" :disabled="status === 'sending'" class="btn btn-primary w-full disabled:opacity-60 sm:col-span-2">
                <x-icon :name="$page->formSubmitIcon()->value() ?: 'arrow-right'" class="size-4" />
                <span>{{ $page->formSubmitLabel() }}</span>
            </button>

            <p x-show="message" x-cloak x-text="message" :class="status === 'sent' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'" class="rounded-lg px-3 py-2 text-xs font-medium sm:col-span-2" role="status"></p>
        </form>
    </div>
</section>
