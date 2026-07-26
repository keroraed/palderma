<!-- ===== ABOUT ===== -->
@if($about)
<section id="about" class="reveal" style="max-width:1240px;margin:0 auto;padding:100px 26px">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center" data-col="about">
    <div>
      <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'من نحن' }}</div>
      <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 22px;color:#2a1620">{{ $sectionInfo->title ?? 'عناية جلدية متكاملة تجمع بين الخبرة الطبية ولمسة التجميل' }}</h2>
      <p style="font-size:17.5px;line-height:1.9;font-weight:300;color:#5a4650;margin:0 0 18px">
        {{ $sectionInfo->description ?? 'تأسّس مركز بالديرما ليكون وجهةً موثوقة للعناية بصحة البشرة وجمالها في المملكة.' }}
      </p>
      @if(!empty($about->cards))
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:30px">
        @foreach($about->cards as $card)
        <div style="background:#fff;border:1px solid rgba(108,24,48,.1);border-radius:16px;padding:22px">
          <div style="font-weight:700;font-size:18px;color:#6c1830;margin-bottom:8px">{{ $card['title'] }}</div>
          <p style="margin:0;font-size:15px;line-height:1.75;font-weight:300;color:#5a4650">{{ $card['body'] }}</p>
        </div>
        @endforeach
      </div>
      @endif
    </div>
    <div style="position:relative">
      <div style="position:relative;border-radius:26px;overflow:hidden;aspect-ratio:4/5;box-shadow:0 30px 70px -30px rgba(108,24,48,.45)">
        <img src="{{ asset($about->image) }}" alt="عن بالديرما" style="width:100%;height:100%;object-fit:cover;display:block">
      </div>
      @if(!empty($about->badge_title))
      <div data-about-badge style="position:absolute;bottom:-24px;left:24px;background:#fff;border-radius:20px;padding:18px 24px;box-shadow:0 20px 40px -10px rgba(108,24,48,.25);border:1px solid rgba(108,24,48,.12);display:flex;align-items:center;gap:14px">
        <span class="material-symbols-outlined" style="font-size:36px;color:#6c1830">verified</span>
        <div>
          <div style="font-weight:700;font-size:16.5px;color:#2a1620">{{ $about->badge_title }}</div>
          <div style="font-size:13.5px;color:#7a6670;font-weight:300">{{ $about->badge_text }}</div>
        </div>
      </div>
      @endif
    </div>
  </div>
</section>
@endif
