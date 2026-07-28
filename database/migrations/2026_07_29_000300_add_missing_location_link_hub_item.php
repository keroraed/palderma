<?php

use App\Models\LinkHubItem;
use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The original seed migration (2026_07_29_000100) partially failed on
     * production — it inserted the shop/booking/WhatsApp items but errored
     * on the location item because the url column was too narrow for a
     * long real address. That's fixed now (2026_07_29_000200); this adds
     * the missing item without re-running the whole seed (which would have
     * no-op'd given the count-based guard, or duplicated the first three).
     */
    public function up(): void
    {
        if (LinkHubItem::where('icon', 'location_on')->exists()) {
            return;
        }

        $address = SiteSetting::first()?->address ?? 'الرياض، طريق الملك فهد، حي الصحافة';
        $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);

        LinkHubItem::create([
            'label' => 'موقعنا على الخريطة',
            'url' => $mapsUrl,
            'icon' => 'location_on',
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }

    public function down(): void
    {
        LinkHubItem::where('icon', 'location_on')->delete();
    }
};
