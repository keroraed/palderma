@php
  $settings = \App\Models\SiteSetting::first() ?? new \App\Models\SiteSetting();
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, follow">
  <title>الصفحة غير موجودة — {{ $settings->seo_title ?? 'مركز بالديرما' }}</title>
  @if(!empty($settings->favicon))
  <link rel="icon" href="{{ asset($settings->favicon) }}">
  @endif
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ @filemtime(public_path('css/site.css')) }}">
</head>
<body>
  <div dir="rtl" style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 22px;background:linear-gradient(160deg,#4d1022 0%,#6c1830 55%,#4d1022 100%)">
    <div style="max-width:560px;width:100%;text-align:center">

      <img src="{{ asset('images/branding/logo-white-new.svg') }}" alt="بالديرما" style="height:58px;width:auto;margin:0 auto 34px;display:block;filter:drop-shadow(0 10px 20px rgba(0,0,0,.25))">

      <div style="font-size:clamp(64px,16vw,110px);font-weight:900;color:#fff;line-height:1;margin-bottom:10px;letter-spacing:2px">404</div>

      <h1 style="font-size:clamp(21px,4.4vw,27px);font-weight:900;color:#fff;margin:0 0 14px;line-height:1.35">عذراً، الصفحة التي تبحث عنها غير موجودة</h1>

      <p style="font-size:15.5px;line-height:1.85;font-weight:300;color:rgba(255,255,255,.82);margin:0 0 34px">
        ربما تم نقل الصفحة أو تغيير رابطها. يمكنك العودة إلى الصفحة الرئيسية أو تصفّح خدماتنا للوصول إلى ما تبحث عنه.
      </p>

      <div style="display:flex;gap:13px;flex-wrap:wrap;justify-content:center">
        <a href="{{ url('/') }}" style="display:inline-flex;align-items:center;gap:9px;background:#fff;color:#6c1830;padding:14px 30px;border-radius:100px;font-weight:700;font-size:15.5px;box-shadow:0 12px 26px -10px rgba(0,0,0,.35)">
          <span class="material-symbols-outlined" style="font-size:20px">home</span>
          العودة للصفحة الرئيسية
        </a>
        <a href="{{ url('/services') }}" style="display:inline-flex;align-items:center;gap:9px;border:1.5px solid rgba(255,255,255,.5);color:#fff;padding:14px 28px;border-radius:100px;font-weight:500;font-size:15.5px">
          <span class="material-symbols-outlined" style="font-size:20px">spa</span>
          تصفّح خدماتنا
        </a>
      </div>

      <div style="display:flex;gap:22px;flex-wrap:wrap;justify-content:center;margin-top:34px;font-size:14px">
        <a href="{{ url('/#book') }}" style="color:rgba(255,255,255,.72)">احجزي موعدك</a>
        <a href="{{ url('/#about') }}" style="color:rgba(255,255,255,.72)">من نحن</a>
        <a href="{{ url('/#faq') }}" style="color:rgba(255,255,255,.72)">الأسئلة الشائعة</a>
      </div>

    </div>
  </div>
</body>
</html>
