<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo_primary',
        'logo_white',
        'favicon',
        'phone',
        'email',
        'address',
        'working_hours',
        'copyright',
        'privacy_policy_url',
        'terms_url',
        'seo_title',
        'seo_description',
        'seo_og_image',
        'ga_tracking_id',
        'gtm_id',
        'booking_privacy_note',
        'booking_success_message',
    ];
}
