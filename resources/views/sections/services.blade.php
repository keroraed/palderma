<!-- ===== SERVICES ===== -->
<section id="services" class="reveal" style="max-width:1240px;margin:0 auto;padding:70px 26px">
  <div style="text-align:center;max-width:680px;margin:0 auto 60px">
    <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'خدماتنا المميزة' }}</div>
    <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">{{ $sectionInfo->title ?? 'حلول علاجية وتجميلية متكاملة لبشرة نضرة وقوام متناسق' }}</h2>
    <p style="font-size:17.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $sectionInfo->description ?? 'نستخدم أحدث التقنيات المعتمدة من هيئة الغذاء والدواء لضمان نتائج آمنة وملموسة.' }}</p>
  </div>

  <div data-grid="services" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px">
    @foreach($services as $service)
    <x-service-card :service="$service" />
    @endforeach
  </div>

  @if($totalServicesCount > 6)
  <div style="text-align:center;margin-top:48px">
    <a href="{{ route('services.all') }}" style="background:#faf0f3;color:#6c1830;border:1px solid rgba(108,24,48,.2);padding:14px 32px;border-radius:100px;font-weight:700;font-size:15.5px;display:inline-flex;align-items:center;gap:8px">
      عرض جميع خدمات المركز ({{ $totalServicesCount }} خدمة)
      <span class="material-symbols-outlined" style="font-size:20px">arrow_back</span>
    </a>
  </div>
  @endif
</section>
