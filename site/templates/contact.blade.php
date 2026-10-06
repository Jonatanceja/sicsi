@php
    /**
     * @var Kirby\Cms\App $kirby
     * @var Kirby\Cms\Page $page
     * @var Kirby\Cms\Site $site
     */
@endphp
<x-layout>
    <x-contact.hero :page="$page" />
    <x-contact.main :page="$page" />
    <x-contact.faq :page="$page" />
    <x-contact.cta :page="$page" />
</x-layout>
