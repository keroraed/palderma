<?php

use App\Models\NavLink;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The "الأطباء" nav item pointed at the doctors grid (#doctors); it now
     * points at the featured doctor spotlight section (#spotlight) instead.
     * Targeted update — leaves every other nav link/admin edit untouched.
     */
    public function up(): void
    {
        NavLink::where('href', '#doctors')->update(['href' => '#spotlight']);
    }

    public function down(): void
    {
        NavLink::where('href', '#spotlight')->update(['href' => '#doctors']);
    }
};
