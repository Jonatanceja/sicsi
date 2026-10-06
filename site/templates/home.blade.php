@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
@endphp
<x-layout>
    <x-home.hero :page="$page" />
    <x-home.guarantee :page="$page" />
    <x-home.ally :page="$page" />
    <x-home.differentiators :page="$page" />
    <x-home.method :page="$page" />
    <x-home.norms :page="$page" />
    <x-home.quote :page="$page" />
</x-layout>
