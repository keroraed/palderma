@if ($paginator->hasPages())
<nav class="blog-pagination" role="navigation" aria-label="ترقيم صفحات المدونة">

    {{-- "Previous" points right (›), matching this RTL site's existing prev/next
         arrow convention (see the hero slider) — previous = toward the start,
         which sits on the right in RTL reading order. --}}
    @if ($paginator->onFirstPage())
        <span class="is-disabled" aria-disabled="true" aria-label="السابق">›</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="الصفحة السابقة">›</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="is-disabled">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="is-current" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="الصفحة التالية">‹</a>
    @else
        <span class="is-disabled" aria-disabled="true" aria-label="التالي">‹</span>
    @endif

</nav>
@endif
