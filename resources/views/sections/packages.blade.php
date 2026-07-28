<!-- ===== PACKAGES ===== -->
<section id="packages" class="reveal" style="max-width:1240px;margin:0 auto;padding:70px 26px">
  <div style="text-align:center;max-width:680px;margin:0 auto 60px">
    <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'العروض والباقات' }}</div>
    <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">{{ $sectionInfo->title ?? 'باقات مميزة مصممة لتلبية احتياجاتك بأسعار تنافسية' }}</h2>
    <p style="font-size:17.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $sectionInfo->description ?? 'اختر الباقة المناسبة واستمتع بعناية فائقة وتوفير حقيقي.' }}</p>
  </div>

  <div data-grid="pkgs" style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;align-items:stretch">
    @foreach($packages as $pkg)
    <div class="card-hover-lift" style="background:{{ $pkg->is_featured ? 'linear-gradient(180deg,#ffffff 0%,#faf0f3 100%)' : '#ffffff' }};border-radius:28px;padding:36px 28px;border:{{ $pkg->is_featured ? '2px solid #6c1830' : '1px solid rgba(108,24,48,.1)' }};box-shadow:{{ $pkg->is_featured ? '0 20px 40px -15px rgba(108,24,48,.25)' : '0 12px 30px -10px rgba(108,24,48,.06)' }};position:relative;display:flex;flex-direction:column;justify-content:space-between;transform:{{ $pkg->is_featured ? 'scale(1.03)' : 'none' }}">
      
      @if($pkg->is_featured && !empty($pkg->featured_badge))
      <div style="position:absolute;top:-16px;left:50%;transform:translateX(-50%);background:#6c1830;color:#fff;padding:6px 20px;border-radius:100px;font-size:13px;font-weight:700;box-shadow:0 6px 16px rgba(108,24,48,.3)">
        {{ $pkg->featured_badge }}
      </div>
      @endif

      <div>
        <h3 style="font-size:22px;font-weight:900;margin:0 0 8px;color:#2a1620">{{ $pkg->name }}</h3>
        @if(!empty($pkg->tagline))
        <div style="font-size:14px;color:#7a6670;font-weight:300;margin-bottom:22px">{{ $pkg->tagline }}</div>
        @endif

        <div style="display:flex;align-items:baseline;gap:6px;margin-bottom:28px;padding-bottom:24px;border-bottom:1px solid rgba(108,24,48,.08)">
          <span style="font-size:42px;font-weight:900;color:#6c1830">{{ number_format($pkg->price, 0) }}</span>
          <span style="font-size:16px;color:#7a6670;font-weight:500">{{ $pkg->currency }}</span>
        </div>

        @if(!empty($pkg->features))
        <ul style="margin:0 0 32px;padding:0;list-style:none">
          @foreach($pkg->features as $feat)
          <li style="font-size:15px;line-height:1.7;font-weight:{{ $feat['is_included'] ? '400' : '300' }};color:{{ $feat['is_included'] ? '#2a1620' : '#b0a0a8' }};margin-bottom:12px;display:flex;align-items:center;gap:10px;{{ !$feat['is_included'] ? 'text-decoration:line-through' : '' }}">
            <span class="material-symbols-outlined" style="font-size:20px;color:{{ $feat['is_included'] ? '#6c1830' : '#ccc' }}">
              {{ $feat['is_included'] ? 'check_circle' : 'cancel' }}
            </span>
            {{ $feat['text'] }}
          </li>
          @endforeach
        </ul>
        @endif
      </div>

      <div>
        <a href="{{ $pkg->cta_href ?? '#book' }}" class="{{ $pkg->is_featured ? 'btn-hover-burgundy' : 'btn-hover-light-pink' }}" style="display:block;text-align:center;width:100%;background:{{ $pkg->is_featured ? '#6c1830' : '#faf0f3' }};color:{{ $pkg->is_featured ? '#fff' : '#6c1830' }};padding:14px;border-radius:100px;font-weight:700;font-size:16px;border:{{ $pkg->is_featured ? 'none' : '1px solid rgba(108,24,48,.15)' }}">
          {{ $pkg->cta_label ?? 'احجز هذه الباقة' }}
        </a>
      </div>
    </div>
    @endforeach
  </div>
</section>
