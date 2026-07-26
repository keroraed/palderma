<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Sections
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('eyebrow')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Hero Slides
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();
            $table->string('title');
            $table->text('subtitle');
            $table->string('image_desktop');
            $table->string('image_mobile');
            $table->string('image_alt')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Stats
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('value'); // display string e.g. "+15", "+8k", "4.9"
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Doctors
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialty');
            $table->string('image');
            $table->text('bio');
            $table->string('experience_display')->nullable();
            $table->string('patients_display')->nullable();
            $table->json('qualifications')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. Services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('icon_type', ['material', 'svg'])->default('material');
            $table->text('icon_value');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. Certifications
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->text('icon');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 7. Testimonials
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('service_label');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('quote');
            $table->string('avatar_initial')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 8. Packages
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('ريال');
            $table->boolean('is_featured')->default(false);
            $table->string('featured_badge')->nullable();
            $table->json('features')->nullable();
            $table->string('cta_label')->default('احجز هذه الباقة');
            $table->string('cta_href')->default('#book');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 9. About Blocks (Singleton)
        Schema::create('about_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('badge_title')->nullable();
            $table->string('badge_text')->nullable();
            $table->json('cards')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 10. Spotlight Blocks (Singleton)
        Schema::create('spotlight_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->string('eyebrow')->nullable();
            $table->string('name');
            $table->string('specialty');
            $table->text('bio');
            $table->string('image');
            $table->json('stats')->nullable();
            $table->json('qualifications')->nullable();
            $table->string('cta_label')->default('احجز استشارة مع الدكتور');
            $table->string('cta_href')->default('#book');
            $table->timestamps();
            $table->softDeletes();
        });

        // 11. Nav Links
        Schema::create('nav_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('href');
            $table->boolean('show_in_header')->default(true);
            $table->boolean('show_in_footer')->default(true);
            $table->boolean('is_cta')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 12. Social Links
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['instagram', 'x', 'youtube', 'tiktok', 'snapchat', 'whatsapp', 'facebook']);
            $table->string('url');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 13. Booking Service Options
        Schema::create('booking_service_options', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // 14. Site Settings (Singleton)
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_primary')->nullable();
            $table->string('logo_white')->nullable();
            $table->string('favicon')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('copyright')->nullable();
            $table->string('privacy_policy_url')->nullable();
            $table->string('terms_url')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_og_image')->nullable();
            $table->string('ga_tracking_id')->nullable();
            $table->text('booking_privacy_note')->nullable();
            $table->text('booking_success_message')->nullable();
            $table->timestamps();
        });

        // 15. Bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('preferred_date')->nullable();
            $table->foreignId('service_option_id')->nullable()->constrained('booking_service_options')->nullOnDelete();
            $table->string('service_name'); // snapshot of service option label
            $table->text('notes')->nullable();
            $table->boolean('pdpl_consent')->default(true);
            $table->enum('status', ['new', 'contacted', 'booked', 'attended', 'no_answer', 'cancelled'])->default('new');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('zoho_lead_id')->nullable();
            $table->enum('zoho_status', ['pending', 'synced', 'failed', 'skipped'])->default('pending');
            $table->timestamp('zoho_synced_at')->nullable();
            $table->unsignedInteger('zoho_attempts')->default(0);
            $table->text('zoho_error')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['zoho_status', 'created_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('booking_service_options');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('nav_links');
        Schema::dropIfExists('spotlight_blocks');
        Schema::dropIfExists('about_blocks');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('services');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('stats');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('sections');
    }
};
