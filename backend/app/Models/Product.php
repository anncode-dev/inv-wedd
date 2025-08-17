<?php

namespace App\Models;

use App\Models\Scopes\TypeWebsiteScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversion\Conversion;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{   
    use InteractsWithMedia, HasTranslations, SoftDeletes;
    
    public $translatable = ['short_description', 'slug','title'];

    protected $casts = [
        'title' => 'array',
        'short_description' => 'array',
    ];

    protected $guarded =[];
    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];
    
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
    
    public function typeProduct()
    {
        return $this->belongsTo(ProductType::class,'product_type_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }


    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    
    public function ProductDetail()
    {
        return $this->hasMany(ProductDetail::class);
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