<!-- ===== BOOKING FORM ===== -->
<section id="book" class="reveal" style="max-width:1240px;margin:0 auto;padding:70px 26px">
  <div style="background:#ffffff;border-radius:36px;border:1px solid rgba(108,24,48,.12);box-shadow:0 30px 70px -20px rgba(108,24,48,.12);overflow:hidden;display:grid;grid-template-columns:1fr 1.1fr" data-col="book">
    <div style="background:linear-gradient(135deg,#4d1022 0%,#6c1830 100%);color:#fff;padding:60px 48px;display:flex;flex-direction:column;justify-content:space-between">
      <div>
        <img src="{{ asset('images/branding/icon-white.svg') }}" alt="بالديرما" style="width:52px;height:52px;display:block;margin-bottom:24px">
        <div style="color:#f7c8d6;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'احجز موعدك' }}</div>
        <h2 style="font-size:clamp(26px,3.4vw,40px);font-weight:900;line-height:1.25;margin:0 0 20px">{{ $sectionInfo->title ?? 'ابدأي رحلة العناية ببشرتكِ وجسمكِ اليوم' }}</h2>
        <p style="font-size:16.5px;line-height:1.85;font-weight:300;color:rgba(255,255,255,.88);margin:0 0 32px">{{ $sectionInfo->description ?? 'سجلي بياناتك وسيقوم فريق الخدمة بالتواصل معكِ فوراً لتأكيد الموعد المناسب.' }}</p>
      </div>

      <div>
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:20px">
          <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.14);display:flex;align-items:center;justify-content:center;color:#fff">
            <span class="material-symbols-outlined">call</span>
          </div>
          @php $bookingWhatsapp = $socialLinks->firstWhere('platform', 'whatsapp'); @endphp
          <div>
            <div style="font-size:13px;color:rgba(255,255,255,.7);font-weight:300">للاستفسار والحجز الفوري:</div>
            @if($bookingWhatsapp)
            <a id="btn-whatsapp-booking" href="{{ $bookingWhatsapp->url }}" target="_blank" rel="noopener" style="font-size:17px;font-weight:700;color:#fff;direction:ltr;text-align:right;text-decoration:none;display:block">{{ $settings->phone ?? '+966 9200 00000' }}</a>
            @else
            <div style="font-size:17px;font-weight:700;color:#fff;direction:ltr;text-align:right">{{ $settings->phone ?? '+966 9200 00000' }}</div>
            @endif
          </div>
        </div>

        <div style="display:flex;align-items:center;gap:14px">
          <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.14);display:flex;align-items:center;justify-content:center;color:#fff">
            <span class="material-symbols-outlined">location_on</span>
          </div>
          <div>
            <div style="font-size:13px;color:rgba(255,255,255,.7);font-weight:300">موقع العيادة:</div>
            <div style="font-size:15px;font-weight:500;color:#fff">{{ $settings->address ?? 'الرياض، طريق الملك فهد' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div style="padding:60px 48px">
      <form id="booking-form" data-booking-form action="/booking" method="POST">
        @csrf
        <!-- Honeypot -->
        <input type="text" name="website_hp" style="display:none" tabindex="-1" autocomplete="off">

        <div data-form-alert style="display:none;padding:14px 18px;border-radius:14px;margin-bottom:24px;font-size:14.5px;font-weight:500"></div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px" data-form-row>
          <div>
            <label style="display:block;font-size:14px;font-weight:700;color:#2a1620;margin-bottom:8px">الاسم الكامل *</label>
            <input type="text" name="name" required placeholder="أدخلي اسمكِ الكريم" class="form-input-focus" style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid rgba(108,24,48,.18);background:#faf6f4;font-size:15px">
          </div>

          <div>
            <label style="display:block;font-size:14px;font-weight:700;color:#2a1620;margin-bottom:8px">رقم الجوال *</label>
            <input type="tel" name="phone" required placeholder="05xxxxxxxx" class="form-input-focus" style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid rgba(108,24,48,.18);background:#faf6f4;font-size:15px;direction:ltr;text-align:right">
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px" data-form-row>
          <div>
            <label style="display:block;font-size:14px;font-weight:700;color:#2a1620;margin-bottom:8px">الخدمة المطلوبة *</label>
            <select name="service_option_id" required class="form-input-focus" style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid rgba(108,24,48,.18);background:#faf6f4;font-size:15px;color:#2a1620">
              <option value="" disabled selected>اختر الخدمة أو الباقة...</option>
              @foreach($bookingOptions as $option)
              <option value="{{ $option->id }}">{{ $option->label }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label style="display:block;font-size:14px;font-weight:700;color:#2a1620;margin-bottom:8px">البريد الإلكتروني (اختياري)</label>
            <input type="email" name="email" placeholder="name@example.com" class="form-input-focus" style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid rgba(108,24,48,.18);background:#faf6f4;font-size:15px;direction:ltr;text-align:right">
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px" data-form-row>
          <div>
            <label style="display:block;font-size:14px;font-weight:700;color:#2a1620;margin-bottom:8px">تاريخ الموعد المفضل</label>
            <input type="date" name="preferred_date" data-booking-date class="form-input-focus" style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid rgba(108,24,48,.18);background:#faf6f4;font-size:15px;color:#2a1620">
          </div>

          <div>
            <label style="display:block;font-size:14px;font-weight:700;color:#2a1620;margin-bottom:8px">وقت الموعد المفضل</label>
            <input type="time" name="preferred_time" data-booking-time min="09:00" max="17:00" step="1800" class="form-input-focus" style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid rgba(108,24,48,.18);background:#faf6f4;font-size:15px;color:#2a1620">
            <div style="font-size:12.5px;color:#8a7580;margin-top:6px">مواعيد العيادة من 9 صباحاً حتى 5 مساءً</div>
          </div>
        </div>

        <div style="margin-bottom:24px">
          <label style="display:block;font-size:14px;font-weight:700;color:#2a1620;margin-bottom:8px">ملاحظات أو تفاصيل إضافية</label>
          <textarea name="notes" rows="3" placeholder="هل لديك أي استفسار أو حالة خاصة ترغبين بإبلاغ الطبيب بها؟" class="form-input-focus" style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid rgba(108,24,48,.18);background:#faf6f4;font-size:15px;resize:vertical"></textarea>
        </div>

        <button id="btn-booking-submit" type="submit" class="btn-hover-burgundy" style="width:100%;background:#6c1830;color:#fff;padding:16px;border-radius:100px;font-weight:700;font-size:17px;border:none;cursor:pointer">تأكيد طلب الحجز</button>
      </form>
    </div>
  </div>
</section>
