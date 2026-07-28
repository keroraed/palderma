<?php

use App\Models\Certification;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The 4 original certifications were placeholder text with no real
     * document behind them. The clinic supplied 6 real certificate images
     * to replace them outright — a deliberate one-time content swap, not a
     * targeted patch, per explicit client request.
     */
    public function up(): void
    {
        Certification::truncate();

        $certs = [
            ['icon' => 'workspace_premium', 'image' => 'images/certificates/certificate-4.png', 'title' => 'رفع الكفاءة في الطب التجميلي الإجرائي', 'subtitle' => 'الجامعة الأردنية - مركز الاستشارات والتدريب، عمّان'],
            ['icon' => 'verified', 'image' => 'images/certificates/certificate-3.png', 'title' => 'دورة متقدمة في الحقن التجميلي الطبي (Hands-on)', 'subtitle' => 'Liverpool College for International Studies'],
            ['icon' => 'badge', 'image' => 'images/certificates/certificate-2.webp', 'title' => 'دورة معتمدة في تقنية خيوط الشد PDO Threads', 'subtitle' => 'Liverpool College for International Studies'],
            ['icon' => 'science', 'image' => 'images/certificates/certificate-5.png', 'title' => 'دورة متقدمة في تركيبات مستحضرات التجميل', 'subtitle' => 'الشبكة المصرية لدعم الصيادلة (EPSN)'],
            ['icon' => 'public', 'image' => 'images/certificates/certificate-6.png', 'title' => 'حضور المؤتمر العالمي للطب التجديدي', 'subtitle' => 'Global Regenerative Academy - دبي، الإمارات'],
            ['icon' => 'health_and_safety', 'image' => 'images/certificates/certificate-7.png', 'title' => 'اعتماد فن حقن الفيلر (Art of Filler Injection)', 'subtitle' => 'الجمعية الأمريكية للتعليم الطبي المستمر (AACME)'],
        ];

        foreach ($certs as $i => $cert) {
            Certification::create([
                'icon' => $cert['icon'],
                'image' => $cert['image'],
                'title' => $cert['title'],
                'subtitle' => $cert['subtitle'],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }

    public function down(): void
    {
        Certification::truncate();
    }
};
