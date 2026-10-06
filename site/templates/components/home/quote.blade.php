@props(['page'])
@php
    $input = 'w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-brand-500 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:outline-none';
    $label = 'mb-1.5 block text-xs font-semibold text-slate-700';
@endphp
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

        <div x-reveal.100 class="rounded-3xl bg-white p-6 text-slate-800 shadow-2xl shadow-black/40 sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="font-display text-xl font-bold text-slate-900">{{ $page->formTitle() }}</h3>
                    <p class="mt-1 text-xs text-slate-500">{{ $page->formText() }}</p>
                </div>
                @if ($page->formBadge()->isNotEmpty())
                    <span class="shrink-0 rounded-md bg-brand-500/10 px-2.5 py-1 text-[0.6rem] font-bold tracking-wider text-brand-600 uppercase">{{ $page->formBadge() }}</span>
                @endif
            </div>

            <form
                x-data="quoteForm({{ json_encode(['endpoint' => url('cotizar'), 'success' => $page->formSuccess()->value(), 'error' => $page->formError()->value(), 'extras' => ['course' => 'Curso de interés', 'people' => 'Número de personas', 'modality' => 'Modalidad']], JSON_UNESCAPED_UNICODE) }})"
                @submit.prevent="submit"
                novalidate
                class="mt-6 grid gap-4 sm:grid-cols-2"
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
                    <label for="q-course" class="{{ $label }}">{{ $page->formCourseLabel() }}</label>
                    <select id="q-course" x-model="fields.course" class="{{ $input }}">
                        @foreach ($page->formCourseOptions()->toStructure() as $option)
                            <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="q-people" class="{{ $label }}">{{ $page->formPeopleLabel() }}</label>
                    <input id="q-people" type="text" x-model="fields.people" placeholder="{{ $page->formPeoplePlaceholder() }}" class="{{ $input }}" />
                </div>
                <div>
                    <label for="q-modality" class="{{ $label }}">{{ $page->formModalityLabel() }}</label>
                    <select id="q-modality" x-model="fields.modality" class="{{ $input }}">
                        @foreach ($page->formModalityOptions()->toStructure() as $option)
                            <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" :disabled="status === 'sending'" class="btn btn-primary w-full disabled:opacity-60 sm:col-span-2">
                    <span>{{ $page->formSubmitLabel() }}</span>
                    <x-icon :name="$page->formSubmitIcon()->value() ?: 'arrow-right'" class="size-4" />
                </button>

                <p x-show="message" x-cloak x-text="message" :class="status === 'sent' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'" class="rounded-lg px-3 py-2 text-xs font-medium sm:col-span-2" role="status"></p>
            </form>
        </div>
    </div>
</section>
