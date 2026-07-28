@props(['service'])
<div data-service-card data-service-id="{{ $service->id }}" class="card-hover-lift" style="background:#fff;border-radius:24px;padding:32px 24px;border:1px solid rgba(108,24,48,.1);box-shadow:0 10px 25px -10px rgba(108,24,48,.06);display:flex;flex-direction:column;justify-content:space-between;cursor:pointer">
  <div>
    <div style="width:58px;height:58px;border-radius:18px;background:#faf0f3;color:#6c1830;display:flex;align-items:center;justify-content:center;margin-bottom:22px">
      @if($service->icon_type === 'material')
      <span class="material-symbols-outlined" style="font-size:30px">{{ $service->icon_value }}</span>
      @else
      {!! $service->icon_value !!}
      @endif
    </div>
    <h3 style="font-size:19px;font-weight:700;margin:0 0 10px;color:#2a1620">{{ $service->title }}</h3>
    <p style="font-size:14.5px;line-height:1.8;font-weight:300;color:#6a5660;margin:0 0 20px">{{ $service->description }}</p>
  </div>
  <div>
    <a href="/#book" data-book-service @if($service->booking_option_id) data-service-option-id="{{ $service->booking_option_id }}" @endif style="color:#96123c;font-weight:700;font-size:14.5px;display:inline-flex;align-items:center;gap:6px">احجز هذه الخدمة <span style="font-size:18px">←</span></a>
  </div>
</div>
