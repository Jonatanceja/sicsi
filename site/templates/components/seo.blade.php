@php
    $site = site();
    $page = page();

    $separator = $site->seoTitleSeparator()->or('|');
    $title = $page->seoTitle()->or($page->title().' '.$separator.' '.$site->title())->value();
    $description = $page->seoDescription()->or($site->seoDescription())->value();
    $isError = $page->intendedTemplate()->name() === 'error';
    $robots = $isError ? 'noindex,nofollow' : $page->seoRobots()->or($site->seoRobots())->or('index,follow')->value();
    $url = $page->url();
    $siteName = $site->seoOgSiteName()->or($site->title())->value();

    $image = $page->ogImage()->toFile() ?? $site->seoOgImage()->toFile();
    $imageUrl = null;
    if ($image) {
        $imageUrl = $image->extension() === 'svg'
            ? $image->url()
            : $image->thumb(['width' => 1200, 'height' => 630, 'crop' => true])->url();
    }

    $ogTitle = $page->ogTitle()->or($title)->value();
    $ogDescription = $page->ogDescription()->or($description)->value();
@endphp
<title>{{ $title }}</title>
@if ($description !== '')
    <meta name="description" content="{{ $description }}" />
@endif
@if ($page->seoKeywords()->isNotEmpty())
    <meta name="keywords" content="{{ implode(', ', $page->seoKeywords()->split()) }}" />
@endif
<meta name="robots" content="{{ $robots }}" />
<meta name="theme-color" content="{{ $site->seoThemeColor()->or('#060b16') }}" />
@unless ($isError)
    <link rel="canonical" href="{{ $url }}" />
@endunless

{{-- Open Graph --}}
<meta property="og:type" content="{{ $page->ogType()->or('website') }}" />
<meta property="og:site_name" content="{{ $siteName }}" />
<meta property="og:locale" content="{{ $site->seoOgLocale()->or('es_MX') }}" />
<meta property="og:url" content="{{ $url }}" />
<meta property="og:title" content="{{ $ogTitle }}" />
@if ($ogDescription !== '')
    <meta property="og:description" content="{{ $ogDescription }}" />
@endif
@if ($imageUrl)
    <meta property="og:image" content="{{ $imageUrl }}" />
    <meta property="og:image:alt" content="{{ $page->ogImageAlt()->or($ogTitle) }}" />
    @if ($image->extension() !== 'svg')
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
    @endif
@endif

{{-- Twitter / X --}}
<meta name="twitter:card" content="{{ $imageUrl ? $site->seoTwitterCard()->or('summary_large_image') : 'summary' }}" />
<meta name="twitter:title" content="{{ $ogTitle }}" />
@if ($ogDescription !== '')
    <meta name="twitter:description" content="{{ $ogDescription }}" />
@endif
@if ($imageUrl)
    <meta name="twitter:image" content="{{ $imageUrl }}" />
@endif
@if ($site->seoTwitterSite()->isNotEmpty())
    <meta name="twitter:site" content="{{ $site->seoTwitterSite() }}" />
@endif
