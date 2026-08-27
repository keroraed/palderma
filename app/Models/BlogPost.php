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
