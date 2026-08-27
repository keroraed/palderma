@props(['post'])
<article class="blog-card card-hover-lift">
  <a href="{{ route('blog.show', $post) }}" class="blog-card-image" aria-hidden="true" tabindex="-1">
    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async">
  </a>
  <div class="blog-card-body">
    @if($post->category)
    <a href="{{ route('blog.category', $post->category) }}" class="blog-category-pill">{{ $post->category->name }}</a>
    @endif
    <h3 class="blog-card-title">
      <a href="{{ route('blog.show', $post) }}" style="color:inherit">{{ $post->title }}</a>
    </h3>
    <p class="blog-card-excerpt">{{ $post->excerpt }}</p>
    <div class="blog-card-meta">
      <span class="material-symbols-outlined" style="font-size:15px">calendar_month</span>
      <time datetime="{{ optional($post->published_at)->toAtomString() }}">{{ optional($post->published_at)->translatedFormat('d F Y') }}</time>
      <span>·</span>
      <span>{{ $post->reading_time }} دقائق قراءة</span>
    </div>
    <a href="{{ route('blog.show', $post) }}" class="blog-card-readmore">
      اقرأ المزيد <span style="font-size:16px">←</span>
    </a>
  </div>
</article>
