<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            // Extra in-article images with their own caption/alt text, since the
            // editor's native inline-image button has no storage backend wired
            // up in this Filament install (no FileAttachmentProvider ships with
            // it) — see BlogPostResource for the full reasoning.
            $table->json('gallery')->nullable();

            $table->foreignId('blog_category_id')->nullable()
                ->constrained('blog_categories')->nullOnDelete();
            $table->foreignId('author_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->string('status')->default('draft'); // draft | published
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // The listing/sitemap query is always "published, newest first";
            // the single-post lookup is always "slug + status". Both are
            // covered by these two composite indexes.
            $table->index(['status', 'published_at']);
            $table->index(['slug', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
