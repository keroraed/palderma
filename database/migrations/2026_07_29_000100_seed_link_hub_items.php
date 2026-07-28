<?php

use App\Models\LinkHubItem;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (LinkHubItem::count() > 0) {
            return;
        }

        $whatsappUrl = SocialLink::where('platform', 'whatsapp')->value('url') ?? 'https://wa.me/966500000000';
        $address = SiteSetting::first()?->address ?? 'الرياض، طريق الملك فهد، حي الصحافة';
        $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);

        $items = [
            ['label' => 'زوروا متجرنا الإلكتروني', 'url' => 'https://palderma.com/shop', 'icon' => 'storefront', 'sort_order' => 0],
            ['label' => 'احجزي موعدك الآن', 'url' => 'https://services.palderma.com', 'icon' => 'calendar_month', 'sort_order' => 1],
            ['label' => 'تواصل معنا عبر واتساب', 'url' => $whatsappUrl, 'icon' => 'call', 'sort_order' => 2],
            ['label' => 'موقعنا على الخريطة', 'url' => $mapsUrl, 'icon' => 'location_on', 'sort_order' => 3],
        ];

        foreach ($items as $item) {
            LinkHubItem::create(array_merge($item, ['is_active' => true]));
        }
    }

    public function down(): void
    {
        LinkHubItem::truncate();
    }
};
