<x-app-layout :settings="$settings">

  <div dir="rtl" style="min-height:100vh;width:100%;background:linear-gradient(160deg,#4d1022 0%,#6c1830 55%,#4d1022 100%);display:flex;justify-content:center;padding:64px 20px">
    <div style="max-width:460px;width:100%;text-align:center">

      <img src="{{ asset($hubSettings->logo ?? 'images/branding/logo-white-new.svg') }}" alt="{{ $hubSettings->title ?? 'بالديرما' }}" style="height:68px;width:auto;margin:0 auto 24px;display:block;filter:drop-shadow(0 10px 20px rgba(0,0,0,.25))">

      <h1 style="color:#fff;font-size:24px;font-weight:900;margin:0 0 8px">{{ $hubSettings->title ?? 'مجمع بالديرما الطبي' }}</h1>
      @if(!empty($hubSettings->tagline))
      <p style="color:rgba(255,255,255,.8);font-size:14.5px;font-weight:300;line-height:1.7;margin:0 0 36px">{{ $hubSettings->tagline }}</p>
      @else
      <div style="margin-bottom:36px"></div>
      @endif

      <div style="display:flex;flex-direction:column;gap:16px">
        @foreach($items as $item)
        <a href="{{ $item->url }}" target="_blank" rel="noopener" class="card-hover-lift" style="display:flex;align-items:center;justify-content:center;gap:10px;background:#fff;color:#4d1022;padding:17px 24px;border-radius:100px;font-weight:700;font-size:16px;box-shadow:0 10px 25px -8px rgba(0,0,0,.3)">
          <span class="material-symbols-outlined" style="font-size:22px;color:#6c1830">{{ $item->icon }}</span>
          {{ $item->label }}
        </a>
        @endforeach
      </div>

      @if($socialLinks->isNotEmpty())
      <div style="display:flex;justify-content:center;gap:14px;margin-top:36px">
        @foreach($socialLinks as $social)
        <a href="{{ $social->url }}" target="_blank" rel="noopener" aria-label="{{ $social->platform }}" style="width:46px;height:46px;border-radius:50%;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.25);color:#fff;display:flex;align-items:center;justify-content:center">
          <x-social-icon :platform="$social->platform" />
        </a>
        @endforeach
      </div>
      @endif

      <p style="color:rgba(255,255,255,.5);font-size:12.5px;font-weight:300;margin-top:44px">{{ $settings->copyright ?? 'جميع الحقوق محفوظة © مجمع بالديرما الطبي 2026' }}</p>
    </div>
  </div>

</x-app-layout>
