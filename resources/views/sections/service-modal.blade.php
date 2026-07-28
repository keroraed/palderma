@php $serviceModalWhatsapp = $socialLinks->firstWhere('platform', 'whatsapp'); @endphp
<!-- ===== SERVICE DETAIL MODAL ===== -->
<div data-service-modal data-whatsapp-base="{{ $serviceModalWhatsapp->url ?? '' }}" style="display:none;position:fixed;inset:0;z-index:200;background:rgba(42,22,32,.75);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);align-items:center;justify-content:center;padding:24px" role="dialog" aria-modal="true">
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

    <a data-service-modal-whatsapp target="_blank" rel="noopener" style="display:flex;align-items:center;justify-content:center;gap:10px;background:#25D366;color:#fff;padding:15px;border-radius:100px;font-weight:700;font-size:15.5px;box-shadow:0 14px 30px -10px rgba(37,211,102,.5)">
      <span style="width:20px;height:20px;display:flex;align-items:center;justify-content:center"><svg style="width:18px;height:18px;fill:currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></span>
      <span data-service-modal-whatsapp-label>تواصل معنا عبر واتساب</span>
    </a>
  </div>
</div>

<!-- Services JSON payload for Modal JS -->
<script id="services-json" type="application/json">
{!! json_encode($services->toArray(), JSON_UNESCAPED_UNICODE) !!}
</script>
