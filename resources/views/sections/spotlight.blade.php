<!-- ===== DOCTOR SPOTLIGHT ===== -->
@if($spotlight)
<section class="reveal" style="max-width:1240px;margin:24px auto;padding:0 26px">
  <div style="background:linear-gradient(135deg,#4d1022 0%,#6c1830 100%);border-radius:36px;overflow:hidden;color:#fff;display:grid;grid-template-columns:1fr 1.1fr;box-shadow:0 30px 60px -20px rgba(108,24,48,.5)" data-col="spot">
    <div data-spot-img style="position:relative;min-height:440px">
      <img src="{{ asset($spotlight->image) }}" alt="{{ $spotlight->name }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center top;display:block">
      <div style="position:absolute;inset:0;background:linear-gradient(90deg,transparent 60%,rgba(77,16,34,.6) 100%)"></div>
    </div>
    <div style="padding:60px 48px;display:flex;flex-direction:column;justify-content:center">
      <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.2);color:#f7c8d6;padding:6px 16px;border-radius:100px;font-size:13.5px;font-weight:500;margin-bottom:20px;align-self:flex-start">
        <span class="material-symbols-outlined" style="font-size:18px">star</span> {{ $spotlight->eyebrow ?? 'طبيب الشهر المميز' }}
      </div>
      <h2 style="font-size:clamp(26px,3.2vw,38px);font-weight:900;margin:0 0 10px;line-height:1.25">{{ $spotlight->name }}</h2>
      <div style="color:#f7c8d6;font-size:17px;font-weight:500;margin-bottom:20px">{{ $spotlight->specialty }}</div>
      <div style="font-size:14px;font-weight:700;color:#f7c8d6;margin-bottom:10px">نبذه عن الدكتور</div>
      <p style="font-size:16px;line-height:1.8;font-weight:300;color:rgba(255,255,255,.88);margin:0 0 28px">{{ $spotlight->bio }}</p>

      @if(!empty($spotlight->stats))
      <div style="display:flex;gap:28px;margin-bottom:32px;padding-bottom:28px;border-bottom:1px solid rgba(255,255,255,.15)">
        @foreach($spotlight->stats as $st)
        <div>
          <div style="font-size:24px;font-weight:900;color:#fff">{{ $st['val'] }}</div>
          <div style="font-size:13px;color:rgba(255,255,255,.7);font-weight:300">{{ $st['lbl'] }}</div>
        </div>
        @endforeach
      </div>
      @endif

      @if(!empty($spotlight->qualifications))
      <div style="margin-bottom:32px">
        <div style="font-size:14px;font-weight:700;color:#f7c8d6;margin-bottom:12px">أبرز المؤهلات والاعتمادات:</div>
        <ul style="margin:0;padding:0;list-style:none">
          @foreach($spotlight->qualifications as $qual)
          <li style="font-size:14.5px;color:rgba(255,255,255,.9);font-weight:300;margin-bottom:6px;display:flex;align-items:center;gap:8px">
            <span class="material-symbols-outlined" style="font-size:16px;color:#f7c8d6">check_circle</span> {{ $qual }}
          </li>
          @endforeach
        </ul>
      </div>
      @endif

      <div>
        <a href="{{ $spotlight->cta_href ?? '#book' }}" class="btn-hover-light-pink" style="display:inline-block;background:#fff;color:#6c1830;padding:14px 32px;border-radius:100px;font-weight:700;font-size:16px">{{ $spotlight->cta_label ?? 'احجز استشارة مع الدكتور' }}</a>
      </div>
    </div>
  </div>
</section>
@endif
