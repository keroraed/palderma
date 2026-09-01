<x-app-layout
  :settings="$settings"
  :seo-title="$metaTitle"
  :seo-description="$metaDescription"
  :og-image="$post->featured_image"
  :canonical="$canonicalUrl"
  og-type="article"
  :noindex="$isPreview"
  :article-published-time="optional($post->published_at)->toAtomString()"
  :article-modified-time="$post->updated_at->toAtomString()"
  :article-author="$authorName"
>

  @push('head')
  <script type="application/ld+json">{!! $articleJsonLd !!}</script>
  <script type="application/ld+json">{!! $breadcrumbJsonLd !!}</script>
  @endpush

  @include('sections.header')

  <div dir="rtl" style="width:100%;overflow-x:hidden">

    @if($isPreview)
    <div style="background:#96123c;color:#fff;text-align:center;padding:12px 20px;font-size:14px;font-weight:700">
      <span class="material-symbols-outlined" style="font-size:16px;vertical-align:-3px">visibility</span>
      معاينة {{ $post->status === \App\Models\BlogPost::STATUS_DRAFT ? '— هذا المقال مسودة غير منشورة' : '— موعد النشر لم يحن بعد' }}، غير مرئي للزوار
    </div>
    @endif

    <article style="max-width:800px;margin:0 auto;padding:44px 26px 90px">

      {{-- Breadcrumbs --}}
      <nav aria-label="مسار التصفح" style="margin-bottom:26px">
        <ol style="display:flex;flex-wrap:wrap;align-items:center;gap:6px;list-style:none;margin:0;padding:0;font-size:13.5px;color:#8a7580">
          <li><a href="{{ url('/') }}" style="color:#8a7580">الرئيسية</a></li>
          <li aria-hidden="true">/</li>
          <li><a href="{{ route('blog.index') }}" style="color:#8a7580">المدونة</a></li>
          @if($post->category)
          <li aria-hidden="true">/</li>
          <li><a href="{{ route('blog.category', $post->category) }}" style="color:#8a7580">{{ $post->category->name }}</a></li>
          @endif
          <li aria-hidden="true">/</li>
          <li style="color:#6c1830;font-weight:600" aria-current="page">{{ \Illuminate\Support\Str::limit($post->title, 40) }}</li>
        </ol>
      </nav>

      @if($post->category)
      <a href="{{ route('blog.category', $post->category) }}" class="blog-category-pill" style="margin-bottom:16px">{{ $post->category->name }}</a>
      @endif

      <h1 style="font-size:clamp(26px,4vw,40px);font-weight:900;line-height:1.3;color:#2a1620;margin:0 0 20px;text-wrap:balance">{{ $post->title }}</h1>

      <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;color:#7a6670;font-size:14px;font-weight:500;margin-bottom:30px;padding-bottom:26px;border-bottom:1px solid rgba(108,24,48,.1)">
        <span style="display:inline-flex;align-items:center;gap:6px">
          <span class="material-symbols-outlined" style="font-size:17px">person</span>
          {{ $authorName }}
        </span>
        <span style="display:inline-flex;align-items:center;gap:6px">
          <span class="material-symbols-outlined" style="font-size:17px">calendar_month</span>
          <time datetime="{{ optional($post->published_at)->toAtomString() }}">{{ optional($post->published_at)->translatedFormat('d F Y') }}</time>
        </span>
        @if($post->updated_at->diffInDays($post->published_at) >= 1)
        <span style="display:inline-flex;align-items:center;gap:6px">
          <span class="material-symbols-outlined" style="font-size:17px">update</span>
          آخر تحديث: {{ $post->updated_at->translatedFormat('d F Y') }}
        </span>
        @endif
        <span style="display:inline-flex;align-items:center;gap:6px">
          <span class="material-symbols-outlined" style="font-size:17px">schedule</span>
          {{ $post->reading_time }} دقائق قراءة
        </span>
      </div>

      @if($post->featured_image)
      <div style="border-radius:24px;overflow:hidden;margin-bottom:36px;box-shadow:0 20px 45px -20px rgba(108,24,48,.35)">
        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" style="width:100%;height:auto;display:block" fetchpriority="high" decoding="async">
      </div>
      @endif

      @php
        // One pass produces both the body HTML (with ids added to each heading)
        // and the matching heading list, so the anchors can never fall out of sync.
        $rendered = $post->contentWithTableOfContents();
      @endphp

      {{-- Shown only when there are enough headings to be worth navigating;
           on a two-heading article a TOC is noise rather than help. --}}
      @if(count($rendered['toc']) >= 3)
      <nav class="blog-toc" aria-labelledby="blog-toc-title">
        <h2 class="blog-toc-title" id="blog-toc-title">
          <span class="material-symbols-outlined" aria-hidden="true">list</span>
          محتويات المقال
        </h2>
        <ol class="blog-toc-list">
          @foreach($rendered['toc'] as $item)
          <li @class(['blog-toc-sub' => $item['level'] === 3])>
            <a href="#{{ $item['id'] }}">{{ $item['text'] }}</a>
          </li>
          @endforeach
        </ol>
      </nav>
      @endif

      <div class="blog-article-content">
        {!! $rendered['html'] !!}
      </div>

      @if(!empty($post->gallery))
      <div style="margin-top:40px">
        <h2 style="font-size:20px;font-weight:900;color:#2a1620;margin:0 0 18px">صور إضافية</h2>
        <div class="blog-gallery">
          @foreach($post->gallery as $item)
          <figure>
            <img src="{{ asset($item['image']) }}" alt="{{ $item['caption'] ?? $post->title }}" loading="lazy" decoding="async">
            @if(!empty($item['caption']))
            <figcaption>{{ $item['caption'] }}</figcaption>
            @endif
          </figure>
          @endforeach
        </div>
      </div>
      @endif

      @if($post->tags->isNotEmpty())
      <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:36px">
        @foreach($post->tags as $tag)
        <a href="{{ route('blog.tag', $tag) }}" style="background:#faf6f4;color:#6c1830;font-size:13px;font-weight:600;padding:6px 14px;border-radius:100px;border:1px solid rgba(108,24,48,.12)">#{{ $tag->name }}</a>
        @endforeach
      </div>
      @endif

      <div style="margin-top:40px;padding-top:30px;border-top:1px solid rgba(108,24,48,.1)">
        <x-share-buttons :url="$canonicalUrl" :title="$post->title" />
      </div>

      {{-- Booking CTA --}}
      <div style="margin-top:44px;background:linear-gradient(135deg,#4d1022 0%,#6c1830 100%);border-radius:24px;padding:38px 30px;text-align:center;color:#fff">
        <h2 style="font-size:21px;font-weight:900;margin:0 0 10px">هل تحتاجين استشارة متخصصة؟</h2>
        <p style="font-size:15px;font-weight:300;color:rgba(255,255,255,.85);margin:0 0 22px">فريقنا الطبي جاهز لمساعدتك — احجزي موعدك الآن مع نخبة استشاريي الجلدية والتجميل.</p>
        <a href="{{ url('/#book') }}" class="btn-hover-light-pink" style="display:inline-block;background:#fff;color:#6c1830;padding:14px 32px;border-radius:100px;font-weight:700;font-size:15.5px">احجزي موعدك الآن</a>
      </div>

    </article>

    @if($related->isNotEmpty())
    <section style="max-width:1240px;margin:0 auto;padding:0 26px 90px">
      <h2 style="font-size:24px;font-weight:900;color:#2a1620;margin:0 0 26px;text-align:center">مقالات ذات صلة</h2>
      <div data-grid="blog" style="display:grid;grid-template-columns:repeat({{ min(3, $related->count()) }},1fr);gap:26px">
        @foreach($related as $relatedPost)
        <x-blog-post-card :post="$relatedPost" />
        @endforeach
      </div>
    </section>
    @endif

    <div style="text-align:center;padding-bottom:60px">
      <a href="{{ route('blog.index') }}" style="color:#96123c;font-weight:700;font-size:14.5px;display:inline-flex;align-items:center;gap:6px">
        <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
        العودة لجميع المقالات
      </a>
    </div>

  </div>

  @include('sections.footer')

</x-app-layout>
