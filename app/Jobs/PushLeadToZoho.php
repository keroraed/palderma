<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushLeadToZoho implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public function backoff(): array
    {
        return [60, 300, 900, 3600, 10800];
    }

    public function __construct(public Booking $booking)
    {
    }

    public function handle(): void
    {
        if (!config('zoho.enabled')) {
            $this->booking->update([
                'zoho_status' => 'skipped',
                'zoho_error' => 'Zoho integration disabled in config',
            ]);
            return;
        }

        try {
            $accessToken = $this->getAccessToken();
            $apiDomain = Cache::get('zoho_api_domain', config('zoho.api_domain', 'https://www.zohoapis.com'));

            $serviceField = config('zoho.fields.service', 'Service');
            $dateField = config('zoho.fields.preferred_date', 'Preferred_Date');
            $timeField = config('zoho.fields.submission_time', 'Website_Submission_Time');
            // No dedicated Zoho field for the preferred appointment time
            // exists by default — Preferred_Date is a plain Date field in
            // most Zoho setups and can't hold a time component. If the
            // client adds a custom field for it later, set
            // ZOHO_FIELD_PREFERRED_TIME and it's sent as its own field too;
            // until then it's still visible to reception either way, in
            // Description below.
            $preferredTimeField = config('zoho.fields.preferred_time');
            $companyFallback = config('zoho.company_fallback', 'مجمع بالديرما الطبي');

            $description = $this->booking->notes;

            if ($this->booking->preferred_date && $this->booking->preferred_time) {
                $preferredLine = 'الموعد المفضل: ' . $this->booking->preferred_date->format('Y-m-d')
                    . ' — الساعة ' . $this->booking->preferred_time;
                $description = $description ? $preferredLine . "\n\n" . $description : $preferredLine;
            }

            $payload = [
                'data' => [
                    [
                        'Last_Name' => $this->booking->name,
                        'Company' => $companyFallback,
                        'Phone' => $this->booking->phone,
                        'Mobile' => $this->booking->phone,
                        'Email' => $this->booking->email,
                        'Description' => $description,
                        'Lead_Source' => 'Website',
                        $serviceField => $this->booking->service_name,
                        $dateField => $this->booking->preferred_date ? $this->booking->preferred_date->format('Y-m-d') : null,
                        $timeField => $this->booking->created_at ? $this->booking->created_at->toIso8601String() : now()->toIso8601String(),
                        ...($preferredTimeField && $this->booking->preferred_time
                            ? [$preferredTimeField => $this->booking->preferred_time]
                            : []),
                    ],
                ],
                'trigger' => ['workflow']
            ];

            $response = Http::withToken($accessToken)
                ->post(rtrim($apiDomain, '/') . '/crm/v8/Leads', $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                $recordDetails = $responseData['data'][0] ?? null;

                if (($recordDetails['status'] ?? '') === 'success') {
                    $zohoLeadId = $recordDetails['details']['id'] ?? null;
                    $this->booking->update([
                        'zoho_lead_id' => $zohoLeadId,
                        'zoho_status' => 'synced',
                        'zoho_synced_at' => now(),
                        'zoho_attempts' => $this->booking->zoho_attempts + 1,
                        'zoho_error' => null,
                    ]);
                    return;
                }
                
                $errMsg = json_encode($recordDetails['details'] ?? $responseData);
                $this->markFailed($errMsg);
            } else {
                $this->markFailed('HTTP ' . $response->status() . ': ' . $response->body());
            }

        } catch (\Throwable $e) {
            Log::error('Zoho lead push exception: ' . $e->getMessage(), ['booking_id' => $this->booking->id]);
            $this->markFailed($e->getMessage());
            throw $e;
        }
    }

    protected function getAccessToken(): string
    {
        return Cache::remember('zoho_access_token', 3300, function () {
            $accountsUrl = config('zoho.accounts_url', 'https://accounts.zoho.com');
            $response = Http::asForm()->post(rtrim($accountsUrl, '/') . '/oauth/v2/token', [
                'grant_type' => 'refresh_token',
                'client_id' => config('zoho.client_id'),
                'client_secret' => config('zoho.client_secret'),
                'refresh_token' => config('zoho.refresh_token'),
            ]);

            if ($response->failed()) {
                throw new \Exception('Failed to refresh Zoho token: ' . $response->body());
            }

            $data = $response->json();
            if (isset($data['api_domain'])) {
                Cache::put('zoho_api_domain', $data['api_domain'], 86400);
            }

            return $data['access_token'] ?? throw new \Exception('No access_token returned by Zoho OAuth');
        });
    }

    protected function markFailed(string $error): void
    {
        $this->booking->update([
            'zoho_status' => 'failed',
            'zoho_attempts' => $this->booking->zoho_attempts + 1,
            'zoho_error' => $error,
        ]);
    }
}
