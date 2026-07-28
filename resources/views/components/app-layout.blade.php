@props(['settings' => null])
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings->seo_title ?? 'مجمع بالديرما الطبي — عيادة الجلدية والتجميل والليزر بالرياض' }}</title>
    <meta name="description" content="{{ $settings->seo_description ?? 'احجز موعدك في مجمع بالديرما الطبي بالرياض. نخبة من استشاريي الجلدية والتجميل والليزر بأحدث التقنيات العالمية.' }}">
    
    @if(!empty($settings->seo_og_image))
    <meta property="og:image" content="{{ asset($settings->seo_og_image) }}">
    @endif
    <meta property="og:title" content="{{ $settings->seo_title ?? 'مجمع بالديرما الطبي' }}">
    <meta property="og:description" content="{{ $settings->seo_description ?? '' }}">
    <meta property="og:type" content="website">

    @if(!empty($settings->favicon))
    <link rel="icon" href="{{ asset($settings->favicon) }}">
    @endif

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ @filemtime(public_path('css/site.css')) }}">
</head>
<body>
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
