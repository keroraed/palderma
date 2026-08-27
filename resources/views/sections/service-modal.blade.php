<!-- ===== SERVICE DETAIL MODAL ===== -->
<div data-service-modal style="display:none;position:fixed;inset:0;z-index:200;background:rgba(42,22,32,.75);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);align-items:center;justify-content:center;padding:24px" role="dialog" aria-modal="true">
  <div style="background:#fff;border-radius:32px;max-width:620px;width:100%;max-height:88vh;overflow-y:auto;box-shadow:0 30px 80px -20px rgba(0,0,0,.4);position:relative;padding:44px 40px 36px">

    <button data-service-modal-close aria-label="إغلاق" style="position:absolute;top:20px;left:20px;z-index:10;width:40px;height:40px;border-radius:50%;background:#faf0f3;border:none;color:#6c1830;font-size:22px;cursor:pointer;display:flex;align-items:center;justify-content:center">✕</button>

    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;padding-left:48px">
      <div data-service-modal-icon-wrap style="width:56px;height:56px;border-radius:16px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;flex-shrink:0"></div>
      <h2 data-service-modal-title style="font-size:24px;font-weight:900;color:#2a1620;margin:0;line-height:1.3"></h2>
    </div>

    <p data-service-modal-details style="font-size:15.5px;line-height:1.85;font-weight:300;color:#5a4650;margin:0 0 22px"></p>

    <div data-service-modal-features-wrap style="margin-bottom:22px">
      <div style="font-size:15px;font-weight:700;color:#6c1830;margin-bottom:12px">يشمل هذا العلاج:</div>
      <ul data-service-modal-features style="margin:0;padding:0;list-style:none;font-size:14.5px;color:#4a3640;font-weight:300"></ul>
    </div>

    <p data-service-modal-note style="font-size:14.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0 0 26px"></p>

    <a id="btn-whatsapp-service" href="/#book" data-book-service data-service-modal-whatsapp class="btn-hover-burgundy" style="display:flex;align-items:center;justify-content:center;gap:10px;background:#6c1830;color:#fff;padding:15px;border-radius:100px;font-weight:700;font-size:15.5px;box-shadow:0 14px 30px -10px rgba(108,24,48,.5)">
      <span class="material-symbols-outlined" style="font-size:20px">calendar_month</span>
      <span data-service-modal-whatsapp-label>احجزي موعدك الآن</span>
    </a>

    <div style="margin-top:22px;padding-top:20px;border-top:1px solid rgba(108,24,48,.1)">
      <x-share-buttons data-service-modal-share label="شارك هذه الخدمة" :compact="true" />
    </div>
  </div>
</div>

<!-- Services JSON payload for Modal JS -->
<script id="services-json" type="application/json">
{!! json_encode($services->toArray(), JSON_UNESCAPED_UNICODE) !!}
</script>
