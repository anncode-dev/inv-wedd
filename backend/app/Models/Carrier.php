<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Carrier extends Model
{   
    use HasTranslations;
    public $translatable = ['name', 'description'];
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    protected $fillable = [
        'name',
        'description',
        'image',
        'url',
    ];
}
