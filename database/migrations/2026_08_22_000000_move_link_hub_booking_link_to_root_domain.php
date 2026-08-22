<?php

use App\Models\LinkHubItem;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The main site moved from services.palderma.com to the root domain.
     * The link hub's "booking page" button was seeded pointing at the old
     * subdomain; repoint it. Old links still work via the redirect in
     * routes/web.php, but the button itself should point at the canonical
     * domain directly.
     */
    public function up(): void
    {
        LinkHubItem::where('url', 'https://services.palderma.com')
            ->update(['url' => 'https://palderma.com']);
    }

    public function down(): void
    {
        LinkHubItem::where('url', 'https://palderma.com')
            ->update(['url' => 'https://services.palderma.com']);
    }
};
