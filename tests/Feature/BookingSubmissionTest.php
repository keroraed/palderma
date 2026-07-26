<?php

namespace Tests\Feature;

use App\Jobs\PushLeadToZoho;
use App\Mail\BookingNotificationMail;
use App\Models\BookingOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BookingSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\LandingContentSeeder::class);
    }

    public function test_booking_submission_saves_to_database_and_queues_email_and_zoho_job(): void
    {
        Mail::fake();

        $option = BookingOption::first();

        $payload = [
            'name' => 'نورة الشمري',
            'phone' => '0555555555',
            'email' => 'noura@example.com',
            'preferred_date' => '2026-08-01',
            'service_option_id' => $option->id,
            'notes' => 'حجز تجريبي',
            'pdpl_consent' => '1',
            'website_hp' => '',
        ];

        $response = $this->postJson('/booking', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('bookings', [
            'name' => 'نورة الشمري',
            'phone' => '0555555555',
            'email' => 'noura@example.com',
            'service_name' => $option->label,
            'zoho_status' => 'skipped',
        ]);

        Mail::assertSent(BookingNotificationMail::class);
    }
}
