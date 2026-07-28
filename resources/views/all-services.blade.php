<x-app-layout :settings="$settings">

  @include('sections.header')

  <div dir="rtl" style="width:100%;overflow-x:hidden">

    <section style="max-width:1240px;margin:0 auto;padding:70px 26px 20px">
      <div style="text-align:center;max-width:680px;margin:0 auto 50px">
        <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">جميع خدماتنا</div>
        <h1 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">كل خدمات مجمع بالديرما الطبي</h1>
        <p style="font-size:17.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">تصفّح القائمة الكاملة لخدماتنا العلاجية والتجميلية، واختاري ما يناسبكِ للحجز مباشرة.</p>
      </div>

      <div style="margin-bottom:32px">
        <a href="/" style="color:#96123c;font-weight:700;font-size:14.5px;display:inline-flex;align-items:center;gap:6px">
          <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
          العودة للصفحة الرئيسية
        </a>
      </div>

      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px" data-grid="services">
        @foreach($services as $service)
        <x-service-card :service="$service" />
        @endforeach
      </div>
    </section>

  </div>

  @include('sections.footer')

</x-app-layout>
