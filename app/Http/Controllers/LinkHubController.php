<?php

namespace App\Http\Controllers;

use App\Models\LinkHubItem;
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

        return view('link-hub', compact('items', 'socialLinks', 'settings'));
    }
}
