<?php

use App\Models\Testimonial;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Adds 3 more testimonials alongside the original 3 (6 total), matching
     * the client's request. Only appends — never truncates — so any admin
     * edits to the existing testimonials are preserved.
     */
    public function up(): void
    {
        $newOnes = [
            ['name' => 'سارة القحطاني', 'service_label' => 'شد الوجه بالمورفيوس', 'rating' => 5, 'quote' => 'كنت خايفة من الألم بس الجلسة كانت مريحة جداً والفريق متعاون من أول دقيقة. بشرتي صارت مشدودة وأكثر إشراقاً.', 'avatar_initial' => 'س'],
            ['name' => 'خالد العتيبي', 'service_label' => 'علاج تساقط الشعر بالبلازما', 'rating' => 5, 'quote' => 'بعد عدة جلسات بلازما لاحظت فرق واضح في كثافة الشعر. الدكتور واضح جداً في شرح الخطة والنتائج المتوقعة.', 'avatar_initial' => 'خ'],
            ['name' => 'ريم الدوسري', 'service_label' => 'نحت الجسم وتنسيق القوام', 'rating' => 5, 'quote' => 'مركز محترف وأجهزة حديثة، وأهم شي المتابعة بعد الجلسات. أنصح فيه أي وحدة تبي نتيجة مضمونة وآمنة.', 'avatar_initial' => 'ر'],
        ];

        $nextSortOrder = ((int) Testimonial::max('sort_order')) + 1;

        foreach ($newOnes as $i => $t) {
            if (Testimonial::where('name', $t['name'])->where('quote', $t['quote'])->exists()) {
                continue;
            }

            Testimonial::create(array_merge($t, [
                'sort_order' => $nextSortOrder + $i,
                'is_active' => true,
            ]));
        }
    }

    public function down(): void
    {
        Testimonial::where('name', 'سارة القحطاني')->delete();
        Testimonial::where('name', 'خالد العتيبي')->delete();
        Testimonial::where('name', 'ريم الدوسري')->delete();
    }
};
