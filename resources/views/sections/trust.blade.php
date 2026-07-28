<!-- ===== TRUST & TESTIMONIALS ===== -->
<section id="trust" class="reveal" style="max-width:1240px;margin:0 auto;padding:70px 26px">
  <div style="text-align:center;max-width:680px;margin:0 auto 60px">
    <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'اعتماداتنا وآراء مراجعينا' }}</div>
    <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">{{ $sectionInfo->title ?? 'ثقتكم هي رصيدنا وأساس تميزنا' }}</h2>
    <p style="font-size:17.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $sectionInfo->description ?? 'نلتزم بأعلى معايير الجودة والسلامة المعتمدة محلياً ودولياً.' }}</p>
  </div>

  <!-- Certifications Grid -->
  <div data-grid="certs" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;margin-bottom:64px">
    @foreach($certifications as $cert)
    <div class="card-hover-lift" style="background:#fff;border-radius:24px;padding:28px 22px;border:1px solid rgba(108,24,48,.1);box-shadow:0 10px 25px -10px rgba(108,24,48,.06);text-align:center">
      <div style="width:52px;height:52px;border-radius:50%;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
        <span class="material-symbols-outlined" style="font-size:28px">{{ $cert->icon }}</span>
      </div>
      <h3 style="font-size:16.5px;font-weight:700;margin:0 0 8px;color:#2a1620;line-height:1.4">{{ $cert->title }}</h3>
      @if(!empty($cert->subtitle))
      <p style="font-size:13.5px;line-height:1.6;font-weight:300;color:#6a5660;margin:0">{{ $cert->subtitle }}</p>
      @endif
    </div>
    @endforeach
  </div>

  <!-- Testimonials Grid -->
  <div data-tests-wrap style="background:#faf0f3;border-radius:36px;padding:48px 36px;border:1px solid rgba(108,24,48,.08)">
    <div style="text-align:center;margin-bottom:36px">
      <h3 style="font-size:24px;font-weight:900;color:#6c1830;margin:0 0 8px">ماذا يقول مراجعونا عن بالديرما؟</h3>
      <p style="font-size:15px;color:#7a6670;font-weight:300;margin:0">تجارب حقيقية لمراجعين استعادوا نضارة بشرتهم وثقتهم بأنفسهم</p>
    </div>

    <div data-grid="tests" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
      @foreach($testimonials as $test)
      <div style="background:#fff;border-radius:24px;padding:28px 24px;border:1px solid rgba(108,24,48,.08);box-shadow:0 10px 25px -10px rgba(108,24,48,.05);display:flex;flex-direction:column;justify-content:space-between">
        <div>
          <div style="display:flex;gap:4px;color:#f59e0b;margin-bottom:14px">
            @for($r = 0; $r < $test->rating; $r++)
            <span class="material-symbols-outlined" style="font-size:20px;font-variation-settings:'FILL' 1">star</span>
            @endfor
          </div>
          <p style="font-size:15px;line-height:1.8;font-weight:300;color:#4a3640;margin:0 0 20px;font-style:italic">"{{ $test->quote }}"</p>
        </div>
        <div style="display:flex;align-items:center;gap:12px;padding-top:16px;border-top:1px solid rgba(108,24,48,.06)">
          <div style="width:40px;height:40px;border-radius:50%;background:#6c1830;color:#fff;font-weight:700;font-size:16px;display:flex;align-items:center;justify-content:center">
            {{ $test->avatar_initial ?? mb_substr($test->name, 0, 1) }}
          </div>
          <div>
            <div style="font-weight:700;font-size:15px;color:#2a1620">{{ $test->name }}</div>
            <div style="font-size:12.5px;color:#96123c;font-weight:500">{{ $test->service_label }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
