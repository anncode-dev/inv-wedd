<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ProductDetail extends Model
{   
    use HasTranslations, SoftDeletes;

    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];

    protected $guarded =[];
    public $translatable = ['title'];
    protected $casts = [        
        'menu' => 'array',        
        'title' => 'array',        
        'short_description' => 'array',
        'description' => 'array',
    ];
}
