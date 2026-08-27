<!-- ===== BLOG TEASER (homepage) ===== -->
@if($latestBlogPosts->isNotEmpty())
<section id="blog" class="reveal" style="max-width:1240px;margin:0 auto;padding:70px 26px">
  <div style="text-align:center;max-width:680px;margin:0 auto 44px">
    <div style="color:#96123c;font-weight:700;font-size:15px;letter-spacing:.12em;margin-bottom:14px">{{ $sectionInfo->eyebrow ?? 'من مدونتنا' }}</div>
    <h2 style="font-size:clamp(28px,3.6vw,44px);font-weight:900;line-height:1.2;margin:0 0 16px;color:#2a1620">{{ $sectionInfo->title ?? 'أحدث المقالات والنصائح الطبية' }}</h2>
    <p style="font-size:17px;line-height:1.8;font-weight:300;color:#5a4650;margin:0">{{ $sectionInfo->description ?? 'نصائح موثوقة من فريقنا الطبي حول العناية بالبشرة وأحدث تقنيات التجميل والليزر.' }}</p>
  </div>

  <div data-grid="blog" style="display:grid;grid-template-columns:repeat({{ min(3, $latestBlogPosts->count()) }},1fr);gap:26px;margin-bottom:40px">
    @foreach($latestBlogPosts as $post)
    <x-blog-post-card :post="$post" />
    @endforeach
  </div>

  <div style="text-align:center">
    <a href="{{ route('blog.index') }}" style="background:#faf0f3;color:#6c1830;border:1px solid rgba(108,24,48,.2);padding:14px 32px;border-radius:100px;font-weight:700;font-size:15.5px;display:inline-flex;align-items:center;gap:8px">
      تصفّح كل المقالات
      <span class="material-symbols-outlined" style="font-size:20px">arrow_back</span>
    </a>
  </div>
</section>
@endif
