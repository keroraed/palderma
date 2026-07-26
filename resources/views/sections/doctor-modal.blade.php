<!-- ===== DOCTOR MODAL ===== -->
<div data-doctor-modal style="display:none;position:fixed;inset:0;z-index:200;background:rgba(42,22,32,.75);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);align-items:center;justify-content:center;padding:24px" role="dialog" aria-modal="true">
  <div style="background:#fff;border-radius:32px;max-width:840px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 30px 80px -20px rgba(0,0,0,.4);position:relative;display:grid;grid-template-columns:1fr 1.2fr" data-col="modal">
    
    <button data-modal-close aria-label="إغلاق" style="position:absolute;top:20px;left:20px;z-index:10;width:40px;height:40px;border-radius:50%;background:#faf0f3;border:none;color:#6c1830;font-size:22px;cursor:pointer;display:flex;align-items:center;justify-content:center">✕</button>

    <div style="position:relative;background:#f3e8eb;min-height:360px">
      <img data-modal-img src="" alt="" style="width:100%;height:100%;object-fit:cover;object-position:top;display:block">
    </div>

    <div style="padding:40px 36px">
      <h2 data-modal-name style="font-size:26px;font-weight:900;color:#2a1620;margin:0 0 6px"></h2>
      <div data-modal-spec style="color:#96123c;font-weight:700;font-size:16px;margin-bottom:20px"></div>
      
      <p data-modal-bio style="font-size:15px;line-height:1.8;font-weight:300;color:#5a4650;margin:0 0 24px"></p>

      <div style="display:flex;gap:24px;margin-bottom:24px;padding:16px 20px;background:#faf0f3;border-radius:18px">
        <div>
          <div data-modal-exp style="font-size:20px;font-weight:900;color:#6c1830"></div>
          <div style="font-size:12px;color:#7a6670;font-weight:300">سنوات الخبرة</div>
        </div>
        <div style="border-right:1px solid rgba(108,24,48,.15);padding-right:24px">
          <div data-modal-pat style="font-size:20px;font-weight:900;color:#6c1830"></div>
          <div style="font-size:12px;color:#7a6670;font-weight:300">حالة ناجحة</div>
        </div>
      </div>

      <div>
        <div style="font-size:15px;font-weight:700;color:#2a1620;margin-bottom:12px">المؤهلات والشهادات العلمية:</div>
        <ul data-modal-quals style="margin:0 0 28px;padding:0;list-style:none;font-size:14px;color:#5a4650;font-weight:300"></ul>
      </div>

      <a href="#book" onclick="document.querySelector('[data-doctor-modal]').style.display='none';document.body.style.overflow=''" class="btn-hover-burgundy" style="display:block;text-align:center;background:#6c1830;color:#fff;padding:14px;border-radius:100px;font-weight:700;font-size:16px">احجز موعدك مع الطبيب</a>
    </div>
  </div>
</div>

<!-- Doctors JSON payload for Modal JS -->
<script id="doctors-json" type="application/json">
{!! json_encode($doctors->toArray(), JSON_UNESCAPED_UNICODE) !!}
</script>
