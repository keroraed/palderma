<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The client set up GTM-WG35FJWM manually via File Manager (hardcoded
     * in the layout template) while a GTM field didn't exist yet. This
     * moves that same, already-live container ID into the new
     * admin-editable setting so it's no longer hardcoded in a template.
     */
    public function up(): void
    {
        SiteSetting::query()->update(['gtm_id' => 'GTM-WG35FJWM']);
    }

    public function down(): void
    {
        SiteSetting::query()->update(['gtm_id' => null]);
    }
};
