@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
@endphp
<x-layout>
    <x-services.hero :page="$page" />
    <x-services.process :page="$page" />
    <x-services.training :page="$page" />
    <x-services.brigades :page="$page" />
    <x-services.consulting :page="$page" />
    <x-services.quote :page="$page" />
</x-layout>
