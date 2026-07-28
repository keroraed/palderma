<?php

namespace Database\Seeders;

use App\Models\AboutBlock;
use App\Models\BookingOption;
use App\Models\Certification;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\LegalPage;
use App\Models\NavLink;
use App\Models\Package;
use App\Models\Section;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\SpotlightBlock;
use App\Models\Stat;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LandingContentSeeder extends Seeder
{
    public function run(): void
    {
        // MySQL/MariaDB (unlike SQLite) refuses to truncate a table that's
        // still referenced by a foreign key (e.g. spotlight_blocks.doctor_id
        // -> doctors.id truncated in that order below). Disable checks for
        // the duration of this idempotent re-seed.
        Schema::disableForeignKeyConstraints();

        // 1. Sections
        $sections = [
            ['key' => 'hero', 'title' => 'الهيرو الرئيسي', 'is_visible' => true, 'sort_order' => 0],
            ['key' => 'stats', 'title' => 'شريط الإحصائيات', 'is_visible' => true, 'sort_order' => 1],
            ['key' => 'about', 'eyebrow' => 'من نحن', 'title' => 'عناية جلدية متكاملة تجمع بين الخبرة الطبية ولمسة التجميل', 'description' => 'تأسّس مركز بالديرما ليكون وجهةً موثوقة للعناية بصحة البشرة وجمالها في المملكة.', 'is_visible' => true, 'sort_order' => 2],
            ['key' => 'doctors', 'eyebrow' => 'فريقنا الطبي', 'title' => 'نخبة من الأطباء والاستشاريين المعتمدين', 'description' => 'كوادر طبية متميزة بحاصلين على أرفع الشهادات العالمية والخبرات الممتدة.', 'is_visible' => true, 'sort_order' => 3],
            ['key' => 'spotlight', 'title' => 'طبيب الشهر المميز', 'is_visible' => true, 'sort_order' => 4],
            ['key' => 'services', 'eyebrow' => 'خدماتنا المميزة', 'title' => 'حلول علاجية وتجميلية متكاملة لبشرة نضرة وقوام متناسق', 'description' => 'نستخدم أحدث التقنيات المعتمدة من هيئة الغذاء والدواء لضمان نتائج آمنة وملموسة.', 'is_visible' => true, 'sort_order' => 5],
            ['key' => 'trust', 'eyebrow' => 'اعتماداتنا وآراء مراجعينا', 'title' => 'ثقتكم هي رصيدنا وأساس تميزنا', 'description' => 'نلتزم بأعلى معايير الجودة والسلامة المعتمدة محلياً ودولياً.', 'is_visible' => true, 'sort_order' => 6],
            ['key' => 'before_after', 'title' => 'نتائج بالديرما تتكلم عن نفسها، شوف بنفسك', 'description' => 'كل هذه النتائج تحت يديك مع أفضل الأطباء والمتخصصين بالمملكة', 'is_visible' => true, 'sort_order' => 7],
            ['key' => 'packages', 'eyebrow' => 'العروض والباقات', 'title' => 'باقات مميزة مصممة لتلبية احتياجاتك بأسعار تنافسية', 'description' => 'اختر الباقة المناسبة واستمتع بعناية فائقة وتوفير حقيقي.', 'is_visible' => true, 'sort_order' => 8],
            ['key' => 'booking', 'eyebrow' => 'احجز موعدك', 'title' => 'ابدأي رحلة العناية ببشرتكِ وجسمكِ اليوم', 'description' => 'سجلي بياناتك وسيقوم فريق الخدمة بالتواصل معكِ فوراً لتأكيد الموعد المناسب.', 'is_visible' => true, 'sort_order' => 9],
            ['key' => 'faq', 'eyebrow' => 'لديك سؤال؟', 'title' => 'الأسئلة الشائعة', 'is_visible' => true, 'sort_order' => 10],
            ['key' => 'footer', 'title' => 'تذييل الصفحة', 'is_visible' => true, 'sort_order' => 11],
        ];
        foreach ($sections as $s) {
            Section::updateOrCreate(['key' => $s['key']], $s);
        }

        // 2. Hero Slides
        HeroSlide::truncate();
        HeroSlide::create([
            'tag' => 'عيادة جلدية وتجميل متخصصة',
            'title' => 'جمالكِ وصحة بشرتكِ بأيدي نخبة استشاريي الجلدية والتجميل',
            'subtitle' => 'نقدم في بالديرما أحدث حلول العناية بالبشرة، الليزر، وتنسيق القوام بأساليب طبية آمنة وتقنيات عالمية معتمدة.',
            'image_desktop' => 'images/Hero3.webp',
            'image_mobile' => 'images/Hero-mob-3.webp',
            'sort_order' => 0,
            'is_active' => true,
        ]);
        HeroSlide::create([
            'tag' => 'تقنيات ليزر معتمدة',
            'title' => 'أحدث أجهزة إزالة الشعر والنضارة بدون ألم',
            'subtitle' => 'أجهزة كانديلا، كلاريتي وجنتل ليز برول بخبرة كوادر طبية متميزة لنتائج يدوم أثرها.',
            'image_desktop' => 'images/Hero1.webp',
            'image_mobile' => 'images/Hero-mob-1.webp',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        HeroSlide::create([
            'tag' => 'استشاريون معتمدون',
            'title' => 'خبرات طبية عالمية تضمن لك الرعاية المثالية',
            'subtitle' => 'فريقنا من الاستشاريين والأطباء حائزون على البورد السعودي والأوربي في الأمراض الجلدية.',
            'image_desktop' => 'images/Hero2.webp',
            'image_mobile' => 'images/Hero-mob-2.webp',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 3. Stats
        Stat::truncate();
        Stat::create(['value' => '+15', 'label' => 'عاماً من الخبرة', 'sort_order' => 0, 'is_active' => true]);
        Stat::create(['value' => '+80k', 'label' => 'مريض سعيد', 'sort_order' => 1, 'is_active' => true]);
        Stat::create(['value' => '+20', 'label' => 'طبيباً واستشارياً', 'sort_order' => 2, 'is_active' => true]);
        Stat::create(['value' => '4.9', 'label' => 'تقييم المرضى', 'sort_order' => 3, 'is_active' => true]);

        // 4. Doctors
        Doctor::truncate();
        $doc1 = Doctor::create([
            'name' => 'د. عبد الله الهاجري',
            'specialty' => 'استشاري الأمراض الجلدية وتجميل الوجه',
            'image' => 'images/dr1.webp',
            'bio' => 'خبرة تتجاوز 16 عاماً في علاج الأمراض الجلدية المستعصية وحقن الفيلر والبوتوكس وخيوط الشد.',
            'experience_display' => '+16',
            'patients_display' => '+12k',
            'qualifications' => ['بورد كندي في الجلدية والتجميل', 'عضو الجمعية الأمريكية لطب الجلد', 'خبير حقن التجميل الشامل'],
            'sort_order' => 0,
            'is_active' => true,
        ]);
        Doctor::create([
            'name' => 'د. خالد المطيري',
            'specialty' => 'استشاري جراحة التجميل ونحت القوام',
            'image' => 'images/dr2.webp',
            'bio' => 'متخصص في عمليات نحت الجسم، شفط الدهون، وتنسيق القوام بأحدث التقنيات الدقيقة.',
            'experience_display' => '+14',
            'patients_display' => '+9k',
            'qualifications' => ['البورد الفرنسي في جراحة التجميل', 'عضو الجمعية الدولية لجراحة التجميل ISAPS'],
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Doctor::create([
            'name' => 'د. سارة الشهري',
            'specialty' => 'أخصائية أولى ليزر وعناية بالبشرة',
            'image' => 'images/dr1.webp',
            'bio' => 'متخصصة في علاجات النضارة، التصبغات، وحب الشباب باستخدام التقنيات المدمجة.',
            'experience_display' => '+9',
            'patients_display' => '+7k',
            'qualifications' => ['ماجستير الأمراض الجلدية والتجميل', 'زمالة أجهزة الليزر الطبية'],
            'sort_order' => 2,
            'is_active' => true,
        ]);
        Doctor::create([
            'name' => 'د. نورة العتيبي',
            'specialty' => 'استشارية الجلدية وتجميل الأطفال',
            'image' => 'images/dr2.webp',
            'bio' => 'خبرة واسعة في علاج أكزيما الأطفال وحمات الوجه ولحميات الجلد بأمان تام.',
            'experience_display' => '+12',
            'patients_display' => '+10k',
            'qualifications' => ['البورد السعودي في الأمراض الجلدية', 'زمالة طب جلدية الأطفال'],
            'sort_order' => 3,
            'is_active' => true,
        ]);
        Doctor::create([
            'name' => 'د. فيصل الزهراني',
            'specialty' => 'أخصائي زراعة الشعر وعلاج التساقط',
            'image' => 'images/dr1.webp',
            'bio' => 'رائد في تقنيات زراعة الشعر السفير وحقن البلازما والميزوثيرابي المقوى.',
            'experience_display' => '+10',
            'patients_display' => '+6k',
            'qualifications' => ['عضو الجمعية الدولية لزراعة الشعر ISHRS', 'دبلوم التجميل الطبي من بريطانيا'],
            'sort_order' => 4,
            'is_active' => true,
        ]);
        Doctor::create([
            'name' => 'د. ريم الدوسري',
            'specialty' => 'أخصائية التجميل غير الجراحي والنضارة',
            'image' => 'images/dr2.webp',
            'bio' => 'خبيرة في تصميم الابتسامة وعلاجات الهيدرافيدشال والمورفيوس للنضارة الفائقة.',
            'experience_display' => '+8',
            'patients_display' => '+5k',
            'qualifications' => ['شهادة التجميل الطبي المتقدم - إسبانيا', 'عضو الأكاديمية الأوروبية للتجميل'],
            'sort_order' => 5,
            'is_active' => true,
        ]);

        // 5. Services
        Service::truncate();
        $svcs = [
            ['title' => 'إزالة الشعر بالليزر', 'description' => 'جلسات ليزر بأحدث أجهزة الجنتل ليز وجنتل ماكس برو مع تبريد ديناميكي لراحة تامة.', 'details' => 'نستخدم أحدث أجهزة الليزر لإزالة الشعر بشكل آمن وفعال لجميع أنواع البشرة، مع نتائج تدوم طويلاً وأقل شعور بالألم بفضل تقنية التبريد الديناميكي.', 'features' => ['مناسب لجميع مناطق الجسم والوجه', 'تقنيات جنتل ليز وجنتل ماكس برو', 'تبريد ديناميكي لراحة تامة أثناء الجلسة', 'نتائج تدوم طويلاً مع تقليل نمو الشعر تدريجياً'], 'details_note' => 'يحدد الطبيب عدد الجلسات المطلوبة بناءً على نوع ولون الشعر وطبيعة البشرة، مع متابعة دقيقة لضمان أفضل النتائج.', 'icon_type' => 'material', 'icon_value' => 'local_fire_department', 'sort_order' => 0],
            ['title' => 'حقن الفيلر والبوتوكس', 'description' => 'إعادة تعبئة التجاعيد وتحديد ملامح الوجه بطريقة طبيعية وأنيقة بأيدي استشاريين.', 'details' => 'حلول حقن آمنة ومعتمدة لإعادة النضارة وتحديد ملامح الوجه بشكل طبيعي، على يد استشاريين متخصصين في التجميل غير الجراحي.', 'features' => ['تعبئة التجاعيد وخطوط التعبير', 'تحديد ملامح الوجه ونفخ الشفايف', 'علاج التعرق الزائد والصداع النصفي بالبوتوكس', 'مواد فيلر معتمدة من هيئة الغذاء والدواء'], 'details_note' => 'يتم تخصيص كل حالة بعد استشارة مع الطبيب لتحديد الكمية والمناطق المناسبة لتحقيق مظهر طبيعي متناسق.', 'icon_type' => 'material', 'icon_value' => 'vaccines', 'sort_order' => 1],
            ['title' => 'علاجات النضارة والهيدرافيدشال', 'description' => 'تنظيف عميق للبشرة وتقشير ألماسي مع ضخ السيرومات المغذية لاستعادة الحيوية.', 'details' => 'تنظيف عميق للبشرة وتقشير ألماسي مدمج مع ضخ السيرومات المغذية لاستعادة النضارة والحيوية من الجلسة الأولى.', 'features' => ['تنظيف عميق للمسام وإزالة الرؤوس السوداء', 'تقشير ألماسي غير مؤلم', 'ضخ سيرومات مغذية ومضادة للأكسدة', 'مناسبة لجميع أنواع البشرة'], 'details_note' => 'ينصح بجلسات دورية كل 3-4 أسابيع للحفاظ على إشراقة البشرة ونضارتها.', 'icon_type' => 'material', 'icon_value' => 'auto_awesome', 'sort_order' => 2],
            ['title' => 'علاج التصبغات وآثار الأكار', 'description' => 'تقنيات الفراكشنال ليزر والتقشير الكيميائي المدمج لتوحيد لون البشرة ونقائها.', 'details' => 'تقنيات الفراكشنال ليزر والتقشير الكيميائي المدمج لتوحيد لون البشرة وعلاج آثار حب الشباب والتصبغات بأمان.', 'features' => ['فراكشنال ليزر لتحفيز تجديد الخلايا', 'تقشير كيميائي متدرج حسب حساسية البشرة', 'علاج آثار الكلف وحروق الشمس', 'توحيد لون البشرة وتقليل المسام الواسعة'], 'details_note' => 'تختلف مدة العلاج حسب شدة التصبغات، ويضع الطبيب خطة علاجية متكاملة تناسب حالتك.', 'icon_type' => 'material', 'icon_value' => 'grain', 'sort_order' => 3],
            ['title' => 'شد الوجه بالمورفيوس والخيوط', 'description' => 'شد الجلد وتحفيز الكولاجين بالترددات الراديوية بدون تدخل جراحي أو فترة تعاف طويلة.', 'details' => 'شد الجلد وتحفيز إنتاج الكولاجين بتقنية الترددات الراديوية الدقيقة (المورفيوس) أو الخيوط الطبية، دون تدخل جراحي أو فترة تعافٍ طويلة.', 'features' => ['تحفيز الكولاجين بالترددات الراديوية الدقيقة', 'شد فوري ونتائج تتحسن تدريجياً', 'بدون جراحة أو فترة نقاهة', 'مناسب لشد الوجه والرقبة'], 'details_note' => 'تظهر النتائج الأولية بعد الجلسة مباشرة، وتستمر في التحسن خلال الأشهر التالية مع تجدد الكولاجين الطبيعي.', 'icon_type' => 'material', 'icon_value' => 'face_retouching_natural', 'sort_order' => 4],
            ['title' => 'نحت الجسم وتنسيق القوام', 'description' => 'تكسير الدهون الموضعية وتقنيات الكافيتيشن للوصول للقوام المتناسق المثالي.', 'details' => 'تكسير الدهون الموضعية العنيدة وتقنيات الكافيتيشن للوصول إلى القوام المتناسق المطلوب دون جراحة.', 'features' => ['تكسير الدهون الموضعية بتقنية الكافيتيشن', 'شد الترهلات وتحسين مظهر الجلد', 'جلسات آمنة وغير مؤلمة', 'مناسبة لمناطق البطن والأرداف والخصر'], 'details_note' => 'يُنصح بمرافقة الجلسات بنظام غذائي متوازن للحصول على أفضل وأسرع النتائج.', 'icon_type' => 'material', 'icon_value' => 'accessibility_new', 'sort_order' => 5],
            ['title' => 'علاج تساقط الشعر والبلازما', 'description' => 'حقن البلازما الغنية بالصفائح الدموية والميزوثيرابي لإيقاف التساقط وتكثيف الشعر.', 'details' => 'حقن البلازما الغنية بالصفائح الدموية (PRP) والميزوثيرابي لتحفيز بصيلات الشعر وإيقاف التساقط وتكثيف الشعر بشكل طبيعي.', 'features' => ['حقن البلازما الغنية بالصفائح الدموية PRP', 'ميزوثيرابي لتغذية فروة الرأس', 'تحفيز بصيلات الشعر الخاملة', 'مناسب للرجال والنساء'], 'details_note' => 'تُجرى الجلسات على فترات متباعدة حسب خطة الطبيب، مع نتائج ملحوظة عادة بعد 3 إلى 4 جلسات.', 'icon_type' => 'material', 'icon_value' => 'spa', 'sort_order' => 6],
            ['title' => 'الاستشارات الجلدية الطبية', 'description' => 'تشخيص دقيق وعلاج متخصص لحب الشباب، الأكزيما، الصدفية، وحساسية الجلد.', 'details' => 'تشخيص دقيق وعلاج متخصص لمختلف المشاكل الجلدية من حب الشباب والأكزيما والصدفية إلى حساسية الجلد، على يد استشاريين جلدية معتمدين.', 'features' => ['تشخيص شامل لحالة البشرة', 'علاج حب الشباب وآثاره', 'علاج الأكزيما والصدفية وحساسية الجلد', 'خطة علاجية مخصصة لكل حالة'], 'details_note' => 'نوفر متابعة دورية لضمان استجابة العلاج وتعديل الخطة عند الحاجة.', 'icon_type' => 'material', 'icon_value' => 'medical_services', 'sort_order' => 7],
        ];
        foreach ($svcs as $s) {
            Service::create(array_merge($s, ['is_active' => true]));
        }

        // 6. Certifications (real certificates supplied by the clinic)
        Certification::truncate();
        Certification::create(['icon' => 'workspace_premium', 'image' => 'images/certificates/certificate-4.png', 'title' => 'رفع الكفاءة في الطب التجميلي الإجرائي', 'subtitle' => 'الجامعة الأردنية - مركز الاستشارات والتدريب، عمّان', 'sort_order' => 0, 'is_active' => true]);
        Certification::create(['icon' => 'verified', 'image' => 'images/certificates/certificate-3.png', 'title' => 'دورة متقدمة في الحقن التجميلي الطبي (Hands-on)', 'subtitle' => 'Liverpool College for International Studies', 'sort_order' => 1, 'is_active' => true]);
        Certification::create(['icon' => 'badge', 'image' => 'images/certificates/certificate-2.webp', 'title' => 'دورة معتمدة في تقنية خيوط الشد PDO Threads', 'subtitle' => 'Liverpool College for International Studies', 'sort_order' => 2, 'is_active' => true]);
        Certification::create(['icon' => 'science', 'image' => 'images/certificates/certificate-5.png', 'title' => 'دورة متقدمة في تركيبات مستحضرات التجميل', 'subtitle' => 'الشبكة المصرية لدعم الصيادلة (EPSN)', 'sort_order' => 3, 'is_active' => true]);
        Certification::create(['icon' => 'public', 'image' => 'images/certificates/certificate-6.png', 'title' => 'حضور المؤتمر العالمي للطب التجديدي', 'subtitle' => 'Global Regenerative Academy - دبي، الإمارات', 'sort_order' => 4, 'is_active' => true]);
        Certification::create(['icon' => 'health_and_safety', 'image' => 'images/certificates/certificate-7.png', 'title' => 'اعتماد فن حقن الفيلر (Art of Filler Injection)', 'subtitle' => 'الجمعية الأمريكية للتعليم الطبي المستمر (AACME)', 'sort_order' => 5, 'is_active' => true]);

        // 7. Testimonials
        Testimonial::truncate();
        Testimonial::create(['name' => 'منى السبيعي', 'service_label' => 'جلسات إزالة الشعر بالليزر', 'rating' => 5, 'quote' => 'تجربة ممتازة جداً، العيادة قمة في النظافة والتعقيم، ود. سارة خلوقة ومتمكنة. النتائج ظهرت من أول جلسة والحمد لله.', 'avatar_initial' => 'م', 'sort_order' => 0, 'is_active' => true]);
        Testimonial::create(['name' => 'أحمد الغامدي', 'service_label' => 'علاج آثار حب الشباب', 'rating' => 5, 'quote' => 'راجعت د. عبد الله الهاجري لعلاج ندبات القديمة بالفراكشنال. الفرق خيالي والبشرة تحسنت بشكل كبير. شكراً لكادر بالديرما.', 'avatar_initial' => 'أ', 'sort_order' => 1, 'is_active' => true]);
        Testimonial::create(['name' => 'نورة المطيري', 'service_label' => 'حقن الفيلر والنضارة', 'rating' => 5, 'quote' => 'النتيجة طبيعية جداً وبدون أي تكتلات. د. ريم فهمت طلبي بالضبط واعطتني النظارة اللي كنت احلم فيها. اعتمدت العيادة خلاص.', 'avatar_initial' => 'ن', 'sort_order' => 2, 'is_active' => true]);
        Testimonial::create(['name' => 'سارة القحطاني', 'service_label' => 'شد الوجه بالمورفيوس', 'rating' => 5, 'quote' => 'كنت خايفة من الألم بس الجلسة كانت مريحة جداً والفريق متعاون من أول دقيقة. بشرتي صارت مشدودة وأكثر إشراقاً.', 'avatar_initial' => 'س', 'sort_order' => 3, 'is_active' => true]);
        Testimonial::create(['name' => 'خالد العتيبي', 'service_label' => 'علاج تساقط الشعر بالبلازما', 'rating' => 5, 'quote' => 'بعد عدة جلسات بلازما لاحظت فرق واضح في كثافة الشعر. الدكتور واضح جداً في شرح الخطة والنتائج المتوقعة.', 'avatar_initial' => 'خ', 'sort_order' => 4, 'is_active' => true]);
        Testimonial::create(['name' => 'ريم الدوسري', 'service_label' => 'نحت الجسم وتنسيق القوام', 'rating' => 5, 'quote' => 'مركز محترف وأجهزة حديثة، وأهم شي المتابعة بعد الجلسات. أنصح فيه أي وحدة تبي نتيجة مضمونة وآمنة.', 'avatar_initial' => 'ر', 'sort_order' => 5, 'is_active' => true]);

        // 8. Packages
        Package::truncate();
        Package::create([
            'name' => 'باقة النضارة الملكية',
            'tagline' => 'لإطلالة مشرفة ومشرقة في المناسبات',
            'price' => 799.00,
            'currency' => 'ريال',
            'is_featured' => false,
            'featured_badge' => null,
            'features' => [
                ['text' => 'جلسة هيدرافيدشال تنظيف عميق', 'is_included' => true],
                ['text' => 'ماسك الذهب وتغذية السيروم', 'is_included' => true],
                ['text' => 'حقن ميزو نضارة للوجه', 'is_included' => true],
                ['text' => 'جلسة رتوش مجانية خلال 14 يوم', 'is_included' => true],
                ['text' => 'جلسة ليزر كربوني للظهر', 'is_included' => false],
            ],
            'cta_label' => 'احجز هذه الباقة',
            'cta_href' => '#book',
            'sort_order' => 0,
            'is_active' => true,
        ]);
        Package::create([
            'name' => 'باقة الليزر الشاملة',
            'tagline' => 'الباقة الأكثر طلباً للنظافة والنعومة الدائمة',
            'price' => 1199.00,
            'currency' => 'ريال',
            'is_featured' => true,
            'featured_badge' => 'الأكثر مبيعاً ⭐',
            'features' => [
                ['text' => '4 جلسات ليزر جسم كامل مع الوش', 'is_included' => true],
                ['text' => '4 جلسات رتوش مجانية', 'is_included' => true],
                ['text' => 'استشارة مجانية مع أخصائية الليزر', 'is_included' => true],
                ['text' => 'تبريد كرايو المطور لراحة تامة', 'is_included' => true],
                ['text' => 'جلسة تفتيح المناطق الحساسة', 'is_included' => true],
            ],
            'cta_label' => 'احجز الباقة الأكثر مبيعاً',
            'cta_href' => '#book',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Package::create([
            'name' => 'باقة القوام المثالي',
            'tagline' => 'نحت وتنسيق القوام بدون جراحة',
            'price' => 1999.00,
            'currency' => 'ريال',
            'is_featured' => false,
            'featured_badge' => null,
            'features' => [
                ['text' => '3 جلسات مورفيوس للجسم', 'is_included' => true],
                ['text' => '3 جلسات كافيتيشن لتكسير الدهون', 'is_included' => true],
                ['text' => 'قياس كتلة ومتابعة مع الاستشاري', 'is_included' => true],
                ['text' => 'جلسة تصريف لمفاوي مجانية', 'is_included' => true],
                ['text' => 'مشد طبي مجاني', 'is_included' => false],
            ],
            'cta_label' => 'احجز هذه الباقة',
            'cta_href' => '#book',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 9. About Block
        AboutBlock::truncate();
        AboutBlock::create([
            'image' => 'images/who.webp',
            'badge_title' => 'مركز معتمد',
            'badge_text' => 'ترخيص وزارة الصحة 1400029311',
            'cards' => [
                ['title' => 'رؤيتنا', 'body' => 'أن نكون المرجع الأول للعناية الجلدية والتجميلية القائمة على الطب المبني على الدليل.'],
                ['title' => 'رسالتنا', 'body' => 'تقديم رعاية آمنة ومخصّصة لكل مريض، بأيدي نخبة من الأطباء وبأحدث التقنيات.'],
            ],
        ]);

        // 10. Spotlight Block
        SpotlightBlock::truncate();
        SpotlightBlock::create([
            'doctor_id' => $doc1->id,
            'eyebrow' => 'طبيب الشهر المميز',
            'name' => 'د. عبد الله الهاجري',
            'specialty' => 'استشاري الأمراض الجلدية والتجميل',
            'bio' => 'قاد د. عبد الله أكثر من 12,000 حالة تجميلية ناجحة، ويتخصص في إعادة بناء حجم الوجه بالفيلر الشفاف وعلاج التصبغات المعقدة.',
            'image' => 'images/founder.png',
            'stats' => [
                ['val' => '+16', 'lbl' => 'سنوات خبرة'],
                ['val' => '+12k', 'lbl' => 'حالة ناجحة'],
                ['val' => '99%', 'lbl' => 'نسبة الرضا'],
            ],
            'qualifications' => [
                'البورد الكندي في الأمراض الجلدية',
                'زمالة التجميل غير الجراحي من جامعة تورونتو',
                'محاضر معتمد في مؤتمرات الليزر العالمية',
            ],
            'cta_label' => 'احجز استشارة مع الدكتور',
            'cta_href' => '#book',
        ]);

        // 11. Nav Links
        NavLink::truncate();
        $navs = [
            ['label' => 'من نحن', 'href' => '#about', 'show_in_header' => true, 'show_in_footer' => true, 'is_cta' => false, 'sort_order' => 0],
            ['label' => 'الأطباء', 'href' => '#spotlight', 'show_in_header' => true, 'show_in_footer' => true, 'is_cta' => false, 'sort_order' => 1],
            ['label' => 'الخدمات', 'href' => '#services', 'show_in_header' => true, 'show_in_footer' => true, 'is_cta' => false, 'sort_order' => 2],
            ['label' => 'الباقات', 'href' => '#packages', 'show_in_header' => true, 'show_in_footer' => true, 'is_cta' => false, 'sort_order' => 3],
            ['label' => 'اعتماداتنا', 'href' => '#trust', 'show_in_header' => true, 'show_in_footer' => false, 'is_cta' => false, 'sort_order' => 4],
            ['label' => 'احجز الآن', 'href' => '#book', 'show_in_header' => true, 'show_in_footer' => true, 'is_cta' => true, 'sort_order' => 5],
        ];
        foreach ($navs as $n) {
            NavLink::create(array_merge($n, ['is_active' => true]));
        }

        // 12. Social Links
        SocialLink::truncate();
        SocialLink::create(['platform' => 'instagram', 'url' => 'https://instagram.com/palderma', 'sort_order' => 0, 'is_active' => true]);
        SocialLink::create(['platform' => 'x', 'url' => 'https://x.com/palderma', 'sort_order' => 1, 'is_active' => true]);
        SocialLink::create(['platform' => 'snapchat', 'url' => 'https://snapchat.com/add/palderma', 'sort_order' => 2, 'is_active' => true]);
        SocialLink::create(['platform' => 'whatsapp', 'url' => 'https://wa.me/966500000000', 'sort_order' => 3, 'is_active' => true]);

        // 13. Booking Options
        BookingOption::truncate();
        $opts = [
            'إزالة الشعر بالليزر',
            'حقن الفيلر والبوتوكس',
            'علاجات النضارة والهيدرافيدشال',
            'علاج التصبغات والآثار',
            'شد الوجه والمورفيوس',
            'نحت الجسم وتنسيق القوام',
            'زراعة الشعر وعلاج التساقط',
            'استشارة جلدية عامة',
        ];
        foreach ($opts as $idx => $opt) {
            BookingOption::create(['label' => $opt, 'sort_order' => $idx, 'is_active' => true]);
        }

        // Link each service to its matching booking option (same order, both lists
        // describe the same 8 services) so "احجز هذه الخدمة" can auto-select it.
        $bookingOptionsByOrder = BookingOption::orderBy('sort_order')->get();
        Service::orderBy('sort_order')->get()->each(function ($service, $index) use ($bookingOptionsByOrder) {
            $service->update(['booking_option_id' => $bookingOptionsByOrder->get($index)?->id]);
        });

        // 14. Site Settings
        SiteSetting::truncate();
        SiteSetting::create([
            'logo_primary' => 'images/branding/logo-primary-new.png',
            'logo_white' => 'images/branding/logo-white.svg',
            'favicon' => 'images/branding/logo-primary.svg',
            'phone' => '+966 9200 00000',
            'email' => 'info@palderma.sa',
            'address' => 'الرياض، طريق الملك فهد، حي الصحافة',
            'working_hours' => 'السبت - الخميس: 10:00 ص - 10:00 م',
            'copyright' => 'جميع الحقوق محفوظة © مجمع بالديرما الطبي 2026',
            'privacy_policy_url' => '#privacy',
            'terms_url' => '#terms',
            'seo_title' => 'مجمع بالديرما الطبي — عيادة الجلدية والتجميل والليزر بالرياض',
            'seo_description' => 'احجز موعدك في مجمع بالديرما الطبي بالرياض. نخبة من استشاريي الجلدية والتجميل والليزر بأحدث التقنيات العالمية.',
            'seo_og_image' => 'images/who.webp',
            'ga_tracking_id' => 'G-XXXXXXXXXX',
            'booking_privacy_note' => 'معلوماتك الشخصية محمية ومحافظ عليها بشرية بالكامل وفق نظام حماية البيانات الشخصية السعودي (PDPL).',
            'booking_success_message' => 'تم استلام طلب حجزك بنجاح! سيتواصل معك فريق الاستقبال خلال وقت قصير لتأكيد الموعد.',
        ]);

        // 15. FAQs
        Faq::truncate();
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

        // 16. Legal Pages
        LegalPage::truncate();
        LegalPage::create([
            'key' => 'privacy',
            'title' => 'سياسة الخصوصية',
            'content' => $this->privacyPolicyContent(),
        ]);
        LegalPage::create([
            'key' => 'terms',
            'title' => 'الشروط والأحكام',
            'content' => $this->termsContent(),
        ]);

        Schema::enableForeignKeyConstraints();
    }

    private function privacyPolicyContent(): string
    {
        return <<<'HTML'
        <p>آخر تحديث: 19/7/2026</p>
        <p>مرحبًا بكم في مجمع بالديرما الطبي. نحن نلتزم بحماية خصوصية عملائنا والحفاظ على سرية بياناتهم الشخصية، وتوضح هذه السياسة كيفية جمع المعلومات واستخدامها وحمايتها عند استخدامكم لموقعنا الإلكتروني وخدماتنا.</p>
        <h2>أولاً: المعلومات التي نقوم بجمعها</h2>
        <p>قد نقوم بجمع المعلومات التالية عند استخدامكم للموقع أو تعبئة نموذج الحجز:</p>
        <ul>
        <li>الاسم الكامل.</li>
        <li>رقم الهاتف.</li>
        <li>البريد الإلكتروني (اختياري).</li>
        <li>تفاصيل الخدمة المطلوبة والموعد المفضل.</li>
        <li>عنوان بروتوكول الإنترنت (IP) وبيانات المتصفح والجهاز.</li>
        <li>ملفات تعريف الارتباط (Cookies) لتحسين تجربة الاستخدام.</li>
        </ul>
        <h2>ثانياً: كيفية استخدام المعلومات</h2>
        <p>نستخدم البيانات التي نجمعها للأغراض التالية:</p>
        <ul>
        <li>معالجة طلبات الحجز وتأكيد المواعيد.</li>
        <li>التواصل مع العملاء بشأن الحجز أو الاستفسارات.</li>
        <li>تحسين تجربة استخدام الموقع وتطوير خدماتنا.</li>
        <li>إرسال العروض والرسائل التسويقية بعد الحصول على موافقة العميل، مع إمكانية إلغاء الاشتراك في أي وقت.</li>
        <li>الامتثال للأنظمة والقوانين المعمول بها.</li>
        </ul>
        <h2>ثالثاً: مشاركة المعلومات</h2>
        <p>يحرص مجمع بالديرما على عدم بيع أو تأجير أو مشاركة بيانات العملاء مع أي طرف ثالث، باستثناء الحالات التالية:</p>
        <ul>
        <li>أنظمة إدارة علاقات العملاء (CRM) المستخدمة لمتابعة الحجوزات.</li>
        <li>الجهات الحكومية أو القضائية عند وجود التزام قانوني.</li>
        <li>مزودي الخدمات التقنية اللازمة لتشغيل الموقع وتحسين أدائه.</li>
        </ul>
        <p>وفي جميع الأحوال، يتم مشاركة الحد الأدنى من المعلومات اللازمة فقط.</p>
        <h2>رابعاً: حماية المعلومات</h2>
        <p>نتخذ الإجراءات الأمنية والإدارية والتقنية المناسبة لحماية بيانات العملاء من الوصول غير المصرح به أو الاستخدام أو التعديل أو الإفصاح غير القانوني. ورغم ذلك، لا يمكن ضمان الأمان الكامل لأي عملية نقل بيانات عبر الإنترنت.</p>
        <h2>خامساً: ملفات تعريف الارتباط (Cookies)</h2>
        <p>يستخدم الموقع ملفات تعريف الارتباط لتحسين تجربة المستخدم وتحليل أداء الموقع. يمكن للمستخدم التحكم في ملفات تعريف الارتباط أو تعطيلها من خلال إعدادات المتصفح، مع العلم أن ذلك قد يؤثر على بعض وظائف الموقع.</p>
        <h2>سادساً: حقوق العميل</h2>
        <p>يحق للعميل وفق نظام حماية البيانات الشخصية السعودي (PDPL):</p>
        <ul>
        <li>الاطلاع على بياناته الشخصية.</li>
        <li>طلب تحديث أو تصحيح بياناته.</li>
        <li>طلب حذف بياناته متى كان ذلك مسموحًا به قانونيًا.</li>
        <li>إلغاء الاشتراك في الرسائل التسويقية في أي وقت.</li>
        </ul>
        <h2>سابعاً: حماية خصوصية الأطفال</h2>
        <p>لا تستهدف خدمات مجمع بالديرما الأشخاص الذين تقل أعمارهم عن 18 عامًا، ولا نقوم بجمع بيانات شخصية منهم عن قصد.</p>
        <h2>ثامناً: التعديلات على سياسة الخصوصية</h2>
        <p>يحتفظ مجمع بالديرما بحق تعديل أو تحديث سياسة الخصوصية في أي وقت بما يتوافق مع المتطلبات القانونية أو التشغيلية، ويتم نشر النسخة المحدثة على هذه الصفحة مع توضيح تاريخ آخر تحديث.</p>
        <h2>تاسعاً: التواصل معنا</h2>
        <p>إذا كانت لديكم أي استفسارات أو طلبات تتعلق بسياسة الخصوصية أو ببياناتكم الشخصية، يمكنكم التواصل معنا عبر البريد الإلكتروني: info@palderma.sa</p>
        <p>باستخدامكم موقع مجمع بالديرما، فإنكم تقرون باطلاعكم على سياسة الخصوصية هذه وتوافقون على ما ورد فيها.</p>
        HTML;
    }

    private function termsContent(): string
    {
        return <<<'HTML'
        <p>آخر تحديث: 19/7/2026</p>
        <p>تحكم هذه الشروط والأحكام استخدامكم لموقع مجمع بالديرما الطبي وخدماته. يُرجى قراءتها بعناية قبل حجز أي موعد أو استخدام الموقع.</p>
        <h2>أولاً: قبول الشروط</h2>
        <p>باستخدامكم لهذا الموقع أو حجز أي خدمة عبره، فإنكم توافقون على الالتزام بهذه الشروط والأحكام وبكافة الأنظمة المعمول بها في المملكة العربية السعودية.</p>
        <h2>ثانياً: الخدمات المقدمة</h2>
        <p>يقدم مجمع بالديرما خدمات طبية وتجميلية جلدية على يد نخبة من الأطباء الاستشاريين. تخضع كل حالة لتقييم واستشارة طبية مسبقة لتحديد مدى ملاءمة الخدمة قبل البدء بأي علاج.</p>
        <h2>ثالثاً: الحجز والمواعيد</h2>
        <p>يعتبر تعبئة نموذج الحجز طلباً أولياً يخضع لتأكيد فريق الاستقبال. يلتزم العميل بالحضور في الموعد المحدد، وفي حال الرغبة بالتأجيل أو الإلغاء يُرجى التواصل معنا مسبقاً بوقت كافٍ.</p>
        <h2>رابعاً: الأسعار والدفع</h2>
        <p>تُحدَّد أسعار الخدمات بناءً على تقييم الحالة وعدد الجلسات المطلوبة، ويتم توضيحها للعميل قبل بدء العلاج. تخضع طرق الدفع المتاحة لما هو معمول به داخل المركز.</p>
        <h2>خامساً: الملكية الفكرية</h2>
        <p>جميع الحقوق المتعلقة بمحتوى هذا الموقع من نصوص وصور وشعارات مملوكة لمجمع بالديرما الطبي، ولا يجوز نسخها أو إعادة استخدامها دون إذن كتابي مسبق.</p>
        <h2>سادساً: حدود المسؤولية</h2>
        <p>نبذل قصارى جهدنا لتقديم رعاية طبية آمنة وفق أحدث المعايير المعتمدة، إلا أن النتائج قد تختلف من حالة لأخرى تبعاً لطبيعة كل عميل واستجابته للعلاج.</p>
        <h2>سابعاً: التعديلات على الشروط</h2>
        <p>يحتفظ مجمع بالديرما بحق تعديل هذه الشروط والأحكام في أي وقت، ويتم نشر أي تحديث على هذه الصفحة.</p>
        <h2>ثامناً: القانون الحاكم</h2>
        <p>تخضع هذه الشروط والأحكام لأنظمة المملكة العربية السعودية، وتختص محاكمها بالفصل في أي نزاع ينشأ عنها.</p>
        <h2>تاسعاً: التواصل معنا</h2>
        <p>لأي استفسار بخصوص هذه الشروط، يمكنكم التواصل معنا عبر البريد الإلكتروني: info@palderma.sa</p>
        HTML;
    }
}
