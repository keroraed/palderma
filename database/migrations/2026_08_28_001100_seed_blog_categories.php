<?php

use App\Models\BlogCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Seeds starting taxonomy only — no articles. Category names mirror the
     * clinic's real service areas (already in the services table), so this
     * is structural/organizational, not fabricated marketing content.
     */
    public function up(): void
    {
        if (BlogCategory::count() > 0) {
            return;
        }

        $categories = [
            ['name' => 'العناية بالبشرة', 'description' => 'نصائح وإرشادات طبية للعناية اليومية بالبشرة وحلول مشاكلها الشائعة.'],
            ['name' => 'حقن التجميل والفيلر', 'description' => 'كل ما يخص حقن الفيلر والبوتوكس وعلاجات التجميل غير الجراحي.'],
            ['name' => 'الليزر وإزالة الشعر', 'description' => 'أحدث تقنيات الليزر للعناية بالبشرة وإزالة الشعر.'],
            ['name' => 'أخبار المركز', 'description' => 'آخر مستجدات وفعاليات مركز بالديرما الطبي.'],
        ];

        foreach ($categories as $i => $category) {
            BlogCategory::create([
                'name' => $category['name'],
                'slug' => BlogCategory::generateUniqueSlug($category['name']),
                'description' => $category['description'],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }

    public function down(): void
    {
        //
    }
};
