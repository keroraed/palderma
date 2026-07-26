<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ZohoSyncStatusWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $failedCount = Booking::where('zoho_status', 'failed')->count();
        $pendingCount = Booking::where('zoho_status', 'pending')->count();
        $syncedCount = Booking::where('zoho_status', 'synced')->count();
        $totalNewThisWeek = Booking::where('created_at', '>=', now()->startOfWeek())->count();

        $stats = [
            Stat::make('حجوزات هذا الأسبوع', $totalNewThisWeek)
                ->description('إجمالي الطلبات الجديدة')
                ->color('info')
                ->icon('heroicon-o-calendar-days'),

            Stat::make('حجوزات مزامنة مع Zoho', $syncedCount)
                ->description('تم إنشاؤها بنجاح كـ Lead')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];

        if ($failedCount > 0) {
            $stats[] = Stat::make('فشل مزامنة Zoho', $failedCount)
                ->description('يتطلب إعادة المزامنة أو فحص الاتصال')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle');
        } else {
            $stats[] = Stat::make('حجوزات معلقة', $pendingCount)
                ->description('بانتظار تنفيذ المهام الخلفية')
                ->color('warning')
                ->icon('heroicon-o-clock');
        }

        return $stats;
    }
}
