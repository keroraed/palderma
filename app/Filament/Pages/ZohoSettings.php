<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ZohoSettings extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cpu-chip';

    protected static \UnitEnum|string|null $navigationGroup = 'الإعدادات والربط';

    protected static ?string $navigationLabel = 'ربط Zoho CRM';

    protected static ?string $title = 'إعدادات وحالة ربط Zoho CRM';

    protected string $view = 'filament.pages.zoho-settings';

    public bool $isConfigured = false;
    public ?string $lastSyncTime = null;
    public int $failedCount = 0;
    public int $syncedCount = 0;

    public function mount(): void
    {
        $this->isConfigured = (bool) config('zoho.enabled')
            && !empty(config('zoho.client_id'))
            && !empty(config('zoho.refresh_token'));

        $lastSync = Booking::where('zoho_status', 'synced')->latest('zoho_synced_at')->first();
        $this->lastSyncTime = $lastSync?->zoho_synced_at?->format('Y-m-d H:i') ?? 'لم يتم بعد';

        $this->failedCount = Booking::where('zoho_status', 'failed')->count();
        $this->syncedCount = Booking::where('zoho_status', 'synced')->count();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('testConnection')
                ->label('فحص الاتصال مع Zoho')
                ->icon('heroicon-o-signal')
                ->color('primary')
                ->action('runTestConnection'),
        ];
    }

    public function runTestConnection(): void
    {
        if (!config('zoho.enabled')) {
            Notification::make()
                ->title('الربط معطّل في الإعدادات')
                ->body('يرجى تفعيل ZOHO_ENABLED=true في ملف .env وإدخال بيانات Self-Client.')
                ->warning()
                ->send();
            return;
        }

        try {
            $accountsUrl = config('zoho.accounts_url', 'https://accounts.zoho.com');
            $response = Http::asForm()->post(rtrim($accountsUrl, '/') . '/oauth/v2/token', [
                'grant_type' => 'refresh_token',
                'client_id' => config('zoho.client_id'),
                'client_secret' => config('zoho.client_secret'),
                'refresh_token' => config('zoho.refresh_token'),
            ]);

            if ($response->failed()) {
                throw new \Exception('فشل تجديد Access Token: ' . $response->body());
            }

            $data = $response->json();
            $accessToken = $data['access_token'] ?? null;
            $apiDomain = $data['api_domain'] ?? config('zoho.api_domain', 'https://www.zohoapis.com');

            if (!$accessToken) {
                throw new \Exception('لم يتم استلام Access Token من Zoho OAuth.');
            }

            // Test authenticated API call to Leads field metadata. Deliberately
            // NOT /settings/modules/Leads: that endpoint needs a broader scope
            // than this integration is granted (it only needs to create/read
            // leads and read field definitions), so it would 401 even when
            // the actual lead-creation flow works fine.
            $apiRes = Http::withToken($accessToken)
                ->get(rtrim($apiDomain, '/') . '/crm/v8/settings/fields?module=Leads');

            if ($apiRes->successful()) {
                Notification::make()
                    ->title('الاتصال ناجح مع Zoho CRM!')
                    ->body('تم التحقق من إمكانية الوصول إلى API وتوليد الرموز بنجاح.')
                    ->success()
                    ->send();
            } else {
                throw new \Exception('فشل الاستعلام من API: HTTP ' . $apiRes->status());
            }

        } catch (\Throwable $e) {
            Notification::make()
                ->title('فشل فحص الاتصال بـ Zoho')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }
}
