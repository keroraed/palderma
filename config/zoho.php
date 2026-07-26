<?php

return [
    'enabled' => env('ZOHO_ENABLED', false),

    'client_id' => env('ZOHO_CLIENT_ID'),
    'client_secret' => env('ZOHO_CLIENT_SECRET'),
    'refresh_token' => env('ZOHO_REFRESH_TOKEN'),

    'accounts_url' => env('ZOHO_ACCOUNTS_URL', 'https://accounts.zoho.com'),
    'api_domain' => env('ZOHO_API_DOMAIN', 'https://www.zohoapis.com'),

    'company_fallback' => env('ZOHO_COMPANY_FALLBACK', 'مجمع بالديرما الطبي'),

    'fields' => [
        'service' => env('ZOHO_FIELD_SERVICE', 'Service'),
        'preferred_date' => env('ZOHO_FIELD_PREFERRED_DATE', 'Preferred_Date'),
        'submission_time' => env('ZOHO_FIELD_SUBMISSION_TIME', 'Website_Submission_Time'),
    ],
];
