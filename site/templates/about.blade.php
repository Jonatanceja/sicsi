@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
@endphp
<x-layout>
    <x-about.hero :page="$page" />
    <x-about.story :page="$page" />
    <x-about.mission :page="$page" />
    <x-about.goals :page="$page" />
    <x-about.values :page="$page" />
    <x-about.cta :page="$page" />
</x-layout>
