<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SiteSetting::query()->update(['logo_primary' => 'images/branding/logo-primary-new.png']);
    }

    public function down(): void
    {
        SiteSetting::query()->update(['logo_primary' => 'images/branding/logo-primary.svg']);
    }
};
