<!-- ===== HEADER ===== -->
<header class="site-header">
  <div class="header-inner">
    <a href="#top" style="display:flex;align-items:center">
      <img src="{{ asset($settings->logo_primary ?? 'images/branding/logo-primary.svg') }}" alt="بالديرما" class="header-logo" style="display:block">
    </a>

    <nav style="display:flex;align-items:center;gap:28px" data-nav="desktop">
      @foreach($navLinks->where('show_in_header', true) as $link)
        @if($link->is_cta)
        <a href="{{ $link->href }}" class="btn-hover-burgundy" style="background:#6c1830;color:#fff;padding:11px 24px;border-radius:100px;font-weight:700;font-size:15px">{{ $link->label }}</a>
        @else
        <a href="{{ $link->href }}" style="font-size:15.5px;font-weight:500;color:#3a2028">{{ $link->label }}</a>
        @endif
      @endforeach
    </nav>

    <button aria-label="القائمة" style="display:none;background:none;border:0;cursor:pointer;padding:8px" data-nav="burger">
      <div style="width:26px;height:2.5px;background:#6c1830;border-radius:2px;margin:5px 0"></div>
      <div style="width:26px;height:2.5px;background:#6c1830;border-radius:2px;margin:5px 0"></div>
      <div style="width:26px;height:2.5px;background:#6c1830;border-radius:2px;margin:5px 0"></div>
    </button>
  </div>

  <div data-menu-panel style="display:none;border-top:1px solid rgba(108,24,48,.1);background:#faf6f4;padding:8px 26px 20px;flex-direction:column;gap:4px">
    @foreach($navLinks->where('show_in_header', true) as $link)
      @if($link->is_cta)
      <a href="{{ $link->href }}" style="margin-top:8px;background:#6c1830;color:#fff;padding:12px;border-radius:100px;font-weight:700;text-align:center">{{ $link->label }}</a>
      @else
      <a href="{{ $link->href }}" style="padding:11px 4px;font-weight:500;border-bottom:1px solid rgba(108,24,48,.07)">{{ $link->label }}</a>
      @endif
    @endforeach
  </div>
</header>
