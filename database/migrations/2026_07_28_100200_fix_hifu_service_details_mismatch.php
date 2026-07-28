<?php

use App\Models\Service;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The previous migration (2026_07_28_100100) backfilled service details
     * by position, assuming each of the original 8 services had only been
     * reworded. In production the 8th service was actually swapped to a
     * different treatment (HIFU) rather than reworded, so it ended up with
     * mismatched "general dermatology consultation" detail text. Correct it
     * specifically wherever a service title mentions HIFU/الهايفو.
     */
    public function up(): void
    {
        Service::where('title', 'like', '%HIFU%')
            ->orWhere('title', 'like', '%هايفو%')
            ->update([
                'details' => 'تقنية الهايفو (HIFU) تستخدم الموجات فوق الصوتية المركزة عالية الشدة للوصول إلى الطبقات العميقة من الجلد وتحفيز إنتاج الكولاجين، مما يمنح شداً ملحوظاً للوجه والرقبة دون أي تدخل جراحي.',
                'features' => [
                    'شد الوجه والرقبة والجفون دون جراحة',
                    'تحفيز إنتاج الكولاجين في الطبقات العميقة للجلد',
                    'جلسة واحدة بدون فترة تعافٍ',
                    'نتائج تتحسن تدريجياً خلال 2-3 أشهر',
                ],
                'details_note' => 'تدوم نتائج الهايفو عادة من 12 إلى 18 شهراً، ويمكن تكرار الجلسة حسب توصية الطبيب المختص.',
            ]);
    }

    public function down(): void
    {
        // Intentionally left as-is; the prior migration's down() already
        // clears details/features/details_note for all services.
    }
};
