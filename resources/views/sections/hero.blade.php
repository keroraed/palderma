<!-- ===== HERO SLIDER ===== -->
<section id="top" style="position:relative;height:min(88vh,760px);min-height:560px;overflow:hidden;background:#4d1022;border-radius:0 0 36px 36px">
  @foreach($heroSlides as $index => $slide)
  <div data-hero-slide style="position:absolute;inset:0;display: {{ $index === 0 ? 'block' : 'none' }}; opacity: {{ $index === 0 ? '1' : '0' }}; transition: opacity 0.8s ease; z-index: {{ $index === 0 ? 2 : 1 }}">
    <div style="position:absolute;inset:0">
      {{-- Slide 1 is the LCP image: load it eagerly with high priority. Later
           slides are off-screen until the carousel advances, so defer them. --}}
      <img data-hero-desktop src="{{ asset($slide->image_desktop) }}" alt="{{ $slide->image_alt ?? $slide->title }}"
           @if($index === 0) fetchpriority="high" decoding="async" @else loading="lazy" decoding="async" @endif
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block">
      <img data-hero-mobile src="{{ asset($slide->image_mobile) }}" alt="{{ $slide->image_alt ?? $slide->title }}"
           @if($index === 0) fetchpriority="high" decoding="async" @else loading="lazy" decoding="async" @endif
           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:none">
    </div>
    <div data-hero-grad style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(77,16,34,.9) 0%,rgba(77,16,34,.62) 48%,rgba(108,24,48,.28) 100%);pointer-events:none"></div>

    <!-- slide content -->
    <div data-hero-content style="position:relative;z-index:5;height:100%;max-width:1240px;margin:0 auto;padding:0 26px;display:flex;flex-direction:column;justify-content:center;pointer-events:none">
      <div style="max-width:620px;pointer-events:auto">
        @if(!empty($slide->tag))
        <div style="display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.25);color:#fff;padding:8px 16px;border-radius:100px;font-size:14px;font-weight:500;margin-bottom:22px">
          <span style="width:7px;height:7px;border-radius:50%;background:#f7c8d6"></span>{{ $slide->tag }}
        </div>
        @endif
        {{-- Only the first slide carries the page's single <h1>; the rest use a
             visually identical div so the page never ships multiple H1 tags (SEO). --}}
        @if($index === 0)
        <h1 style="color:#fff;font-weight:900;font-size:clamp(34px,5.6vw,62px);line-height:1.12;margin:0 0 18px">{{ $slide->title }}</h1>
        @else
        <div style="color:#fff;font-weight:900;font-size:clamp(34px,5.6vw,62px);line-height:1.12;margin:0 0 18px">{{ $slide->title }}</div>
        @endif
        <p style="color:rgba(255,255,255,.9);font-size:clamp(16px,2vw,21px);font-weight:300;line-height:1.7;margin:0 0 34px;max-width:520px">{{ $slide->subtitle }}</p>
        <div style="display:flex;gap:14px;flex-wrap:wrap">
          <a href="#book" class="btn-hover-light-pink" style="background:#fff;color:#6c1830;padding:15px 34px;border-radius:100px;font-weight:700;font-size:17px">احجز موعدك الآن</a>
          <a href="#services" class="btn-hover-white-overlay" style="border:1.5px solid rgba(255,255,255,.55);color:#fff;padding:15px 30px;border-radius:100px;font-weight:500;font-size:17px">تعرّف على خدماتنا</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <!-- arrows -->
  <button data-hero-prev aria-label="السابق" class="btn-hover-white-glass" style="position:absolute;z-index:8;top:50%;left:24px;transform:translateY(-50%);width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.3);color:#fff;font-size:22px;cursor:pointer;backdrop-filter:blur(6px)">›</button>
  <button data-hero-next aria-label="التالي" class="btn-hover-white-glass" style="position:absolute;z-index:8;top:50%;right:24px;transform:translateY(-50%);width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.3);color:#fff;font-size:22px;cursor:pointer;backdrop-filter:blur(6px)">‹</button>
  
  <!-- dots -->
  <div data-hero-dots style="position:absolute;z-index:8;bottom:26px;left:50%;transform:translateX(-50%);display:flex;gap:11px">
    @foreach($heroSlides as $index => $slide)
    <button data-hero-dot aria-label="{{ $index + 1 }}" style="cursor:pointer;border:0;height:10px;width:{{ $index === 0 ? '28px' : '10px' }};border-radius:{{ $index === 0 ? '100px' : '50%' }};background:{{ $index === 0 ? '#fff' : 'rgba(255,255,255,.4)' }};transition:all .3s ease"></button>
    @endforeach
  </div>
</section>
