<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'details',
        'features',
        'details_note',
        'icon_type',
        'icon_value',
        'booking_option_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function bookingOption(): BelongsTo
    {
        return $this->belongsTo(BookingOption::class);
    }
}
