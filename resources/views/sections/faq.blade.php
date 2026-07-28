<!-- ===== FAQ ===== -->
@if($faqs->isNotEmpty())
<section id="faq" class="reveal" style="max-width:900px;margin:0 auto;padding:70px 26px">
  <div style="text-align:center;max-width:680px;margin:0 auto 44px">
    <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'لديك سؤال؟' }}</div>
    <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0;color:#2a1620">{{ $sectionInfo->title ?? 'الأسئلة الشائعة' }}</h2>
  </div>

  <div style="display:flex;flex-direction:column;gap:14px">
    @foreach($faqs as $faq)
    <div data-faq-item style="background:#fff;border:1px solid rgba(108,24,48,.1);border-radius:20px;overflow:hidden">
      <button type="button" data-faq-toggle style="width:100%;background:none;border:0;cursor:pointer;padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:16px;text-align:right;font-family:inherit">
        <span style="font-size:16.5px;font-weight:700;color:#2a1620">{{ $faq->question }}</span>
        <span data-faq-icon class="material-symbols-outlined" style="font-size:24px;color:#6c1830;flex-shrink:0;transition:transform .3s ease">add</span>
      </button>
      <div data-faq-answer style="display:none;padding:0 26px 22px">
        <p style="margin:0;font-size:15px;line-height:1.85;font-weight:300;color:#5a4650">{{ $faq->answer }}</p>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endif
