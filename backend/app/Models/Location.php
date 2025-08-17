<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{   
    use HasTranslations;

    public $translatable = ['title'];

    protected $casts = [
        'title' => 'array',
        'address' => 'array',
    ];

    public function header()
    {
        return $this->belongsTo(LocationCategory::class,'location_category_id','id');
    }
}
