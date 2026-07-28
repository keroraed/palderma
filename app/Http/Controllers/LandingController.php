<?php

namespace App\Http\Controllers;

use App\Models\AboutBlock;
use App\Models\BookingOption;
use App\Models\Certification;
use App\Models\Doctor;
use App\Models\HeroSlide;
use App\Models\NavLink;
use App\Models\Package;
use App\Models\Section;
use App\Models\Service;
use App\Models\ServiceListItem;
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
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
        $stats = Stat::where('is_active', true)->orderBy('sort_order')->get();
        $about = AboutBlock::first();
        $doctors = Doctor::where('is_active', true)->orderBy('sort_order')->get();
        $spotlight = SpotlightBlock::with('doctor')->first();
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $allServices = ServiceListItem::where('is_active', true)->orderBy('sort_order')->get();
        $certifications = Certification::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        $packages = Package::where('is_active', true)->orderBy('sort_order')->get();
        $navLinks = NavLink::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        $bookingOptions = BookingOption::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::first() ?? new SiteSetting();

        return view('landing', compact(
            'sections',
            'heroSlides',
            'stats',
            'about',
            'doctors',
            'spotlight',
            'services',
            'allServices',
            'certifications',
            'testimonials',
            'packages',
            'navLinks',
            'socialLinks',
            'bookingOptions',
            'settings'
        ));
    }
}
