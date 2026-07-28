<?php

use App\Models\LinkHubSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        LinkHubSetting::firstOrCreate([], [
            'logo' => 'images/branding/logo-white-new.svg',
            'title' => 'مجمع بالديرما الطبي',
            'tagline' => 'عيادة الجلدية والتجميل والليزر — كل ما تحتاجينه في مكان واحد',
        ]);
    }

    public function down(): void
    {
        LinkHubSetting::truncate();
    }
};
