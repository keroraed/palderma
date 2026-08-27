<x-app-layout
  :settings="$settings"
  :seo-title="$seoTitle ?? null"
  :seo-description="$seoDescription ?? null"
  :noindex="$noindex ?? false"
>

  @include('sections.header')

  <div dir="rtl" style="width:100%;overflow-x:hidden">

    <section style="max-width:1240px;margin:0 auto;padding:70px 26px 20px">

      <div style="margin-bottom:28px">
        <a href="{{ route('landing') }}" style="color:#96123c;font-weight:700;font-size:14.5px;display:inline-flex;align-items:center;gap:6px">
          <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
          العودة للصفحة الرئيسية
        </a>
      </div>

      <div style="text-align:center;max-width:720px;margin:0 auto 40px">
        <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">المدونة</div>
        <h1 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">{{ $heading }}</h1>
        @if(!empty($intro))
        <p style="font-size:17px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $intro }}</p>
        @endif
      </div>

      {{-- Category filter chips: only worth showing when there is more than one
           real choice, and only on the main index (not inside a category/tag
           page, to avoid a self-referential "you are here" chip). --}}
      @if(!$activeCategory && !$activeTag && $categories->count() > 1)
      <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:48px">
        <a href="{{ route('blog.index') }}" class="blog-filter-chip is-active">كل المقالات</a>
        @foreach($categories as $cat)
        <a href="{{ route('blog.category', $cat) }}" class="blog-filter-chip">{{ $cat->name }} ({{ $cat->published_posts_count }})</a>
        @endforeach
      </div>
      @elseif($activeCategory || $activeTag)
      <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:48px">
        <a href="{{ route('blog.index') }}" class="blog-filter-chip">
          <span class="material-symbols-outlined" style="font-size:16px;margin-left:4px">arrow_forward</span>
          كل المقالات
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('blog.category', $cat) }}" class="blog-filter-chip @if($activeCategory && $activeCategory->id === $cat->id) is-active @endif">{{ $cat->name }} ({{ $cat->published_posts_count }})</a>
        @endforeach
      </div>
      @endif

      @if($featuredPosts->isNotEmpty())
      <div style="margin-bottom:56px">
        <h2 style="font-size:22px;font-weight:900;color:#2a1620;margin:0 0 24px">مقالات مميزة</h2>
        <div data-grid="blog-featured" style="display:grid;grid-template-columns:repeat({{ min(3, $featuredPosts->count()) }},1fr);gap:24px">
          @foreach($featuredPosts as $post)
          <a href="{{ route('blog.show', $post) }}" class="blog-featured-card">
            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async">
            <div class="blog-featured-card-body">
              @if($post->category)
              <div style="display:inline-flex;background:rgba(255,255,255,.18);backdrop-filter:blur(6px);color:#fff;font-size:12px;font-weight:700;padding:4px 12px;border-radius:100px;margin-bottom:10px">{{ $post->category->name }}</div>
              @endif
              <h3 style="font-size:17.5px;font-weight:700;line-height:1.4;margin:0">{{ $post->title }}</h3>
            </div>
          </a>
          @endforeach
        </div>
      </div>
      @endif

      @if($posts->isEmpty())
      <div style="text-align:center;padding:60px 20px;color:#8a7580">
        <span class="material-symbols-outlined" style="font-size:48px;color:#e0c7cf;margin-bottom:14px;display:block">draft</span>
        لا توجد مقالات منشورة {{ $activeCategory || $activeTag ? 'في هذا القسم بعد' : 'بعد' }}.
      </div>
      @else
      <div data-grid="blog" style="display:grid;grid-template-columns:repeat(3,1fr);gap:26px">
        @foreach($posts as $post)
        <x-blog-post-card :post="$post" />
        @endforeach
      </div>

      {{ $posts->links('vendor.pagination.blog') }}
      @endif

    </section>

  </div>

  @include('sections.footer')

</x-app-layout>
