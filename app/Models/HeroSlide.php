<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeroSlide extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tag',
        'title',
        'subtitle',
        'image_desktop',
        'image_mobile',
        'image_alt',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
