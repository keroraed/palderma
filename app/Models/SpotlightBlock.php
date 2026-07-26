<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpotlightBlock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'eyebrow',
        'name',
        'specialty',
        'bio',
        'image',
        'stats',
        'qualifications',
        'cta_label',
        'cta_href',
    ];

    protected $casts = [
        'stats' => 'array',
        'qualifications' => 'array',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
