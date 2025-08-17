<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Aksel extends Model
{
    use HasTranslations;
    public $translatable = ['name', 'short_description'];
    protected $casts = [
        'name' => 'array',
        'short_description' => 'array',
    ];
}
