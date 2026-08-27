@props([
    'settings' => null,
    'seoTitle' => null,
    'seoDescription' => null,
    'ogImage' => null,
    'canonical' => null,
    'ogType' => 'website',
    'noindex' => false,
    'articlePublishedTime' => null,
    'articleModifiedTime' => null,
    'articleAuthor' => null,
])
@php
    $pageTitle = $seoTitle ?: ($settings->seo_title ?? 'مجمع بالديرما الطبي — عيادة الجلدية والتجميل والليزر بالرياض');
    $pageDescription = $seoDescription ?: ($settings->seo_description ?? 'احجز موعدك في مجمع بالديرما الطبي بالرياض. نخبة من استشاريي الجلدية والتجميل والليزر بأحدث التقنيات العالمية.');
    $pageImage = $ogImage ? asset($ogImage) : (!empty($settings->seo_og_image) ? asset($settings->seo_og_image) : null);
    $pageCanonical = $canonical ?: url()->current();
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @if(!empty($settings->gtm_id))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $settings->gtm_id }}');</script>
    <!-- End Google Tag Manager -->
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">

    @if($noindex)
    <meta name="robots" content="noindex, nofollow">
    @endif

    <link rel="canonical" href="{{ $pageCanonical }}">

    @if($pageImage)
    <meta property="og:image" content="{{ $pageImage }}">
    <meta name="twitter:image" content="{{ $pageImage }}">
    @endif
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $pageCanonical }}">
    <meta property="og:site_name" content="{{ $settings->seo_title ?? 'مركز بالديرما' }}">
    <meta property="og:locale" content="ar_AR">
    @if($ogType === 'article')
        @if($articlePublishedTime)
        <meta property="article:published_time" content="{{ $articlePublishedTime }}">
        @endif
        @if($articleModifiedTime)
        <meta property="article:modified_time" content="{{ $articleModifiedTime }}">
        @endif
        @if($articleAuthor)
        <meta property="article:author" content="{{ $articleAuthor }}">
        @endif
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">

    @if(!empty($settings->favicon))
    <link rel="icon" href="{{ asset($settings->favicon) }}">
    @endif

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ @filemtime(public_path('css/site.css')) }}">

    {{-- Per-page additions (JSON-LD structured data, etc.) via @push('head') --}}
    @stack('head')
</head>
<body>
    @if(!empty($settings->gtm_id))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings->gtm_id }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif
    {{ $slot }}

    <script src="{{ asset('js/site.js') }}?v={{ @filemtime(public_path('js/site.js')) }}"></script>
    @if(!empty($settings->ga_tracking_id))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->ga_tracking_id }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $settings->ga_tracking_id }}');
    </script>
    @endif
</body>
</html>
