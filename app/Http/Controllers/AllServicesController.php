<?php

namespace App\Http\Controllers;

use App\Models\NavLink;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\View\View;

class AllServicesController extends Controller
{
    public function __invoke(): View
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $navLinks = NavLink::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::first() ?? new SiteSetting();

        return view('all-services', compact('services', 'navLinks', 'socialLinks', 'settings'));
    }
}
