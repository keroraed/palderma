<?php

use App\Models\Faq;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Seeds default FAQ content into the new (empty) faqs table only.
     * Safe for production: the table has no pre-existing admin-authored rows to overwrite.
     */
    public function up(): void
    {
        if (Faq::count() > 0) {
            return;
        }

        $faqs = [
            ['question' => 'ما هي الخدمات التي يقدمها مجمع بالديرما؟', 'answer' => 'نقدم مجموعة متكاملة من خدمات الأمراض الجلدية، علاجات الليزر، الحقن التجميلية، العناية بالبشرة، وزراعة الشعر، على يد نخبة من الأطباء الاستشاريين المعتمدين.'],
            ['question' => 'كم يستغرق الحجز ومتى أحصل على موعد؟', 'answer' => 'يستغرق تعبئة نموذج الحجز أقل من دقيقة، وسيتواصل معك فريق الاستقبال خلال 24 ساعة لتأكيد أقرب موعد متاح يناسبك.'],
            ['question' => 'هل الخدمات مناسبة للجميع؟', 'answer' => 'تختلف كل حالة عن الأخرى، لذلك يقوم الطبيب المختص بتقييم بشرتك أو حالتك أولاً خلال الاستشارة لتحديد العلاج الأنسب لك بأمان.'],
            ['question' => 'كيف أعرف تكلفة الخدمة؟', 'answer' => 'تختلف التكلفة حسب نوع الخدمة وعدد الجلسات المطلوبة. تواصل معنا عبر نموذج الحجز أو الواتساب وسنوضح لك التفاصيل والأسعار بشفافية كاملة.'],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }

    public function down(): void
    {
        Faq::truncate();
    }
};
