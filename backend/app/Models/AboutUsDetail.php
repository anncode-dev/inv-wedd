<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUsDetail extends Model
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
    
    public function aboutus()
    {
        return $this->belongsTo(AboutUs::class, 'aboutus_id');
    }

    public function detail()
    {
        return $this->hasMany(AboutUsDetail::class,'aboutus_id');
    }

    public function category()
    {
        return $this->belongsTo(ProfileCategory::class, 'profile_category_id');
    }


}
