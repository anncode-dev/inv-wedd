<?php

namespace App\Models;

use App\Models\Scopes\TypeWebsiteScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileCategory extends Model
{   
    use HasTranslations, SoftDeletes;

    public $translatable = ['title','short_description'];
    
    protected $casts = [        
        'title' => 'array',
        'short_description' => 'array',
    ];

    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];
    
    public function detail()
    {
        return $this->hasMany(AboutUs::class);
    }

    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }

    protected static function booted()
    {   
        ##Hanya user yg dibatasi untuk melihat news
        static::addGlobalScope(new TypeWebsiteScope());

        static::creating(function ($model) {
            // Set type_website_id jika belum ada
            if (!$model->type_website_id) {
                $model->type_website_id = auth()->user()->type_website_id;
            }
        });
    }
}
