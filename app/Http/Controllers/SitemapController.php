<?php

namespace App\Http\Controllers;

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
