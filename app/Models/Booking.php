<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'preferred_date',
        'service_option_id',
        'service_name',
        'notes',
        'pdpl_consent',
        'status',
        'ip_address',
        'user_agent',
        'zoho_lead_id',
        'zoho_status',
        'zoho_synced_at',
        'zoho_attempts',
        'zoho_error',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'pdpl_consent' => 'boolean',
        'zoho_synced_at' => 'datetime',
        'zoho_attempts' => 'integer',
    ];

    public function serviceOption(): BelongsTo
    {
        return $this->belongsTo(BookingOption::class, 'service_option_id');
    }
}
