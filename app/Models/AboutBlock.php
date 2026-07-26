<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutBlock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image',
        'badge_title',
        'badge_text',
        'cards',
    ];

    protected $casts = [
        'cards' => 'array',
    ];
}
