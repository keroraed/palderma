<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drafts can now be saved half-finished (title first, write the body later),
     * so `content` has to accept NULL. Widening a NOT NULL constraint is
     * non-destructive: every existing row already satisfies the looser rule.
     * `excerpt` and `featured_image` were already nullable.
     */
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->longText('content')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Backfill before restoring NOT NULL, otherwise the change would fail
        // on any draft row saved without a body.
        DB::table('blog_posts')->whereNull('content')->update(['content' => '']);

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->longText('content')->nullable(false)->change();
        });
    }
};
