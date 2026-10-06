@props(['page'])
<section class="relative isolate flex min-h-[70vh] items-center overflow-hidden bg-ink-950 px-4 py-20 text-white sm:px-6 lg:px-8">
    <div class="absolute top-1/2 left-1/2 -z-10 size-[34rem] -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-500/15 blur-3xl"></div>
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3.5rem_3.5rem] mask-[radial-gradient(ellipse_at_center,black_25%,transparent_75%)]"></div>

    <div class="container-x text-center">
        <p class="animate-fade-up font-display text-[7rem] leading-none font-extrabold sm:text-[10rem]">
            <span class="bg-linear-to-b from-brand-400 to-brand-600 bg-clip-text text-transparent">{{ $page->errorCode()->or('404') }}</span>
        </p>

        @if ($page->errorEyebrow()->isNotEmpty())
            <span class="eyebrow mt-4 animate-fade-up !text-brand-400 [animation-delay:100ms]">
                <x-icon :name="$page->errorIcon()->value() ?: 'exclamation-triangle'" class="size-4" />
                {{ $page->errorEyebrow() }}
            </span>
        @endif

        <h1 class="mx-auto mt-4 max-w-2xl animate-fade-up text-3xl font-extrabold [animation-delay:150ms] sm:text-4xl">{{ $page->errorTitle() }}</h1>
        <p class="mx-auto mt-4 max-w-xl animate-fade-up text-base leading-relaxed text-slate-300 [animation-delay:200ms]">{{ $page->errorText() }}</p>

        <div class="mt-8 flex animate-fade-up flex-col items-center justify-center gap-3 [animation-delay:250ms] sm:flex-row">
            @if ($page->errorPrimaryLabel()->isNotEmpty())
                <a href="{{ url($page->errorPrimaryUrl()->or('/')->value()) }}" class="btn btn-primary">
                    {{ $page->errorPrimaryLabel() }}
                    <x-icon :name="$page->errorPrimaryIcon()->value() ?: 'arrow-right'" class="size-4" />
                </a>
            @endif
            @if ($page->errorSecondaryLabel()->isNotEmpty())
                <a href="{{ url($page->errorSecondaryUrl()->or('/contacto')->value()) }}" class="btn btn-ghost">{{ $page->errorSecondaryLabel() }}</a>
            @endif
        </div>

        @if ($page->errorLinks()->isNotEmpty())
            <div class="mx-auto mt-16 max-w-4xl text-left">
                <p class="text-center text-xs font-bold tracking-[0.18em] text-slate-400 uppercase">{{ $page->errorLinksTitle() }}</p>
                <ul class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($page->errorLinks()->toStructure() as $link)
                        <li>
                            <a href="{{ url($link->url()->or('/')->value()) }}" class="group flex h-full flex-col rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur transition hover:-translate-y-1 hover:border-brand-500/50 hover:bg-white/10">
                                <x-icon :name="$link->icon()->value() ?: 'arrow-right'" class="size-5 text-brand-400" />
                                <span class="mt-3 text-sm font-bold text-white">{{ $link->label() }}</span>
                                @if ($link->text()->isNotEmpty())
                                    <span class="mt-1 text-xs text-slate-400">{{ $link->text() }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($page->errorContactText()->isNotEmpty())
            <p class="mt-10 flex flex-wrap items-center justify-center gap-x-2 gap-y-1 text-sm text-slate-400">
                <x-icon :name="$page->errorContactIcon()->value() ?: 'phone'" class="size-4 text-brand-400" />
                {{ $page->errorContactText() }}
                <a href="{{ $page->errorContactUrl()->or('#') }}" class="font-bold text-white transition hover:text-brand-400">{{ $page->errorContactLabel() }}</a>
            </p>
        @endif
    </div>
</section>
