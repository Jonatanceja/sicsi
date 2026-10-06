{{-- Responsive WEBP image through Kirby thumbs. SVGs are served as they are. Pass :eager="true" for the LCP image. --}}
@props(['file', 'alt' => '', 'sizes' => '100vw', 'srcset' => 'default', 'eager' => false, 'width' => 1280])
@php
    $isSvg = $file->extension() === 'svg';
    $main = $isSvg ? $file : $file->thumb(['width' => min($width, $file->width())]);
@endphp
<img
    src="{{ $main->url() }}"
    @unless ($isSvg) srcset="{{ $file->srcset($srcset) }}" sizes="{{ $sizes }}" @endunless
    @if ($main->width()) width="{{ $main->width() }}" height="{{ $main->height() }}" @endif
    alt="{{ $alt }}"
    loading="{{ $eager ? 'eager' : 'lazy' }}"
    decoding="{{ $eager ? 'sync' : 'async' }}"
    @if ($eager) fetchpriority="high" @endif
    {{ $attributes }}
/>
