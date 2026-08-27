<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    public function publishedPosts(): HasMany
    {
        return $this->posts()->published();
    }

    /**
     * Generates a unique, URL-safe slug from a name, appending -2, -3, ...
     * on collision. Shared with BlogTag via the same logic shape.
     */
    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        // $language=null keeps the slug in Arabic script instead of Str::slug()'s
        // default (and here, unreadable) phonetic ASCII transliteration.
        $base = Str::slug($name, '-', null);
        $base = $base !== '' ? $base : 'category';
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
