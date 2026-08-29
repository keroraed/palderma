<x-app-layout
  :settings="$settings"
  :seo-title="$metaTitle"
  :seo-description="$metaDescription"
  :canonical="$canonicalUrl"
>

  @push('head')
  <script type="application/ld+json">{!! $schemaJsonLd !!}</script>
  <script type="application/ld+json">{!! $breadcrumbJsonLd !!}</script>
  @endpush

  @include('sections.header')

  <div dir="rtl" style="width:100%;overflow-x:hidden;background:#faf6f4;color:#2a1620">

    {{-- Breadcrumbs & Top Navigation --}}
    <div style="background:#fff;border-bottom:1px solid rgba(108,24,48,.08);padding:14px 24px">
      <div style="max-width:1240px;margin:0 auto">
        <nav aria-label="مسار التصفح">
          <ol style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;list-style:none;margin:0;padding:0;font-size:14px;color:#8a7580">
            <li><a href="{{ url('/') }}" style="color:#8a7580;display:inline-flex;align-items:center;gap:4px"><span class="material-symbols-outlined" style="font-size:16px">home</span>الرئيسية</a></li>
            <li aria-hidden="true" style="color:#cbb5be">/</li>
            <li><a href="{{ route('services.all') }}" style="color:#8a7580">الخدمات</a></li>
            <li aria-hidden="true" style="color:#cbb5be">/</li>
            <li style="color:#6c1830;font-weight:700" aria-current="page">{{ $service->title }}</li>
          </ol>
        </nav>
      </div>
    </div>

    {{-- HERO SHOWCASE SECTION --}}
    <section style="position:relative;background:linear-gradient(180deg, #ffffff 0%, #faf0f3 100%);padding:60px 24px 70px;border-bottom:1px solid rgba(108,24,48,.08);overflow:hidden">
      {{-- Ambient decorative background glow --}}
      <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:350px;background:radial-gradient(circle, rgba(150,18,60,.08) 0%, rgba(250,240,243,0) 70%);pointer-events:none"></div>

      <div style="max-width:1100px;margin:0 auto;position:relative;z-index:1;text-align:center">
        
        {{-- Hero Badge --}}
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(108,24,48,.07);border:1px solid rgba(108,24,48,.15);color:#6c1830;padding:8px 20px;border-radius:100px;font-size:14px;font-weight:700;margin-bottom:24px;box-shadow:0 4px 15px -4px rgba(108,24,48,.1)">
          <span>{{ $service->hero_badge ?: '✨ خدمات التجميل والجلدية المتخصصة' }}</span>
        </div>

        {{-- Main Icon & Title --}}
        <div style="display:flex;align-items:center;justify-content:center;gap:18px;margin-bottom:20px;flex-wrap:wrap">
          <div style="width:68px;height:68px;border-radius:22px;background:#6c1830;color:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 28px -8px rgba(108,24,48,.4);flex-shrink:0">
            @if($service->icon_type === 'material')
            <span class="material-symbols-outlined" style="font-size:36px">{{ $service->icon_value }}</span>
            @else
            {!! $service->icon_value !!}
            @endif
          </div>
          <h1 style="font-size:clamp(30px,4.5vw,50px);font-weight:900;line-height:1.2;color:#2a1620;margin:0">
            {{ $service->title }}
          </h1>
        </div>

        {{-- Description --}}
        <p style="font-size:clamp(16px,2vw,19px);line-height:1.85;font-weight:300;color:#5a4650;max-width:820px;margin:0 auto 36px">
          {{ $service->details ?: $service->description }}
        </p>

        {{-- Quick Stat Highlights Bar --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;max-width:960px;margin:0 auto 36px">
          <div style="background:rgba(255,255,255,.9);backdrop-filter:blur(8px);border:1px solid rgba(108,24,48,.1);border-radius:18px;padding:18px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 8px 20px -8px rgba(108,24,48,.05)">
            <div style="width:42px;height:42px;border-radius:12px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <span class="material-symbols-outlined" style="font-size:22px">schedule</span>
            </div>
            <div style="text-align:right">
              <div style="font-size:12.5px;color:#8a7580;font-weight:500">مدة الجلسة</div>
              <div style="font-size:15px;color:#2a1620;font-weight:700">20 - 45 دقيقة</div>
            </div>
          </div>

          <div style="background:rgba(255,255,255,.9);backdrop-filter:blur(8px);border:1px solid rgba(108,24,48,.1);border-radius:18px;padding:18px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 8px 20px -8px rgba(108,24,48,.05)">
            <div style="width:42px;height:42px;border-radius:12px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <span class="material-symbols-outlined" style="font-size:22px">verified_user</span>
            </div>
            <div style="text-align:right">
              <div style="font-size:12.5px;color:#8a7580;font-weight:500">الأمان والاعتماد</div>
              <div style="font-size:15px;color:#2a1620;font-weight:700">معتمدة من SFDA</div>
            </div>
          </div>

          <div style="background:rgba(255,255,255,.9);backdrop-filter:blur(8px);border:1px solid rgba(108,24,48,.1);border-radius:18px;padding:18px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 8px 20px -8px rgba(108,24,48,.05)">
            <div style="width:42px;height:42px;border-radius:12px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <span class="material-symbols-outlined" style="font-size:22px">person_check</span>
            </div>
            <div style="text-align:right">
              <div style="font-size:12.5px;color:#8a7580;font-weight:500">الكادر الطبي</div>
              <div style="font-size:15px;color:#2a1620;font-weight:700">استشاريون معتمدون</div>
            </div>
          </div>

          <div style="background:rgba(255,255,255,.9);backdrop-filter:blur(8px);border:1px solid rgba(108,24,48,.1);border-radius:18px;padding:18px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 8px 20px -8px rgba(108,24,48,.05)">
            <div style="width:42px;height:42px;border-radius:12px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <span class="material-symbols-outlined" style="font-size:22px">spa</span>
            </div>
            <div style="text-align:right">
              <div style="font-size:12.5px;color:#8a7580;font-weight:500">النتائج المتوقعة</div>
              <div style="font-size:15px;color:#2a1620;font-weight:700">طبيعية ومتناسقة</div>
            </div>
          </div>
        </div>

        {{-- CTA Actions --}}
        <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap">
          <a href="/?service_option={{ $service->booking_option_id }}#book" class="btn-hover-burgundy" style="display:inline-flex;align-items:center;gap:10px;background:#6c1830;color:#fff;padding:16px 36px;border-radius:100px;font-weight:700;font-size:16px;box-shadow:0 14px 30px -10px rgba(108,24,48,.5)">
            <span class="material-symbols-outlined" style="font-size:20px">calendar_month</span>
            <span>احجزي موعدكِ لهذه الخدمة</span>
          </a>
          <a href="#subservices" style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#6c1830;border:1.5px solid rgba(108,24,48,.2);padding:15px 28px;border-radius:100px;font-weight:700;font-size:15.5px">
            <span>استعراض الخدمات الفرعية</span>
            <span class="material-symbols-outlined" style="font-size:18px">arrow_downward</span>
          </a>
        </div>

      </div>
    </section>

    {{-- MAIN CONTENT: SUBSERVICES SHOWCASE --}}
    <section id="subservices" style="max-width:1240px;margin:0 auto;padding:70px 24px">
      
      <div style="text-align:center;max-width:700px;margin:0 auto 50px">
        <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.1em;margin-bottom:12px">الخيارات والخدمات الفرعية</div>
        <h2 style="font-size:clamp(26px,3.5vw,38px);font-weight:900;line-height:1.25;color:#2a1620;margin:0 0 16px">
          تفاصيل العلاجات والخيارات المتاحة
        </h2>
        <p style="font-size:16.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">
          اخترنا لكِ أدق التقنيات وأفضل البروتوكولات العلاجية المصممة بعناية لتلبية احتياجات بشرتكِ وجمالكِ.
        </p>
      </div>

      @if($service->activeSubServices->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(360px, 1fr));gap:28px">
        @foreach($service->activeSubServices as $sub)
        <div class="card-hover-lift" style="background:#fff;border-radius:28px;border:1px solid rgba(108,24,48,.1);box-shadow:0 12px 35px -12px rgba(108,24,48,.07);padding:36px 30px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden">
          
          {{-- Decorative top accent line --}}
          <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg, #6c1830, #96123c)"></div>

          <div>
            {{-- Badge and Top Row --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:16px;flex-wrap:wrap">
              <h3 style="font-size:21px;font-weight:900;color:#2a1620;margin:0;line-height:1.35;flex:1 1 auto">
                {{ $sub->title }}
              </h3>
              @if(!empty($sub->badge))
              <span style="display:inline-flex;align-items:center;background:#faf0f3;color:#6c1830;border:1px solid rgba(108,24,48,.15);padding:5px 12px;border-radius:100px;font-size:12.5px;font-weight:700;white-space:nowrap">
                {{ $sub->badge }}
              </span>
              @endif
            </div>

            {{-- Metadata Chips: Duration & Target Area --}}
            <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:18px">
              @if(!empty($sub->duration))
              <div style="display:inline-flex;align-items:center;gap:5px;background:#f8f6f5;color:#5a4650;padding:4px 12px;border-radius:8px;font-size:13px;font-weight:500">
                <span class="material-symbols-outlined" style="font-size:15px;color:#96123c">timer</span>
                <span>{{ $sub->duration }}</span>
              </div>
              @endif

              @if(!empty($sub->target_area))
              <div style="display:inline-flex;align-items:center;gap:5px;background:#f8f6f5;color:#5a4650;padding:4px 12px;border-radius:8px;font-size:13px;font-weight:500">
                <span class="material-symbols-outlined" style="font-size:15px;color:#96123c">adjust</span>
                <span>{{ $sub->target_area }}</span>
              </div>
              @endif
            </div>

            {{-- Description --}}
            <p style="font-size:15px;line-height:1.85;font-weight:300;color:#5a4650;margin:0 0 22px">
              {{ $sub->description }}
            </p>

            {{-- Features list --}}
            @if(is_array($sub->features) && count($sub->features) > 0)
            <div style="margin-bottom:22px;background:#fdfafb;border-radius:16px;padding:16px 18px;border:1px solid rgba(108,24,48,.06)">
              <div style="font-size:13.5px;font-weight:700;color:#6c1830;margin-bottom:10px;display:flex;align-items:center;gap:6px">
                <span class="material-symbols-outlined" style="font-size:17px">check_circle</span>
                <span>مميزات وما تشمله الجلسة:</span>
              </div>
              <ul style="margin:0;padding:0;list-style:none;font-size:14px;color:#4a3640;font-weight:300">
                @foreach($sub->features as $feature)
                <li style="margin-bottom:8px;display:flex;align-items:flex-start;gap:8px;line-height:1.6">
                  <span style="color:#96123c;font-weight:700;line-height:1.5">•</span>
                  <span>{{ $feature }}</span>
                </li>
                @endforeach
              </ul>
            </div>
            @endif

            {{-- Aftercare tips --}}
            @if(!empty($sub->aftercare_tips))
            <div style="font-size:13px;line-height:1.7;color:#7a6670;font-weight:400;margin-bottom:22px;display:flex;align-items:flex-start;gap:6px">
              <span class="material-symbols-outlined" style="font-size:16px;color:#6c1830;flex-shrink:0;margin-top:2px">info</span>
              <span><strong>نصيحة إكلينيكية:</strong> {{ $sub->aftercare_tips }}</span>
            </div>
            @endif
          </div>

          {{-- Card Action Button --}}
          <div style="padding-top:16px;border-top:1px solid rgba(108,24,48,.08);margin-top:8px">
            <a href="/?service_option={{ $sub->booking_option_id ?: $service->booking_option_id }}#book" class="btn-hover-burgundy" style="display:flex;align-items:center;justify-content:center;gap:8px;background:#6c1830;color:#fff;padding:13px 20px;border-radius:100px;font-weight:700;font-size:14.5px;box-shadow:0 8px 20px -6px rgba(108,24,48,.35)">
              <span class="material-symbols-outlined" style="font-size:18px">calendar_month</span>
              <span>احجزي هذه الخدمة الآن</span>
            </a>
          </div>

        </div>
        @endforeach
      </div>
      @else
      <div style="background:#fff;border-radius:24px;padding:48px 24px;text-align:center;border:1px solid rgba(108,24,48,.1)">
        <p style="font-size:16px;color:#7a6670;margin:0 0 20px">تواصل معنا للاستفسار عن تفاصيل وحزم هذا العلاج المخصصة.</p>
        <a href="/?service_option={{ $service->booking_option_id }}#book" class="btn-hover-burgundy" style="display:inline-flex;align-items:center;gap:8px;background:#6c1830;color:#fff;padding:14px 28px;border-radius:100px;font-weight:700">
          <span>احجزي موعدكِ الآن</span>
        </a>
      </div>
      @endif

    </section>

    {{-- TREATMENT JOURNEY TIMELINE --}}
    <section style="background:#fff;border-top:1px solid rgba(108,24,48,.08);border-bottom:1px solid rgba(108,24,48,.08);padding:70px 24px">
      <div style="max-width:1140px;margin:0 auto">
        
        <div style="text-align:center;max-width:680px;margin:0 auto 50px">
          <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.1em;margin-bottom:12px">رحلتكِ العلاجية في بالديرما</div>
          <h2 style="font-size:clamp(26px,3.5vw,38px);font-weight:900;line-height:1.25;color:#2a1620;margin:0 0 16px">
            خطوات جلستكِ العلاجية بكل طمأنينة
          </h2>
          <p style="font-size:16.5px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">
            نحرص على تطبيق أعلى المعايير الطبية لضمان راحتكِ والحصول على النتيجة المرجوة من الزيارة الأولى.
          </p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(230px, 1fr));gap:24px">
          
          <div style="background:#faf0f3;border-radius:22px;padding:28px 22px;border:1px solid rgba(108,24,48,.1);position:relative">
            <div style="width:48px;height:48px;border-radius:14px;background:#6c1830;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;margin-bottom:18px">
              01
            </div>
            <h3 style="font-size:18px;font-weight:700;color:#2a1620;margin:0 0 10px">الاستشارة والتقييم الطبي</h3>
            <p style="font-size:14px;line-height:1.75;font-weight:300;color:#5a4650;margin:0">
              جلسة تقييم شاملة مع الاستشاري لمعاينة البشرة وفهم أهدافكِ وتحديد البروتوكول الأنسب.
            </p>
          </div>

          <div style="background:#faf0f3;border-radius:22px;padding:28px 22px;border:1px solid rgba(108,24,48,.1);position:relative">
            <div style="width:48px;height:48px;border-radius:14px;background:#6c1830;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;margin-bottom:18px">
              02
            </div>
            <h3 style="font-size:18px;font-weight:700;color:#2a1620;margin:0 0 10px">التحضير والتعقيم الدقيق</h3>
            <p style="font-size:14px;line-height:1.75;font-weight:300;color:#5a4650;margin:0">
              تنظيف وتجهيز البشرة وتطبيق التخدير الموضعي عند الحاجة لضمان تجربة مريحة تماماً.
            </p>
          </div>

          <div style="background:#faf0f3;border-radius:22px;padding:28px 22px;border:1px solid rgba(108,24,48,.1);position:relative">
            <div style="width:48px;height:48px;border-radius:14px;background:#6c1830;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;margin-bottom:18px">
              03
            </div>
            <h3 style="font-size:18px;font-weight:700;color:#2a1620;margin:0 0 10px">تطبيق التقنية المعتمدة</h3>
            <p style="font-size:14px;line-height:1.75;font-weight:300;color:#5a4650;margin:0">
              تنفيذ الجلسة بدقة فائقة باستخدام الأجهزة الأصلية والمعتمدة من الهيئة العامة للغذاء والدواء.
            </p>
          </div>

          <div style="background:#faf0f3;border-radius:22px;padding:28px 22px;border:1px solid rgba(108,24,48,.1);position:relative">
            <div style="width:48px;height:48px;border-radius:14px;background:#6c1830;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;margin-bottom:18px">
              04
            </div>
            <h3 style="font-size:18px;font-weight:700;color:#2a1620;margin:0 0 10px">المتابعة والعناية اللاحقة</h3>
            <p style="font-size:14px;line-height:1.75;font-weight:300;color:#5a4650;margin:0">
              تزويدكِ بخطة عناية منزلية مخصصة ومتابعة مستمرة لضمان ديمومة النتائج وإشراقة البشرة.
            </p>
          </div>

        </div>

      </div>
    </section>

    {{-- CLINICAL NOTE / TIPS ALERT --}}
    @if(!empty($service->details_note))
    <section style="max-width:1000px;margin:50px auto 0;padding:0 24px">
      <div style="background:#fff;border-radius:24px;border:1.5px solid rgba(108,24,48,.18);padding:30px 32px;display:flex;align-items:flex-start;gap:20px;box-shadow:0 10px 30px -10px rgba(108,24,48,.08)">
        <div style="width:50px;height:50px;border-radius:16px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <span class="material-symbols-outlined" style="font-size:28px">medical_information</span>
        </div>
        <div>
          <h4 style="font-size:17.5px;font-weight:700;color:#6c1830;margin:0 0 8px">إرشادات وتوصيات الطبيب:</h4>
          <p style="font-size:15px;line-height:1.85;font-weight:300;color:#4a3640;margin:0">
            {{ $service->details_note }}
          </p>
        </div>
      </div>
    </section>
    @endif

    {{-- OTHER SERVICES CROSS-NAVIGATION --}}
    @if($otherServices->count() > 0)
    <section style="max-width:1240px;margin:0 auto;padding:70px 24px 30px">
      <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:36px;flex-wrap:wrap;gap:16px">
        <div>
          <div style="color:#96123c;font-weight:700;font-size:14.5px;margin-bottom:8px">اكتشفي المزيد</div>
          <h2 style="font-size:26px;font-weight:900;color:#2a1620;margin:0">خدمات علاجية وتجميلية أخرى</h2>
        </div>
        <a href="{{ route('services.all') }}" style="color:#6c1830;font-weight:700;font-size:14.5px;display:inline-flex;align-items:center;gap:6px">
          <span>عرض جميع الخدمات</span>
          <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
        </a>
      </div>

      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px">
        @foreach($otherServices as $other)
        <a href="{{ route('services.show', $other->slug ?: $other->id) }}" class="card-hover-lift" style="background:#fff;border-radius:20px;padding:24px 20px;border:1px solid rgba(108,24,48,.1);display:flex;flex-direction:column;justify-content:space-between;color:inherit">
          <div>
            <div style="width:48px;height:48px;border-radius:14px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
              @if($other->icon_type === 'material')
              <span class="material-symbols-outlined" style="font-size:24px">{{ $other->icon_value }}</span>
              @else
              {!! $other->icon_value !!}
              @endif
            </div>
            <h3 style="font-size:17.5px;font-weight:700;margin:0 0 8px;color:#2a1620">{{ $other->title }}</h3>
            <p style="font-size:13.5px;line-height:1.7;font-weight:300;color:#6a5660;margin:0 0 16px">
              {{ \Illuminate\Support\Str::limit($other->description, 75) }}
            </p>
          </div>
          <div style="color:#96123c;font-weight:700;font-size:13.5px;display:inline-flex;align-items:center;gap:4px">
            <span>تفاصيل الخدمة</span>
            <span style="font-size:16px">←</span>
          </div>
        </a>
        @endforeach
      </div>
    </section>
    @endif

    {{-- BOTTOM CONVERSION BANNER --}}
    <section style="max-width:1240px;margin:40px auto 80px;padding:0 24px">
      <div style="background:linear-gradient(135deg, #6c1830 0%, #420f1e 100%);border-radius:32px;padding:50px 36px;color:#fff;text-align:center;box-shadow:0 24px 60px -15px rgba(108,24,48,.45);position:relative;overflow:hidden">
        
        <div style="max-width:700px;margin:0 auto;position:relative;z-index:1">
          <h2 style="font-size:clamp(26px,3.5vw,36px);font-weight:900;margin:0 0 16px;line-height:1.3;color:#fff">
            جاهزة لإطلالة متألقة وبشرة أكثر نضارة؟
          </h2>
          <p style="font-size:16.5px;line-height:1.8;font-weight:300;color:rgba(255,255,255,.9);margin:0 auto 32px">
            احجزي موعد استشارتكِ الآن في مجمع بالديرما الطبي وتمتعي بأرقى تجربة عناية وتجميل بإشراف استشاريينا.
          </p>

          <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap">
            <a href="/?service_option={{ $service->booking_option_id }}#book" style="display:inline-flex;align-items:center;gap:10px;background:#fff;color:#6c1830;padding:16px 36px;border-radius:100px;font-weight:900;font-size:16px;box-shadow:0 10px 25px rgba(0,0,0,.2)">
              <span class="material-symbols-outlined" style="font-size:22px">calendar_month</span>
              <span>احجزي موعدكِ الآن</span>
            </a>
            @if(!empty($settings->whatsapp_phone))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_phone) }}?text={{ urlencode('مرحباً، أود الاستفسار عن خدمة ' . $service->title) }}" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.4);color:#fff;padding:15px 28px;border-radius:100px;font-weight:700;font-size:15.5px">
              <span>تواصل واتساب</span>
              <span class="material-symbols-outlined" style="font-size:20px">chat</span>
            </a>
            @endif
          </div>
        </div>

      </div>
    </section>

  </div>

  @include('sections.footer')
  @include('sections.service-modal')

</x-app-layout>
