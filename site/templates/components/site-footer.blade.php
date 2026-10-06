@php
    $site = site();
@endphp
<footer class="border-t border-white/5 bg-ink-950 text-slate-400">
    <div class="container-x grid gap-12 px-4 py-16 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
        <div class="space-y-5">
            <p class="font-display text-2xl font-extrabold text-white">{{ $site->brandName() }}</p>
            <p class="text-sm leading-relaxed">{{ $site->footerDescription() }}</p>
            @if ($site->footerBadge()->isNotEmpty())
                <span class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 text-[0.7rem] font-bold tracking-wider text-slate-200 uppercase">
                    <x-icon :name="$site->footerBadgeIcon()->value() ?: 'shield-check'" class="size-4 text-brand-400" />
                    {{ $site->footerBadge() }}
                </span>
            @endif
        </div>

        <div>
            <h3 class="mb-5 text-sm font-bold text-white">{{ $site->footerServicesTitle() }}</h3>
            <ul class="space-y-3 text-sm">
                @foreach ($site->footerServices()->toStructure() as $item)
                    <li><a href="{{ url($item->url()->or('#')->value()) }}" class="transition hover:text-brand-400">{{ $item->label() }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="mb-5 text-sm font-bold text-white">{{ $site->footerRegulationTitle() }}</h3>
            <ul class="space-y-3 text-sm">
                @foreach ($site->footerRegulation()->toStructure() as $item)
                    <li><strong class="font-bold text-white">{{ $item->code() }}:</strong> {{ $item->text() }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="mb-5 text-sm font-bold text-white">{{ $site->footerContactTitle() }}</h3>
            <div class="space-y-3 text-sm">
                <p>{{ $site->footerContactText() }}</p>
                @if ($site->footerPhone()->isNotEmpty())
                    <p><a href="tel:{{ preg_replace('/[^\d+]/', '', $site->footerPhone()) }}" class="flex items-center gap-2 font-semibold text-white transition hover:text-brand-400"><x-icon name="phone" class="size-4 text-brand-400" />{{ $site->footerPhone() }}</a></p>
                @endif
                @if ($site->footerEmail()->isNotEmpty())
                    <p><a href="mailto:{{ $site->footerEmail() }}" class="flex items-center gap-2 transition hover:text-white"><x-icon name="envelope" class="size-4 text-brand-400" />{{ $site->footerEmail() }}</a></p>
                @endif
                @if ($site->footerHours()->isNotEmpty())
                    <p class="flex items-center gap-2"><x-icon name="clock" class="size-4 text-brand-400" />{{ $site->footerHours() }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="border-t border-white/5">
        <div class="container-x flex flex-col items-center justify-between gap-3 px-4 py-6 text-xs sm:px-6 md:flex-row lg:px-8">
            <p>{{ $site->footerCopyright() }}</p>
            <ul class="flex flex-wrap items-center gap-x-6 gap-y-2">
                @foreach ($site->footerLinks()->toStructure() as $item)
                    <li><a href="{{ url($item->url()->or('#')->value()) }}" class="transition hover:text-white">{{ $item->label() }}</a></li>
                @endforeach
            </ul>
        </div>

        @if ($site->footerCreditText()->isNotEmpty())
            <div class="border-t border-white/5">
                <div class="container-x flex items-center justify-center gap-3 px-4 py-4 text-xs sm:px-6 md:justify-end lg:px-8">
                    <a href="{{ $site->footerCreditUrl()->or('#') }}" target="_blank" rel="noopener" class="group flex items-center gap-2.5 transition hover:text-white">
                        <span>{{ $site->footerCreditText() }}</span>
                        @if ($credit = $site->footerCreditLogo()->toFile())
                            <img src="{{ $credit->url() }}" alt="" class="h-5 w-auto opacity-80 transition group-hover:opacity-100" loading="lazy" />
                        @endif
                    </a>
                </div>
            </div>
        @endif
    </div>
</footer>
