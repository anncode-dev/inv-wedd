<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUs extends Model
{   
    use HasTranslations, SoftDeletes;

    protected $guarded =[];
    public $translatable = ['title'];
    protected $casts = [                
        'title' => 'array',        
        'desc' => 'array'
    ];
    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];

    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }

    public function category()
    {
        return $this->belongsTo(ProfileCategory::class,'profile_category_id');
    }
    
    public function detail()
    {
        return $this->hasMany(AboutUsDetail::class,'aboutus_id');
    }

    // protected static function booted()
    // {
    //     static::creating(function ($model) {
    //         // Set type_website_id jika belum ada
    //         if (!$model->type_website_id) {
    //             $model->type_website_id = auth()->user()->type_website_id;
    //         }
    //     });
    // }
}
