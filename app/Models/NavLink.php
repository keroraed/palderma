<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavLink extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'label',
        'href',
        'show_in_header',
        'show_in_footer',
        'is_cta',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'show_in_header' => 'boolean',
        'show_in_footer' => 'boolean',
        'is_cta' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
