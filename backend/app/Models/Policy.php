<?php

namespace App\Models;

use App\Models\Scopes\TypeWebsiteScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Policy extends Model
{
    use HasTranslations;

    protected $guarded =[];
    public $translatable = ['title'];
    protected $casts = [        
        'title' => 'array',        
        'short_description' => 'array'
    ];

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

    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }

    public function detail()
    {
        return $this->hasMany(PolicyDetail::class,'policies_id');
    }
}
