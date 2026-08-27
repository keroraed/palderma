<?php

namespace App\Http\Controllers;

use App\Models\AboutBlock;
use App\Models\BeforeAfterResult;
use App\Models\BlogPost;
use App\Models\BookingOption;
use App\Models\Certification;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\NavLink;
use App\Models\Package;
use App\Models\Section;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\SpotlightBlock;
use App\Models\Stat;
use App\Models\Testimonial;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        $sections = Section::where('is_visible', true)->orderBy('sort_order')->get();
        // Heading/subtitle for the testimonials block nested inside the trust
        // section. Held as its own row so admins can edit it, but never rendered
        // by the landing loop directly (no matching @case).
        $testimonialsSection = Section::where('key', 'testimonials')->first();
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
        $stats = Stat::where('is_active', true)->orderBy('sort_order')->get();
        $about = AboutBlock::first();
        $doctors = Doctor::where('is_active', true)->orderBy('sort_order')->get();
        $spotlight = SpotlightBlock::with('doctor')->first();
        $allActiveServices = Service::where('is_active', true)->orderBy('sort_order')->get();
        $services = $allActiveServices->take(8);
        $totalServicesCount = $allActiveServices->count();
        $certifications = Certification::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        $packages = Package::where('is_active', true)->orderBy('sort_order')->get();
        $navLinks = NavLink::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        $bookingOptions = BookingOption::where('is_active', true)->orderBy('sort_order')->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $beforeAfterResults = BeforeAfterResult::where('is_active', true)->orderBy('sort_order')->get();
        $latestBlogPosts = BlogPost::published()->with('category')->orderByDesc('published_at')->limit(3)->get();
        $settings = SiteSetting::first() ?? new SiteSetting();

        return view('landing', compact(
            'sections',
            'testimonialsSection',
            'heroSlides',
            'stats',
            'about',
            'doctors',
            'spotlight',
            'services',
            'totalServicesCount',
            'certifications',
            'testimonials',
            'packages',
            'navLinks',
            'socialLinks',
            'bookingOptions',
            'faqs',
            'beforeAfterResults',
            'latestBlogPosts',
            'settings'
        ));
    }
}
