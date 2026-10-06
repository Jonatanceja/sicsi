{{-- Shared quote form. Every label, placeholder and option comes from the site blueprint (Formulario tab). --}}
@php
    $site = site();
    $input = 'w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-brand-500 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:outline-none';
    $select = $input . ' select-chevron';
    $label = 'mb-1.5 block text-xs font-semibold text-slate-700';
    $clean = fn ($text) => trim(str_replace('*', '', $text));
@endphp
<div {{ $attributes->class(['rounded-3xl border border-slate-200 bg-white p-6 text-slate-800 shadow-2xl shadow-slate-900/10 sm:p-8']) }}>
    @if ($site->formTitle()->isNotEmpty() || $site->formBadge()->isNotEmpty())
        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h3 class="font-display text-xl font-bold text-slate-900">{{ $site->formTitle() }}</h3>
                @if ($site->formText()->isNotEmpty())
                    <p class="mt-1 text-xs text-slate-500">{{ $site->formText() }}</p>
                @endif
            </div>
            @if ($site->formBadge()->isNotEmpty())
                <span class="shrink-0 rounded-md bg-brand-500/10 px-2.5 py-1 text-[0.6rem] font-bold tracking-wider text-brand-700 uppercase">{{ $site->formBadge() }}</span>
            @endif
        </div>
    @endif

    <form
        aria-label="{{ $site->formTitle() }}"
        x-data="quoteForm({{ json_encode([
            'endpoint' => url('cotizar'),
            'success' => $site->formSuccess()->value(),
            'error' => $site->formError()->value(),
            'extras' => [
                'service' => $clean($site->formServiceLabel()->value()),
                'location' => $clean($site->formLocationLabel()->value()),
                'people' => $clean($site->formPeopleLabel()->value()),
                'modality' => $clean($site->formModalityLabel()->value()),
                'comments' => $clean($site->formCommentsLabel()->value()),
            ],
        ], JSON_UNESCAPED_UNICODE) }})"
        @submit.prevent="submit"
        novalidate
        class="grid gap-4 sm:grid-cols-2"
    >
        {{-- Honeypot: real users never see or fill this --}}
        <input type="text" x-model="fields.website" tabindex="-1" autocomplete="off" aria-hidden="true" class="absolute -left-[9999px] h-0 w-0 opacity-0" />

        <div>
            <label for="q-name" class="{{ $label }}">{{ $site->formNameLabel() }}</label>
            <input id="q-name" type="text" x-model="fields.name" :class="errors.name && 'border-red-400'" :aria-invalid="errors.name ? 'true' : 'false'" aria-required="true" aria-describedby="q-name-err" placeholder="{{ $site->formNamePlaceholder() }}" autocomplete="name" class="{{ $input }}" />
            <p id="q-name-err" x-show="errors.name" x-cloak class="mt-1 text-xs font-medium text-red-700">{{ $site->formFieldError()->or('Revisa este campo.') }}</p>
        </div>
        <div>
            <label for="q-company" class="{{ $label }}">{{ $site->formCompanyLabel() }}</label>
            <input id="q-company" type="text" x-model="fields.company" :class="errors.company && 'border-red-400'" :aria-invalid="errors.company ? 'true' : 'false'" aria-required="true" aria-describedby="q-company-err" placeholder="{{ $site->formCompanyPlaceholder() }}" autocomplete="organization" class="{{ $input }}" />
            <p id="q-company-err" x-show="errors.company" x-cloak class="mt-1 text-xs font-medium text-red-700">{{ $site->formFieldError()->or('Revisa este campo.') }}</p>
        </div>
        <div>
            <label for="q-email" class="{{ $label }}">{{ $site->formEmailLabel() }}</label>
            <input id="q-email" type="email" x-model="fields.email" :class="errors.email && 'border-red-400'" :aria-invalid="errors.email ? 'true' : 'false'" aria-required="true" aria-describedby="q-email-err" placeholder="{{ $site->formEmailPlaceholder() }}" autocomplete="email" class="{{ $input }}" />
            <p id="q-email-err" x-show="errors.email" x-cloak class="mt-1 text-xs font-medium text-red-700">{{ $site->formFieldError()->or('Revisa este campo.') }}</p>
        </div>
        <div>
            <label for="q-phone" class="{{ $label }}">{{ $site->formPhoneLabel() }}</label>
            <input id="q-phone" type="tel" x-model="fields.phone" :class="errors.phone && 'border-red-400'" :aria-invalid="errors.phone ? 'true' : 'false'" aria-required="true" aria-describedby="q-phone-err" placeholder="{{ $site->formPhonePlaceholder() }}" autocomplete="tel" class="{{ $input }}" />
            <p id="q-phone-err" x-show="errors.phone" x-cloak class="mt-1 text-xs font-medium text-red-700">{{ $site->formFieldError()->or('Revisa este campo.') }}</p>
        </div>
        <div class="sm:col-span-2">
            <label for="q-service" class="{{ $label }}">{{ $site->formServiceLabel() }}</label>
            <select id="q-service" x-model="fields.service" class="{{ $select }}">
                @foreach ($site->formServiceOptions()->toStructure() as $option)
                    <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="q-location" class="{{ $label }}">{{ $site->formLocationLabel() }}</label>
            <input id="q-location" type="text" x-model="fields.location" placeholder="{{ $site->formLocationPlaceholder() }}" class="{{ $input }}" />
        </div>
        <div>
            <label for="q-people" class="{{ $label }}">{{ $site->formPeopleLabel() }}</label>
            <select id="q-people" x-model="fields.people" class="{{ $select }}">
                @foreach ($site->formPeopleOptions()->toStructure() as $option)
                    <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2">
            <label for="q-modality" class="{{ $label }}">{{ $site->formModalityLabel() }}</label>
            <select id="q-modality" x-model="fields.modality" class="{{ $select }}">
                @foreach ($site->formModalityOptions()->toStructure() as $option)
                    <option value="{{ $option->label() }}">{{ $option->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2">
            <label for="q-comments" class="{{ $label }}">{{ $site->formCommentsLabel() }}</label>
            <textarea id="q-comments" rows="3" x-model="fields.comments" placeholder="{{ $site->formCommentsPlaceholder() }}" class="{{ $input }}"></textarea>
        </div>

        <button type="submit" :disabled="status === 'sending'" class="btn btn-primary w-full disabled:opacity-60 sm:col-span-2">
            <x-icon :name="$site->formSubmitIcon()->value() ?: 'arrow-right'" class="size-4" />
            <span>{{ $site->formSubmitLabel() }}</span>
        </button>

        <p x-show="message" x-cloak x-text="message" :class="status === 'sent' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'" class="rounded-lg px-3 py-2 text-xs font-medium sm:col-span-2" role="status" aria-live="polite"></p>
    </form>
</div>
