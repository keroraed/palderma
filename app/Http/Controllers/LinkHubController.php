<?php

namespace App\Http\Controllers;

use App\Models\LinkHubItem;
use App\Models\LinkHubSetting;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\View\View;

class LinkHubController extends Controller
{
    public function __invoke(): View
    {
        $items = LinkHubItem::where('is_active', true)->orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)
            ->where('platform', '!=', 'whatsapp')
            ->orderBy('sort_order')
            ->get();
        $settings = SiteSetting::first() ?? new SiteSetting();
        $hubSettings = LinkHubSetting::first() ?? new LinkHubSetting([
            'logo' => 'images/branding/logo-white-new.svg',
            'title' => 'مجمع بالديرما الطبي',
            'tagline' => 'عيادة الجلدية والتجميل والليزر — كل ما تحتاجينه في مكان واحد',
        ]);

        return view('link-hub', compact('items', 'socialLinks', 'settings', 'hubSettings'));
    }
}
