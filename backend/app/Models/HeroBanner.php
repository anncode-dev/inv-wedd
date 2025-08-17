<?php

namespace App\Models;

use App\Models\Scopes\TypeWebsiteScope;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected $guarded = [];

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
