<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Stored as a plain "HH:MM" string rather than a DB time column —
            // it's only ever validated, displayed, and sent to Zoho as text,
            // never used in a date/time calculation, so there's nothing to
            // gain from a native time type and it avoids timezone-conversion
            // surprises on read.
            $table->string('preferred_time', 5)->nullable()->after('preferred_date');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('preferred_time');
        });
    }
};
