<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('hero_badge')->nullable()->after('icon_value');
            $table->string('meta_title')->nullable()->after('hero_badge');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['slug', 'hero_badge', 'meta_title', 'meta_description']);
        });
    }
};
