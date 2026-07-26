<!-- ===== STAT STRIP ===== -->
<div data-strip-wrap style="max-width:1240px;margin:-40px auto 40px;padding:0 26px;position:relative;z-index:20">
  <div data-strip style="background:#6c1830;color:#fff;border-radius:32px;padding:32px 36px;display:grid;grid-template-columns:repeat(4,1fr);gap:18px;text-align:center;box-shadow:0 20px 50px -15px rgba(108,24,48,.45);border:1px solid rgba(255,255,255,.12)">
    @foreach($stats as $index => $stat)
    <div style="{{ $index > 0 ? 'border-right:1px solid rgba(255,255,255,.18)' : '' }}">
      <div style="font-size:clamp(26px,3.6vw,40px);font-weight:900" data-stat-counter data-stat-val="{{ $stat->value }}">
        {{ $stat->value }}
      </div>
      <div style="font-size:14.5px;color:rgba(255,255,255,.78);font-weight:300;margin-top:4px">{{ $stat->label }}</div>
    </div>
    @endforeach
  </div>
</div>
