<!-- ===== BEFORE / AFTER RESULTS ===== -->
@if($beforeAfterResults->isNotEmpty())
<section id="results" class="reveal" style="max-width:1240px;margin:0 auto;padding:70px 0">
  <div style="text-align:center;max-width:680px;margin:0 auto 44px;padding:0 26px">
    <h2 style="font-size:clamp(26px,3.2vw,38px);font-weight:900;line-height:1.2;margin:0 0 12px;color:#2a1620">{{ $sectionInfo->title ?? 'نتائج بالديرما تتكلم عن نفسها، شوف بنفسك' }}</h2>
    <p style="font-size:16px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $sectionInfo->description ?? 'كل هذه النتائج تحت يديك مع أفضل الأطباء والمتخصصين بالمملكة' }}</p>
  </div>

  <div data-carousel-wrap style="position:relative;padding:0 60px">
    <button type="button" data-compare-prev aria-label="السابق" style="position:absolute;top:50%;right:8px;transform:translateY(-50%);z-index:5;width:44px;height:44px;border-radius:50%;background:#fff;border:1px solid rgba(108,24,48,.15);box-shadow:0 8px 20px -6px rgba(108,24,48,.3);cursor:pointer;display:flex;align-items:center;justify-content:center">
      <span class="material-symbols-outlined" style="font-size:22px;color:#6c1830">chevron_right</span>
    </button>
    <button type="button" data-compare-next aria-label="التالي" style="position:absolute;top:50%;left:8px;transform:translateY(-50%);z-index:5;width:44px;height:44px;border-radius:50%;background:#fff;border:1px solid rgba(108,24,48,.15);box-shadow:0 8px 20px -6px rgba(108,24,48,.3);cursor:pointer;display:flex;align-items:center;justify-content:center">
      <span class="material-symbols-outlined" style="font-size:22px;color:#6c1830">chevron_left</span>
    </button>

    <div data-compare-track style="display:flex;gap:20px;overflow-x:auto;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;scrollbar-width:none;padding:4px 26px">
      @foreach($beforeAfterResults as $result)
      <div data-compare-card style="position:relative;flex:0 0 320px;aspect-ratio:4/5;border-radius:24px;overflow:hidden;scroll-snap-align:start;box-shadow:0 20px 40px -15px rgba(108,24,48,.35);cursor:ew-resize;user-select:none">
        <img src="{{ asset($result->before_image) }}" alt="قبل" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;pointer-events:none">
        <img data-compare-after src="{{ asset($result->after_image) }}" alt="بعد" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;clip-path:inset(0 0 0 50%);pointer-events:none">
        <div style="position:absolute;top:14px;left:14px;z-index:3;background:rgba(42,22,32,.72);color:#fff;font-size:12px;font-weight:700;padding:5px 16px;border-radius:100px;backdrop-filter:blur(4px);pointer-events:none">قبل</div>
        <div style="position:absolute;top:14px;right:14px;z-index:3;background:rgba(150,18,60,.85);color:#fff;font-size:12px;font-weight:700;padding:5px 16px;border-radius:100px;backdrop-filter:blur(4px);pointer-events:none">بعد</div>
        <div data-compare-handle style="position:absolute;top:0;bottom:0;left:50%;width:0;transform:translateX(-50%)">
          <div style="position:absolute;top:0;bottom:0;right:0;width:3px;background:#fff;box-shadow:0 0 8px rgba(0,0,0,.3)"></div>
          <div style="position:absolute;top:50%;right:50%;transform:translate(50%,-50%);width:40px;height:40px;border-radius:50%;background:#fff;box-shadow:0 4px 14px rgba(0,0,0,.25);display:flex;align-items:center;justify-content:center">
            <span class="material-symbols-outlined" style="font-size:20px;color:#6c1830">code</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div data-compare-dots style="display:flex;justify-content:center;gap:8px;margin-top:24px">
      @foreach($beforeAfterResults as $result)
      <span style="height:8px;width:8px;border-radius:100px;background:rgba(108,24,48,.25);transition:all .3s ease;cursor:pointer"></span>
      @endforeach
    </div>
  </div>

  <div style="text-align:center;margin-top:36px">
    <a href="#book" style="display:inline-flex;align-items:center;gap:10px;background:#25D366;color:#fff;padding:16px 34px;border-radius:100px;font-weight:700;font-size:16px;box-shadow:0 14px 30px -10px rgba(37,211,102,.5)">
      <span class="material-symbols-outlined" style="font-size:20px">calendar_month</span>
      احجزي موعدك الآن
    </a>
  </div>
</section>
@endif
