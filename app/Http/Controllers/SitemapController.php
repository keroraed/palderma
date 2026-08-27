<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\LegalPage;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Dynamic XML sitemap. Generated from the database rather than hand-written
     * so newly added services/legal pages are picked up without a deploy.
     */
    public function __invoke(): Response
    {
        $urls = [];

        $urls[] = [
            'loc' => url('/'),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ];

        $urls[] = [
            'loc' => route('services.all'),
            'lastmod' => optional(Service::max('updated_at'))
                ? \Illuminate\Support\Carbon::parse(Service::max('updated_at'))->toAtomString()
                : null,
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ];

        $urls[] = [
            'loc' => route('blog.index'),
            'lastmod' => optional(BlogPost::published()->max('published_at'))
                ? \Illuminate\Support\Carbon::parse(BlogPost::published()->max('published_at'))->toAtomString()
                : null,
            'changefreq' => 'daily',
            'priority' => '0.8',
        ];

        // Only published posts, never drafts or soft-deleted rows — the
        // `published()` scope already enforces both status and published_at.
        foreach (BlogPost::published()->orderByDesc('published_at')->get() as $post) {
            $urls[] = [
                'loc' => route('blog.show', $post),
                'lastmod' => $post->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        // Category pages carry real, non-duplicate content value (a distinct
        // filtered list) only once they actually have published posts in them.
        foreach (BlogCategory::where('is_active', true)->whereHas('publishedPosts')->get() as $category) {
            $urls[] = [
                'loc' => route('blog.category', $category),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ];
        }

        foreach (LegalPage::all() as $page) {
            $route = $page->key === 'privacy' ? 'legal.privacy' : ($page->key === 'terms' ? 'legal.terms' : null);
            if (! $route) {
                continue;
            }

            $urls[] = [
                'loc' => route($route),
                'lastmod' => optional($page->updated_at)->toAtomString(),
                'changefreq' => 'yearly',
                'priority' => '0.3',
            ];
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
