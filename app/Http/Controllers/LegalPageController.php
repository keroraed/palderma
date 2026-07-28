<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use App\Models\NavLink;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\View\View;

class LegalPageController extends Controller
{
    public function privacy(): View
    {
        return $this->render('privacy');
    }

    public function terms(): View
    {
        return $this->render('terms');
    }

    private function render(string $key): View
    {
        $page = LegalPage::where('key', $key)->firstOrFail();
        $navLinks = NavLink::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::first() ?? new SiteSetting();

        return view('legal-page', compact('page', 'navLinks', 'socialLinks', 'settings'));
    }
}
