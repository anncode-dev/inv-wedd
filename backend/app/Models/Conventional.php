<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conventional extends Model
{   
    use HasTranslations, SoftDeletes;

    protected $guarded =[];
    public $translatable = ['name'];
    protected $casts = [                     
        'name' => 'array',    
    ];
    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(InformationCategory::class,'information_category_id');
    }

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}
