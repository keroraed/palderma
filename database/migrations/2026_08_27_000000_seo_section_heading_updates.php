<?php

use App\Models\Section;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * SEO audit asked for two heading rewrites that were hardcoded in Blade
     * (so the client couldn't change them from the dashboard). The Blade now
     * reads both from the sections table; this seeds the requested copy.
     */
    public function up(): void
    {
        // Section-level heading above the doctor spotlight card. Its previous
        // DB title ("طبيب الشهر المميز") was never rendered — the eyebrow inside
        // the card comes from spotlight_blocks, not from here.
        Section::where('key', 'spotlight')->update([
            'title' => 'نبذة عن طبيب عيادة التجميل',
        ]);

        // Heading + subtitle for the testimonials block nested in the trust
        // section. Deliberately not visible in the landing loop (no @case for
        // this key) — it exists purely so the copy is admin-editable.
        Section::updateOrCreate(
            ['key' => 'testimonials'],
            [
                'title' => 'آراء وتجارب مراجعين أفضل عيادة تجميل في فلسطين',
                'description' => 'تجارب حقيقية لخدمات الجلدية، الليزر، وعلاج البشرة في مركز بالديرما',
                'is_visible' => false,
                'sort_order' => 99,
            ]
        );
    }

    public function down(): void
    {
        Section::where('key', 'spotlight')->update(['title' => 'طبيب الشهر المميز']);
        Section::where('key', 'testimonials')->delete();
    }
};
