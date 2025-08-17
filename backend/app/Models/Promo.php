<?php

namespace App\Models;

use App\Models\Scopes\TypeWebsiteScope;
use App\Models\Scopes\WebsiteScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Promo extends Model implements HasMedia
{   
    use InteractsWithMedia, HasTranslations, HasTranslatableSlug;

    protected $guarded =[];

    public $translatable = ['title', 'slug'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingLanguage(app()->getLocale());
    }

    protected $casts = [        
        'publish_date' => 'date',
        'title' => 'array',        
        'short_description' => 'array',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')->singleFile();
        $this->addMediaCollection('my_multi_collection');
    }

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }

    protected static function booted()
    {   
        ##Hanya user yg dibatasi untuk melihat news
        static::addGlobalScope(new WebsiteScope());

        ##Hanya user yg dibatasi untuk melihat news
        //static::addGlobalScope(new TypeWebsiteScope());

        static::creating(function ($model) {
            // Set type_website_id jika belum ada
            if (!$model->type_website_id) {
                $model->type_website_id = auth()->user()->type_website_id;
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
