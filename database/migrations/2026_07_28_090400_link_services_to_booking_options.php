<?php

use App\Models\BookingOption;
use App\Models\Service;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The "احجز هذه الخدمة" auto-select never worked because no service had
     * booking_option_id set — the two lists were seeded separately and never
     * linked. Both lists describe the same services in the same order, so
     * link them positionally. Only fills in services that are still
     * unlinked, so any admin-made links are left alone.
     */
    public function up(): void
    {
        $bookingOptionsByOrder = BookingOption::orderBy('sort_order')->get();

        Service::whereNull('booking_option_id')->orderBy('sort_order')->get()
            ->each(function ($service, $index) use ($bookingOptionsByOrder) {
                $option = $bookingOptionsByOrder->get($index);
                if ($option) {
                    $service->update(['booking_option_id' => $option->id]);
                }
            });
    }

    public function down(): void
    {
        Service::query()->update(['booking_option_id' => null]);
    }
};
