<?php

namespace Tests\Feature;

use App\Filament\Pages\AboutBlockPage;
use App\Filament\Pages\SpotlightBlockPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression coverage for a class of bug that a plain HTTP 200 check cannot
 * catch: a custom Filament settings page that renders successfully but with
 * every field silently empty, because its schema was missing ->statePath()
 * so wire:model bound to a top-level property instead of `data.*`.
 */
class AdminFormBindingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\LandingContentSeeder::class);
    }

    public function test_about_block_page_form_is_prefilled_with_seeded_data(): void
    {
        $admin = User::first() ?? User::factory()->create();

        $component = Livewire::actingAs($admin)->test(AboutBlockPage::class)
            ->assertSet('data.badge_title', 'مركز معتمد')
            ->assertSet('data.badge_text', 'ترخيص وزارة الصحة 1400029311');

        $cards = array_values($component->get('data')['cards']);
        $this->assertSame('رؤيتنا', $cards[0]['title']);
    }

    public function test_spotlight_block_page_form_is_prefilled_with_seeded_data(): void
    {
        $admin = User::first() ?? User::factory()->create();

        $component = Livewire::actingAs($admin)->test(SpotlightBlockPage::class);
        $data = $component->get('data');

        $this->assertSame('د. عبد الله الهاجري', $data['name']);
        $this->assertSame('+16', array_values($data['stats'])[0]['val']);
        $this->assertSame('البورد الكندي في الأمراض الجلدية', array_values($data['qualifications'])[0]['qualification']);
    }

    public function test_doctor_and_hero_slide_images_resolve_on_the_public_assets_disk(): void
    {
        $admin = User::first() ?? User::factory()->create();

        $doctorHtml = $this->actingAs($admin)->get('/admin/doctors')->getContent();
        $this->assertStringContainsString('dr1.webp', $doctorHtml);

        $heroHtml = $this->actingAs($admin)->get('/admin/hero-slides')->getContent();
        $this->assertStringContainsString('Hero', $heroHtml);
    }
}
