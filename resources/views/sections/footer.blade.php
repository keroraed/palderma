<!-- ===== FOOTER ===== -->
@php
  $footerHrefFor = fn(string $href) => (str_starts_with($href, '#') && !request()->routeIs('landing')) ? '/' . $href : $href;
@endphp
<footer style="background:#4d1022;color:#fff;padding:64px 26px 36px;border-top:1px solid rgba(255,255,255,.08)">
  <div style="max-width:1240px;margin:0 auto">
    <div data-grid="footer" style="display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:48px;margin-bottom:60px">
      <div>
        <a href="{{ $footerHrefFor('#top') }}" style="display:inline-block;margin-bottom:20px">
          <img src="{{ asset($settings->logo_white ?? 'images/branding/logo-white.svg') }}" alt="بالديرما" style="height:74px;display:block">
        </a>
        <p style="font-size:15px;line-height:1.85;font-weight:300;color:rgba(255,255,255,.75);margin:0 0 24px;max-width:360px">
          مجمع بالديرما الطبي — وجهتك الأولى الموثوقة للعناية بصحة البشرة والجلدية والتجميل بأعلى المعايير الطبية المعتمدة.
        </p>
        <div style="display:flex;gap:12px">
          @foreach($socialLinks as $social)
          <a href="{{ $social->url }}" target="_blank" rel="noopener" aria-label="{{ $social->platform }}" class="social-icon-hover" style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.1);color:#fff;display:flex;align-items:center;justify-content:center">
            <x-social-icon :platform="$social->platform" />
          </a>
          @endforeach
        </div>
      </div>

      <div>
        <h4 style="font-size:17px;font-weight:700;margin:0 0 20px;color:#fff">روابط سريعة</h4>
        <ul style="margin:0;padding:0;list-style:none">
          @foreach($navLinks->where('show_in_footer', true) as $link)
          <li style="margin-bottom:12px">
            <a href="{{ $footerHrefFor($link->href) }}" style="color:rgba(255,255,255,.8);font-size:14.5px;font-weight:300">{{ $link->label }}</a>
          </li>
          @endforeach
        </ul>
      </div>

      <div>
        <h4 style="font-size:17px;font-weight:700;margin:0 0 20px;color:#fff">معلومات التواصل</h4>
        <ul style="margin:0;padding:0;list-style:none;font-size:14.5px;color:rgba(255,255,255,.8);font-weight:300">
          <li style="margin-bottom:12px;display:flex;align-items:center;gap:10px">
            <span class="material-symbols-outlined" style="font-size:18px;color:#f7c8d6">call</span>
            <span style="direction:ltr">{{ $settings->phone ?? '+966 9200 00000' }}</span>
          </li>
          <li style="margin-bottom:12px;display:flex;align-items:center;gap:10px">
            <span class="material-symbols-outlined" style="font-size:18px;color:#f7c8d6">mail</span>
            <span>{{ $settings->email ?? 'info@palderma.sa' }}</span>
          </li>
          <li style="margin-bottom:12px;display:flex;align-items:center;gap:10px">
            <span class="material-symbols-outlined" style="font-size:18px;color:#f7c8d6">location_on</span>
            <span>{{ $settings->address ?? 'الرياض، طريق الملك فهد' }}</span>
          </li>
        </ul>
      </div>

      <div>
        <h4 style="font-size:17px;font-weight:700;margin:0 0 20px;color:#fff">أوقات العمل</h4>
        <p style="font-size:14.5px;line-height:1.8;color:rgba(255,255,255,.8);font-weight:300;margin:0 0 16px">
          {{ $settings->working_hours ?? 'السبت - الخميس: 10:00 ص - 10:00 م' }}
        </p>
        <div style="background:rgba(255,255,255,.08);padding:14px 18px;border-radius:16px;font-size:13.5px;color:#f7c8d6;font-weight:500;display:flex;align-items:center;gap:10px">
          <span class="material-symbols-outlined" style="font-size:20px">verified</span> مركز معتمد ترخيص وزارة الصحة
        </div>
      </div>
    </div>

    <div style="padding-top:28px;border-top:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;font-size:13.5px;color:rgba(255,255,255,.6);font-weight:300">
      <div>{{ $settings->copyright ?? 'جميع الحقوق محفوظة © مجمع بالديرما الطبي 2026' }}</div>
      <div style="display:flex;gap:20px">
        <a href="{{ route('legal.privacy') }}" style="color:rgba(255,255,255,.6)">سياسة الخصوصية</a>
        <a href="{{ route('legal.terms') }}" style="color:rgba(255,255,255,.6)">الشروط والأحكام</a>
      </div>
    </div>
  </div>
</footer>
