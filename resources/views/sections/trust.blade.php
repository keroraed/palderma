<!-- ===== TRUST & TESTIMONIALS ===== -->
<section id="trust" class="reveal" style="max-width:1240px;margin:0 auto;padding:70px 26px">
  <div style="text-align:center;max-width:680px;margin:0 auto 60px">
    <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'اعتماداتنا وآراء مراجعينا' }}</div>
    <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">{{ $sectionInfo->title ?? 'ثقتكم هي رصيدنا وأساس تميزنا' }}</h2>
    <p style="font-size:17.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $sectionInfo->description ?? 'نلتزم بأعلى معايير الجودة والسلامة المعتمدة محلياً ودولياً.' }}</p>
  </div>

  <!-- Certifications Carousel -->
  @if($certifications->isNotEmpty())
  <div data-carousel-wrap style="position:relative;padding:0 56px;margin-bottom:64px">
    <button type="button" data-certs-prev aria-label="السابق" style="position:absolute;top:50%;right:0;transform:translateY(-50%);z-index:5;width:44px;height:44px;border-radius:50%;background:#fff;border:1px solid rgba(108,24,48,.15);box-shadow:0 8px 20px -6px rgba(108,24,48,.3);cursor:pointer;display:flex;align-items:center;justify-content:center">
      <span class="material-symbols-outlined" style="font-size:22px;color:#6c1830">chevron_right</span>
    </button>
    <button type="button" data-certs-next aria-label="التالي" style="position:absolute;top:50%;left:0;transform:translateY(-50%);z-index:5;width:44px;height:44px;border-radius:50%;background:#fff;border:1px solid rgba(108,24,48,.15);box-shadow:0 8px 20px -6px rgba(108,24,48,.3);cursor:pointer;display:flex;align-items:center;justify-content:center">
      <span class="material-symbols-outlined" style="font-size:22px;color:#6c1830">chevron_left</span>
    </button>

    <div data-certs-track style="display:flex;gap:20px;overflow-x:auto;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;scrollbar-width:none;padding:4px 4px 8px">
      @foreach($certifications as $cert)
      <div data-certs-card class="card-hover-lift" style="flex:0 0 260px;scroll-snap-align:start;background:#fff;border-radius:24px;padding:20px;border:1px solid rgba(108,24,48,.1);box-shadow:0 10px 25px -10px rgba(108,24,48,.06);text-align:center">
        @if($cert->image)
        <div style="width:100%;aspect-ratio:4/3;border-radius:16px;overflow:hidden;margin-bottom:16px;background:#faf6f4;border:1px solid rgba(108,24,48,.08)">
          <img src="{{ asset($cert->image) }}" alt="{{ $cert->title }}" loading="lazy" style="width:100%;height:100%;object-fit:contain;display:block">
        </div>
        @else
        <div style="width:52px;height:52px;border-radius:50%;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
          <span class="material-symbols-outlined" style="font-size:28px">{{ $cert->icon }}</span>
        </div>
        @endif
        <h3 style="font-size:15px;font-weight:700;margin:0 0 6px;color:#2a1620;line-height:1.4">{{ $cert->title }}</h3>
        @if(!empty($cert->subtitle))
        <p style="font-size:12.5px;line-height:1.6;font-weight:300;color:#6a5660;margin:0">{{ $cert->subtitle }}</p>
        @endif
      </div>
      @endforeach
    </div>

    <div data-certs-dots style="display:flex;justify-content:center;gap:8px;margin-top:20px">
      @foreach($certifications as $cert)
      <span style="height:8px;width:8px;border-radius:100px;background:rgba(108,24,48,.25);transition:all .3s ease;cursor:pointer"></span>
      @endforeach
    </div>
  </div>
  @endif

  <!-- Testimonials Carousel -->
  <div data-tests-wrap style="background:#faf0f3;border-radius:36px;padding:48px 0 44px">
    <div style="text-align:center;margin-bottom:36px;padding:0 36px">
      <h3 style="font-size:24px;font-weight:900;color:#6c1830;margin:0 0 8px">ماذا يقول مراجعونا عن بالديرما؟</h3>
      <p style="font-size:15px;color:#7a6670;font-weight:300;margin:0">تجارب حقيقية لمراجعين استعادوا نضارة بشرتهم وثقتهم بأنفسهم</p>
    </div>

    <div data-carousel-wrap style="position:relative;padding:0 56px">
      <button type="button" data-tests-prev aria-label="السابق" style="position:absolute;top:50%;right:8px;transform:translateY(-50%);z-index:5;width:44px;height:44px;border-radius:50%;background:#fff;border:1px solid rgba(108,24,48,.15);box-shadow:0 8px 20px -6px rgba(108,24,48,.3);cursor:pointer;display:flex;align-items:center;justify-content:center">
        <span class="material-symbols-outlined" style="font-size:22px;color:#6c1830">chevron_right</span>
      </button>
      <button type="button" data-tests-next aria-label="التالي" style="position:absolute;top:50%;left:8px;transform:translateY(-50%);z-index:5;width:44px;height:44px;border-radius:50%;background:#fff;border:1px solid rgba(108,24,48,.15);box-shadow:0 8px 20px -6px rgba(108,24,48,.3);cursor:pointer;display:flex;align-items:center;justify-content:center">
        <span class="material-symbols-outlined" style="font-size:22px;color:#6c1830">chevron_left</span>
      </button>

      <div data-tests-track style="display:flex;gap:24px;overflow-x:auto;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;scrollbar-width:none;padding:4px 26px 8px">
        @foreach($testimonials as $test)
        <div data-tests-card style="flex:0 0 340px;scroll-snap-align:start;background:#fff;border-radius:24px;padding:28px 24px;border:1px solid rgba(108,24,48,.08);box-shadow:0 10px 25px -10px rgba(108,24,48,.05);display:flex;flex-direction:column;justify-content:space-between">
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

      <div data-tests-dots style="display:flex;justify-content:center;gap:8px;margin-top:16px">
        @foreach($testimonials as $test)
        <span style="height:8px;width:8px;border-radius:100px;background:rgba(108,24,48,.25);transition:all .3s ease;cursor:pointer"></span>
        @endforeach
      </div>
    </div>
  </div>
</section>
