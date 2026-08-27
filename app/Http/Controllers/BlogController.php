<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\NavLink;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogController extends Controller
{
    private const PER_PAGE = 9;

    public function index(): View
    {
        $posts = BlogPost::published()
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $featuredPosts = BlogPost::published()
            ->where('is_featured', true)
            ->with(['category'])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return $this->render($posts, [
            'featuredPosts' => $featuredPosts,
            'heading' => 'مدونة مركز بالديرما',
            'intro' => 'مقالات ونصائح موثوقة من فريقنا الطبي حول العناية بالبشرة، أحدث تقنيات التجميل والليزر، وكل ما يهمّك لصحة بشرتك.',
            'seoTitle' => null,
            'seoDescription' => null,
        ]);
    }

    public function category(BlogCategory $category): View
    {
        abort_unless($category->is_active, 404);

        $posts = $category->publishedPosts()
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return $this->render($posts, [
            'featuredPosts' => collect(),
            'heading' => $category->name,
            'intro' => $category->description,
            'activeCategory' => $category,
            'seoTitle' => $category->name . ' — مدونة مركز بالديرما',
            'seoDescription' => $category->description,
        ]);
    }

    public function tag(BlogTag $tag): View
    {
        $posts = $tag->publishedPosts()
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return $this->render($posts, [
            'featuredPosts' => collect(),
            'heading' => 'وسم: ' . $tag->name,
            'intro' => null,
            'activeTag' => $tag,
            // Tag pages are thin, overlapping taxonomy listings — kept crawlable
            // for navigation but excluded from indexing/sitemap to avoid the
            // thin/duplicate-content pattern the brief explicitly warns against.
            // Categories are curated and limited, so they stay fully indexed.
            'noindex' => true,
            'seoTitle' => $tag->name . ' — مدونة مركز بالديرما',
            'seoDescription' => null,
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)->with(['category', 'author', 'tags'])->first();

        abort_if(! $post, 404);

        // Drafts and future-scheduled posts stay invisible to the public, but
        // a logged-in admin (the same session/guard used for /admin) can open
        // the link to preview it — matching the "preview" action in the admin.
        if (! $post->isPublished() && ! auth()->check()) {
            abort(404);
        }

        $related = $post->relatedPosts(3);

        $navLinks = NavLink::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::first() ?? new SiteSetting();

        $metaTitle = $post->seo_title ?: $post->title;
        $metaDescription = $post->seo_description ?: $post->excerpt;
        $canonicalUrl = $post->canonical_url ?: route('blog.show', $post);
        $authorName = $post->author->name ?? ($settings->seo_title ?? 'فريق مركز بالديرما');
        $siteName = $settings->seo_title ?? 'مركز بالديرما';

        return view('blog.show', [
            'post' => $post,
            'related' => $related,
            'navLinks' => $navLinks,
            'socialLinks' => $socialLinks,
            'settings' => $settings,
            'isPreview' => ! $post->isPublished(),
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'canonicalUrl' => $canonicalUrl,
            'authorName' => $authorName,
            'siteName' => $siteName,
            // Built here (not inline in the .blade.php) and pre-encoded to a
            // JSON string: Laravel's Blade compiler ships a built-in
            // `@context` directive (see CompilesContexts.php) that matches
            // the literal text "@context" anywhere in a template file, even
            // as a plain PHP array-key string with no parentheses following
            // it. Writing '@context' => 'https://schema.org' directly inside
            // a .blade.php file gets silently rewritten into that directive's
            // compiled PHP, corrupting the JSON-LD output. Keeping the array
            // construction here in plain PHP avoids the collision entirely.
            'articleJsonLd' => json_encode($this->articleJsonLd($post, $settings, $metaDescription, $canonicalUrl, $authorName, $siteName), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'breadcrumbJsonLd' => json_encode($this->breadcrumbJsonLd($post, $canonicalUrl), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function articleJsonLd(BlogPost $post, SiteSetting $settings, ?string $metaDescription, string $canonicalUrl, string $authorName, string $siteName): array
    {
        // Same fallback chain as the page's og:image (app-layout.blade.php):
        // the post's own featured image if it has one, else the site's
        // configured default OG image, else omitted entirely — never a bare
        // domain URL, which is not a valid image for the Article schema.
        $image = $post->featured_image
            ? asset($post->featured_image)
            : (! empty($settings->seo_og_image) ? asset($settings->seo_og_image) : null);

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $metaDescription,
            'image' => $image ? [$image] : null,
            'author' => [
                '@type' => 'Person',
                'name' => $authorName,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset($settings->logo_primary ?? 'images/branding/logo-primary.svg'),
                ],
            ],
            'datePublished' => optional($post->published_at)->toAtomString(),
            'dateModified' => $post->updated_at->toAtomString(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $canonicalUrl,
            ],
        ], fn ($value) => $value !== null);
    }

    /**
     * @return array<string, mixed>
     */
    private function breadcrumbJsonLd(BlogPost $post, string $canonicalUrl): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_values(array_filter([
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'الرئيسية', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'المدونة', 'item' => route('blog.index')],
                $post->category ? ['@type' => 'ListItem', 'position' => 3, 'name' => $post->category->name, 'item' => route('blog.category', $post->category)] : null,
                ['@type' => 'ListItem', 'position' => $post->category ? 4 : 3, 'name' => $post->title, 'item' => $canonicalUrl],
            ])),
        ];
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    private function render(LengthAwarePaginator $posts, array $extra): View
    {
        $categories = BlogCategory::where('is_active', true)
            ->whereHas('publishedPosts')
            ->withCount('publishedPosts')
            ->orderBy('sort_order')
            ->get();

        $navLinks = NavLink::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::first() ?? new SiteSetting();

        return view('blog.index', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'activeCategory' => null,
            'activeTag' => null,
            'noindex' => false,
            'navLinks' => $navLinks,
            'socialLinks' => $socialLinks,
            'settings' => $settings,
        ], $extra));
    }
}
