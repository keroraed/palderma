<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkHubSetting extends Model
{
    protected $fillable = [
        'logo',
        'title',
        'tagline',
    ];
}
