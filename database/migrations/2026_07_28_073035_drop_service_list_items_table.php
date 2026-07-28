<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Services were unified back into a single `services` table + a
     * dedicated "view all" page instead of a separate flat list.
     */
    public function up(): void
    {
        Schema::dropIfExists('service_list_items');
    }

    public function down(): void
    {
        Schema::create('service_list_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
