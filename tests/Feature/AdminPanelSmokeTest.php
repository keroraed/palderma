<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\LandingContentSeeder::class);
    }

    /**
     * Every admin list/index page must render without a fatal error.
     * This is exactly the class of bug (bad Filament namespace, unregistered
     * class, malformed form()/table()) that only ever surfaces at runtime.
     */
    public function test_all_admin_list_pages_render(): void
    {
        $admin = User::first() ?? User::factory()->create();

        $paths = [
            '/admin',
            '/admin/sections',
            '/admin/hero-slides',
            '/admin/stats',
            '/admin/doctors',
            '/admin/services',
            '/admin/certifications',
            '/admin/testimonials',
            '/admin/packages',
            '/admin/nav-links',
            '/admin/social-links',
            '/admin/booking-options',
            '/admin/bookings',
            '/admin/site-settings-page',
            '/admin/about-block-page',
            '/admin/spotlight-block-page',
            '/admin/zoho-settings',
        ];

        foreach ($paths as $path) {
            $this->actingAs($admin)->get($path)->assertOk();
        }
    }

    /**
     * Every admin "create" page must render without a fatal error
     * (this is where form()/schema-only bugs tend to hide, since
     * index pages only call table()).
     */
    public function test_all_admin_create_pages_render(): void
    {
        $admin = User::first() ?? User::factory()->create();

        $paths = [
            '/admin/hero-slides/create',
            '/admin/stats/create',
            '/admin/doctors/create',
            '/admin/services/create',
            '/admin/certifications/create',
            '/admin/testimonials/create',
            '/admin/packages/create',
            '/admin/nav-links/create',
            '/admin/social-links/create',
            '/admin/booking-options/create',
        ];

        foreach ($paths as $path) {
            $this->actingAs($admin)->get($path)->assertOk();
        }
    }
}
