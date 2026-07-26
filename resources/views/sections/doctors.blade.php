<!-- ===== DOCTORS ===== -->
<section id="doctors" class="reveal" style="max-width:1240px;margin:0 auto;padding:100px 26px">
  <div style="text-align:center;max-width:680px;margin:0 auto 60px">
    <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'فريقنا الطبي' }}</div>
    <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">{{ $sectionInfo->title ?? 'نخبة من الأطباء والاستشاريين المعتمدين' }}</h2>
    <p style="font-size:17.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $sectionInfo->description ?? 'كوادر طبية متميزة بحاصلين على أرفع الشهادات العالمية والخبرات الممتدة.' }}</p>
  </div>

  <div data-grid="doctors" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px">
    @foreach($doctors as $doctor)
    <div data-doctor-card data-doctor-id="{{ $doctor->id }}" class="card-hover-lift" style="background:#fff;border-radius:24px;overflow:hidden;border:1px solid rgba(108,24,48,.1);box-shadow:0 12px 30px -10px rgba(108,24,48,.08);cursor:pointer">
      <div style="position:relative;aspect-ratio:4/3;overflow:hidden;background:#f3e8eb">
        <img src="{{ asset($doctor->image) }}" alt="{{ $doctor->name }}" style="width:100%;height:100%;object-fit:cover;object-position:top;display:block">
        <div style="position:absolute;inset:0;background:linear-gradient(180deg,transparent 60%,rgba(42,22,32,.4) 100%)"></div>
      </div>
      <div style="padding:22px;text-align:center">
        <h3 style="margin:0 0 6px;font-size:19px;font-weight:700;color:#2a1620">{{ $doctor->name }}</h3>
        <div style="color:#96123c;font-weight:500;font-size:14px;margin-bottom:14px">{{ $doctor->specialty }}</div>
        <p style="font-size:14px;line-height:1.75;font-weight:300;color:#6a5660;margin:0 0 18px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:48px">{{ $doctor->bio }}</p>
        <button class="btn-hover-burgundy" style="width:100%;background:#faf0f3;color:#6c1830;border:1px solid rgba(108,24,48,.15);padding:10px;border-radius:100px;font-weight:700;font-size:14px;cursor:pointer">عرض التفاصيل والشهادات</button>
      </div>
    </div>
    @endforeach
  </div>
</section>
