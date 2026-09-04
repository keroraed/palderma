<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'gallery',
        'blog_category_id',
        'author_id',
        'status',
        'is_featured',
        'published_at',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'canonical_url',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'gallery' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where('published_at', '<=', now());
    }

    /**
     * Sanitized on read, not on write — so admins can still see and edit the
     * exact HTML they authored, and a future change to the allow-list applies
     * retroactively to existing posts instead of only new ones.
     *
     * Uses the sanitizer Filament itself ships and documents for this exact
     * purpose (Str::sanitizeHtml(), backed by symfony/html-sanitizer's safe
     * element list) — no new dependency, and the same trust boundary already
     * used for RichEditor output elsewhere in Filament.
     */
    public function getSanitizedContentAttribute(): string
    {
        return Str::sanitizeHtml((string) $this->content);
    }

    /**
     * Sanitized article HTML with a stable `id` added to every h2/h3, plus the
     * matching list of headings for the table of contents.
     *
     * Both come from one pass so the anchors in the TOC and the ids in the body
     * can never drift apart. Parsed with DOMDocument rather than a regex,
     * because headings legitimately contain nested markup (<strong>, <a>, …)
     * that a regex would mangle. Headings the admin already gave an id to are
     * left as-is, so hand-written anchors keep working.
     *
     * @return array{html: string, toc: array<int, array{id: string, text: string, level: int}>}
     */
    public function contentWithTableOfContents(): array
    {
        $html = $this->sanitized_content;

        if (trim($html) === '') {
            return ['html' => $html, 'toc' => []];
        }

        $dom = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);

        // loadHTML() assumes ISO-8859-1, so Arabic is encoded to numeric entities
        // first and decoded again after serialising. The implied <html>/<body>
        // wrapper is deliberately left in place — parsing a fragment without it
        // makes libxml mis-nest the tree (every later block ends up inside the
        // first heading) — and stripped by serialising the body's children.
        $loaded = $dom->loadHTML(
            mb_encode_numericentity($html, [0x80, 0x10FFFF, 0, 0x1FFFFF], 'UTF-8'),
            LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $body = $dom->getElementsByTagName('body')->item(0);

        if (! $loaded || ! $body) {
            return ['html' => $html, 'toc' => []];
        }

        $toc = [];
        $used = [];

        // XPath returns nodes in document order, so the TOC comes out already
        // ordered without a second sorting pass.
        foreach ((new \DOMXPath($dom))->query('//h2|//h3') as $heading) {
            $text = trim($heading->textContent);

            if ($text === '') {
                continue;
            }

            $id = $heading->getAttribute('id');

            if ($id === '') {
                $base = Str::slug($text, '-', null) ?: 'section';

                // An id starting with a digit is valid HTML and works for
                // fragment links, but is an invalid CSS selector — so
                // querySelector('#1-x') and :target would both throw on it.
                // Numbered headings ("1. التنظيف") hit this constantly, so
                // prefix just those to keep every id selector-safe.
                if (ctype_digit(substr($base, 0, 1))) {
                    $base = 'sec-' . $base;
                }

                $id = $base;
                $i = 2;

                while (isset($used[$id])) {
                    $id = "{$base}-{$i}";
                    $i++;
                }

                $heading->setAttribute('id', $id);
            }

            $used[$id] = true;

            $toc[] = [
                'id' => $id,
                'text' => $text,
                'level' => (int) substr($heading->nodeName, 1),
            ];
        }

        $this->embedStandaloneLinks($dom);

        $rendered = '';

        foreach ($body->childNodes as $child) {
            $rendered .= $dom->saveHTML($child);
        }

        return [
            'html' => mb_decode_numericentity($rendered, [0x80, 0x10FFFF, 0, 0x1FFFFF], 'UTF-8'),
            'toc' => $toc,
        ];
    }

    /**
     * Turns a paragraph containing nothing but a YouTube/TikTok/Instagram/
     * Facebook link into an embedded player, in place.
     *
     * The admin never writes an <iframe> — the rich editor has no such tool,
     * and the sanitizer strips one on sight regardless. They just paste a
     * plain URL on its own line, the same way WordPress/Ghost auto-embed
     * links. That's the only thing this reads from them: every iframe this
     * method emits is built from a fixed, hardcoded src template per
     * provider, filled in with either a video/post id that's already been
     * validated against a strict per-provider pattern, or (Facebook only,
     * which embeds by original URL rather than by id) a URL whose host has
     * already been checked to be exactly facebook.com. There's no path from
     * admin input to an arbitrary iframe source.
     */
    private function embedStandaloneLinks(\DOMDocument $dom): void
    {
        $paragraphs = iterator_to_array((new \DOMXPath($dom))->query('//p'));

        foreach ($paragraphs as $paragraph) {
            $url = $this->soleParagraphUrl($paragraph);

            if ($url === null) {
                continue;
            }

            $embed = $this->buildEmbed($dom, $url);

            if ($embed !== null) {
                $paragraph->parentNode?->replaceChild($embed, $paragraph);
            }
        }
    }

    /**
     * The URL a paragraph consists of and nothing else — either bare text or
     * a single link, with no other text or elements alongside it — so a URL
     * that's merely mentioned mid-sentence is never mistaken for an embed.
     */
    private function soleParagraphUrl(\DOMElement $paragraph): ?string
    {
        $meaningful = [];

        foreach ($paragraph->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE && trim($child->textContent) === '') {
                continue;
            }

            $meaningful[] = $child;
        }

        if (count($meaningful) !== 1) {
            return null;
        }

        $only = $meaningful[0];

        $candidate = match (true) {
            $only->nodeType === XML_TEXT_NODE => trim($only->textContent),
            $only instanceof \DOMElement && $only->tagName === 'a' => trim($only->getAttribute('href')),
            default => null,
        };

        if (! $candidate || ! filter_var($candidate, FILTER_VALIDATE_URL)) {
            return null;
        }

        return $candidate;
    }

    /**
     * A safe embed <div> for a known provider's URL, or null if the URL
     * isn't one of the handful of patterns recognized below.
     */
    private function buildEmbed(\DOMDocument $dom, string $url): ?\DOMElement
    {
        $host = strtolower((string) (parse_url($url, PHP_URL_HOST) ?? ''));
        $path = (string) (parse_url($url, PHP_URL_PATH) ?? '');
        parse_str((string) (parse_url($url, PHP_URL_QUERY) ?? ''), $query);

        $provider = null;
        $src = null;

        if (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com'], true)) {
            $id = $query['v'] ?? null;

            if (! $id && preg_match('#^/shorts/([\w-]{6,20})#', $path, $m)) {
                $id = $m[1];
            }

            if (is_string($id) && preg_match('/^[\w-]{6,20}$/', $id)) {
                $provider = 'youtube';
                // youtube-nocookie.com: YouTube's own privacy-enhanced embed
                // domain, no tracking cookies until the visitor plays it.
                $src = 'https://www.youtube-nocookie.com/embed/' . $id;
            }
        } elseif ($host === 'youtu.be') {
            $id = ltrim($path, '/');

            if (preg_match('/^[\w-]{6,20}$/', $id)) {
                $provider = 'youtube';
                $src = 'https://www.youtube-nocookie.com/embed/' . $id;
            }
        } elseif (in_array($host, ['tiktok.com', 'www.tiktok.com'], true)) {
            if (preg_match('#/video/(\d+)#', $path, $m)) {
                $provider = 'tiktok';
                $src = 'https://www.tiktok.com/embed/v2/' . $m[1];
            }
        } elseif (in_array($host, ['instagram.com', 'www.instagram.com'], true)) {
            if (preg_match('#^/(p|reel)/([A-Za-z0-9_-]+)#', $path, $m)) {
                $provider = 'instagram';
                $src = 'https://www.instagram.com/' . $m[1] . '/' . $m[2] . '/embed';
            }
        } elseif (in_array($host, ['facebook.com', 'www.facebook.com'], true)) {
            // Facebook's plugin embeds by the original URL (as a query
            // parameter), not by an extracted id — safe here only because
            // $host was already checked above to be exactly facebook.com,
            // so this can never end up pointing the iframe at another site.
            $isVideo = str_contains($path, '/videos/') || str_contains($path, '/watch') || str_contains($path, '/reel/');
            $provider = 'facebook';
            $src = 'https://www.facebook.com/plugins/' . ($isVideo ? 'video.php' : 'post.php')
                . '?href=' . urlencode($url) . '&show_text=false';
        }

        if (! $provider || ! $src) {
            return null;
        }

        $wrapper = $dom->createElement('div');
        $wrapper->setAttribute('class', "blog-embed blog-embed-{$provider}");

        $iframe = $dom->createElement('iframe');
        $iframe->setAttribute('src', $src);
        $iframe->setAttribute('loading', 'lazy');
        $iframe->setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
        // No allow-top-navigation/allow-modals/etc.: the frame can play media
        // and open its own popups (e.g. a "log in to Instagram" link), but
        // can't redirect or take over the parent page.
        $iframe->setAttribute('sandbox', 'allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox allow-presentation');
        $iframe->setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
        $iframe->setAttribute('allowfullscreen', 'true');
        $iframe->setAttribute('title', ucfirst($provider) . ' embed');

        $wrapper->appendChild($iframe);

        return $wrapper;
    }

    /**
     * Rough reading time in minutes, based on an average Arabic reading
     * speed of ~180 words/minute. Words are counted on the plain-text
     * version of the content so HTML tags never inflate the count.
     */
    public function getReadingTimeAttribute(): int
    {
        $text = strip_tags((string) $this->content);
        $words = max(1, str_word_count(preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text) ?? ''));

        return max(1, (int) ceil($words / 180));
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED
            && $this->published_at !== null
            && $this->published_at->lessThanOrEqualTo(Carbon::now());
    }

    /**
     * Related posts, picked by real relevance rather than randomly:
     *   1. same category
     *   2. shared tags
     *   3. most recent published posts (fallback fill only)
     * Never includes the current post; never returns duplicates across steps.
     *
     * @return Collection<int, BlogPost>
     */
    public function relatedPosts(int $limit = 3): Collection
    {
        $related = collect();

        if ($this->blog_category_id) {
            $related = $related->merge(
                static::published()
                    ->where('id', '!=', $this->id)
                    ->where('blog_category_id', $this->blog_category_id)
                    ->orderByDesc('published_at')
                    ->limit($limit)
                    ->get()
            );
        }

        if ($related->count() < $limit) {
            $tagIds = $this->tags()->pluck('blog_tags.id');

            if ($tagIds->isNotEmpty()) {
                $related = $related->merge(
                    static::published()
                        ->where('id', '!=', $this->id)
                        ->whereNotIn('id', $related->pluck('id'))
                        ->whereHas('tags', fn (Builder $q) => $q->whereIn('blog_tags.id', $tagIds))
                        ->orderByDesc('published_at')
                        ->limit($limit - $related->count())
                        ->get()
                );
            }
        }

        if ($related->count() < $limit) {
            $related = $related->merge(
                static::published()
                    ->where('id', '!=', $this->id)
                    ->whereNotIn('id', $related->pluck('id'))
                    ->orderByDesc('published_at')
                    ->limit($limit - $related->count())
                    ->get()
            );
        }

        return $related->take($limit)->values();
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        // $language=null disables Str::slug()'s ASCII transliteration, which
        // otherwise mangles Arabic into unreadable phonetic Latin. This site
        // is Arabic-only, so the slug should stay in Arabic script — that's
        // both more readable and how Arabic-language sites are actually
        // expected to structure URLs for SEO.
        $base = Str::slug($title, '-', null);
        $base = $base !== '' ? $base : 'post';
        $slug = $base;
        $i = 2;

        while (
            static::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
