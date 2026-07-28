<x-app-layout :settings="$settings">

  @include('sections.header')

  <div dir="rtl" style="width:100%;overflow-x:hidden">

    <section style="max-width:820px;margin:0 auto;padding:70px 26px 90px">
      <div style="margin-bottom:32px">
        <a href="/" style="color:#96123c;font-weight:700;font-size:14.5px;display:inline-flex;align-items:center;gap:6px">
          <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
          العودة للصفحة الرئيسية
        </a>
      </div>

      <h1 style="font-size:clamp(26px,3.2vw,38px);font-weight:900;line-height:1.2;margin:0 0 32px;color:#2a1620">{{ $page->title }}</h1>

      <div style="font-size:15.5px;line-height:1.9;font-weight:300;color:#4a3640" class="legal-content">
        {!! $page->content !!}
      </div>
    </section>

  </div>

  @include('sections.footer')

</x-app-layout>
