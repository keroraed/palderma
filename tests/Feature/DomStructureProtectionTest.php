<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomStructureProtectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\LandingContentSeeder::class);
    }

    public function test_doctors_grid_direct_child_count_is_exactly_six(): void
    {
        $response = $this->get('/');
        $html = $response->getContent();

        // Extract [data-grid="doctors"] block
        $pattern = '/<div[^>]*data-grid="doctors"[^>]*>(.*?)<\/section>/s';
        $this->assertEquals(1, preg_match($pattern, $html, $matches), 'data-grid="doctors" grid container not found in DOM');

        $gridInnerHtml = $matches[1];

        // Count direct doctor cards with data-doctor-card
        preg_match_all('/<div[^>]*data-doctor-card[^>]*>/', $gridInnerHtml, $cards);
        $this->assertCount(6, $cards[0], 'Doctors grid must contain exactly 6 card container elements for mobile carousel');
    }
}
