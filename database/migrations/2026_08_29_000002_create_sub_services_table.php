<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('badge')->nullable();
            $table->text('description');
            $table->string('duration')->nullable();
            $table->string('target_area')->nullable();
            $table->json('features')->nullable();
            $table->text('aftercare_tips')->nullable();
            $table->foreignId('booking_option_id')->nullable()->constrained('booking_service_options')->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_services');
    }
};
