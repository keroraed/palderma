<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'specialty',
        'image',
        'bio',
        'experience_display',
        'patients_display',
        'qualifications',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'qualifications' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
