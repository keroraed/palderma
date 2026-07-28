<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * A string(191) column truncated a Google Maps search URL built from a
     * long real address, throwing "Data too long for column 'url'" on
     * production. URLs have no meaningful length ceiling, so widen it.
     * Raw SQL because doctrine/dbal (required by Schema::change()) isn't
     * installed in this project.
     */
    public function up(): void
    {
        // SQLite (local dev) has no fixed-length VARCHAR limit to begin with,
        // and doesn't support MODIFY COLUMN — nothing to do there.
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE link_hub_items MODIFY url TEXT NOT NULL');
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE link_hub_items MODIFY url VARCHAR(191) NOT NULL');
        }
    }
};
