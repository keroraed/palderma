<?php

namespace App\Http\Controllers;

use App\Models\NavLink;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceDetailController extends Controller
{
    public function show(Request $request, string $slug): View|RedirectResponse
    {
        // Support lookup by either unique slug or numeric id fallback
        $service = Service::where('is_active', true)
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('id', is_numeric($slug) ? (int) $slug : 0);
            })
            ->with(['activeSubServices.bookingOption', 'bookingOption'])
            ->firstOrFail();

        // If accessed by ID but slug exists, redirect to canonical slug URL
        if (is_numeric($slug) && !empty($service->slug)) {
            return redirect()->route('services.show', $service->slug, 301);
        }

        $otherServices = Service::where('is_active', true)
            ->where('id', '!=', $service->id)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        // Also fetch all services for the modal if present
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();

        $navLinks = NavLink::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::first() ?? new SiteSetting();

        $metaTitle = $service->meta_title ?: "{$service->title} — مجمع بالديرما الطبي بالرياض";
        $metaDescription = $service->meta_description ?: ($service->description ?: $settings->seo_description);
        $canonicalUrl = route('services.show', $service->slug ?: $service->id);

        // JSON-LD Structured Data for MedicalProcedure / MedicalBusiness Service
        $schemaJsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'MedicalProcedure',
            'name' => $service->title,
            'description' => $service->description,
            'url' => $canonicalUrl,
            'provider' => [
                '@type' => 'MedicalClinic',
                'name' => $settings->site_name ?? 'مجمع بالديرما الطبي',
                'url' => url('/'),
                'telephone' => $settings->phone ?? '+966500000000',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'الرياض',
                    'addressCountry' => 'SA',
                ],
            ],
            'offers' => $service->activeSubServices->map(function ($sub) use ($settings) {
                return [
                    '@type' => 'Offer',
                    'name' => $sub->title,
                    'description' => $sub->description,
                    'availability' => 'https://schema.org/InStock',
                ];
            })->values()->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $breadcrumbJsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'الرئيسية',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'الخدمات',
                    'item' => route('services.all'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $service->title,
                    'item' => $canonicalUrl,
                ],
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return view('services.show', compact(
            'service',
            'otherServices',
            'services',
            'navLinks',
            'socialLinks',
            'settings',
            'metaTitle',
            'metaDescription',
            'canonicalUrl',
            'schemaJsonLd',
            'breadcrumbJsonLd'
        ));
    }
}
