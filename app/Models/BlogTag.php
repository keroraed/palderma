<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag');
    }

    public function publishedPosts(): BelongsToMany
    {
        return $this->posts()->published();
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        // $language=null keeps the slug in Arabic script instead of Str::slug()'s
        // default (and here, unreadable) phonetic ASCII transliteration.
        $base = Str::slug($name, '-', null);
        $base = $base !== '' ? $base : 'tag';
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
