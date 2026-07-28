<?php

use App\Models\Section;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Safe, targeted reorder — does NOT re-run the full seeder, so any admin
     * edits to existing section titles/descriptions are left untouched.
     */
    public function up(): void
    {
        Section::where('key', 'packages')->update(['sort_order' => 8]);
        Section::where('key', 'booking')->update(['sort_order' => 9]);
        Section::where('key', 'footer')->update(['sort_order' => 11]);

        Section::firstOrCreate(
            ['key' => 'before_after'],
            [
                'eyebrow' => null,
                'title' => 'نتائج بالديرما تتكلم عن نفسها، شوف بنفسك',
                'description' => 'كل هذه النتائج تحت يديك مع أفضل الأطباء والمتخصصين بالمملكة',
                'is_visible' => true,
                'sort_order' => 7,
            ]
        );

        Section::firstOrCreate(
            ['key' => 'faq'],
            [
                'eyebrow' => 'لديك سؤال؟',
                'title' => 'الأسئلة الشائعة',
                'description' => null,
                'is_visible' => true,
                'sort_order' => 10,
            ]
        );
    }

    public function down(): void
    {
        Section::where('key', 'packages')->update(['sort_order' => 7]);
        Section::where('key', 'booking')->update(['sort_order' => 8]);
        Section::where('key', 'footer')->update(['sort_order' => 9]);

        Section::where('key', 'before_after')->delete();
        Section::where('key', 'faq')->delete();
    }
};
