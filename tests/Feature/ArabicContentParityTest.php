<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArabicContentParityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\LandingContentSeeder::class);
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_arabic_key_content_strings_exist_in_rendered_blade_output(): void
    {
        $response = $this->get('/');
        $html = $response->getContent();

        $keyStrings = [
            'جمالكِ وصحة بشرتكِ بأيدي نخبة استشاريي الجلدية والتجميل',
            'عاماً من الخبرة',
            'مريض سعيد',
            'عناية جلدية متكاملة تجمع بين الخبرة الطبية ولمسة التجميل',
            'د. عبد الله الهاجري',
            'د. خالد المطيري',
            'إزالة الشعر بالليزر',
            'حقن الفيلر والبوتوكس',
            'اعتماد المركز السعودي لمعايير المنشآت الصحية',
            'باقة النضارة الملكية',
            'باقة الليزر الشاملة',
            'احجز موعدك',
        ];

        foreach ($keyStrings as $str) {
            $this->assertStringContainsString($str, $html, "Missing Arabic string: {$str}");
        }
    }
}
