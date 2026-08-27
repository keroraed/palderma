<?php

use App\Models\NavLink;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Nav: insert "المدونة" right before the "احجز الآن" CTA button, which
        // stays last (a primary CTA belongs at the end of the nav). Skipped
        // entirely if a nav link to /blog already exists (e.g. an admin added
        // one manually), so this never creates a duplicate.
        if (! NavLink::where('href', '/blog')->exists()) {
            NavLink::where('is_cta', true)->increment('sort_order');

            NavLink::create([
                'label' => 'المدونة',
                'href' => '/blog',
                'show_in_header' => true,
                'show_in_footer' => true,
                'is_cta' => false,
                'sort_order' => 5,
                'is_active' => true,
            ]);
        }

        // Homepage teaser section: targeted insert, only shifts the one
        // section (footer) that needs to move to make room — the same safe
        // pattern used for the faq/before_after sections earlier. The
        // section itself auto-hides on the homepage whenever there are no
        // published posts yet (see sections/blog-teaser.blade.php), so it's
        // safe to leave visible by default from day one.
        Section::where('key', 'footer')->update(['sort_order' => 12]);

        Section::firstOrCreate(
            ['key' => 'blog_teaser'],
            [
                'eyebrow' => 'من مدونتنا',
                'title' => 'أحدث المقالات والنصائح الطبية',
                'description' => 'نصائح موثوقة من فريقنا الطبي حول العناية بالبشرة وأحدث تقنيات التجميل والليزر.',
                'is_visible' => true,
                'sort_order' => 11,
            ]
        );
    }

    public function down(): void
    {
        NavLink::where('href', '/blog')->delete();
        Section::where('key', 'blog_teaser')->delete();
        Section::where('key', 'footer')->update(['sort_order' => 11]);
    }
};
