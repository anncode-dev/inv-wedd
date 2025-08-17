<?php

namespace App\Models;

use App\Models\Scopes\TypeWebsiteScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model implements HasMedia
{   
    use InteractsWithMedia, HasTranslations, SoftDeletes;
 
    public $translatable = ['title','note'];

    protected $casts = [
        'title' => 'array',
        'note' => 'array',
    ];

    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];

    protected $guarded =[];

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
        return $query->where('is_active', 1);
    }

    public function typeProduct()
    {
        return $this->hasMany(ProductType::class);
    }

    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }

    protected static function booted()
    {   
        ##Hanya user yg dibatasi untuk melihat news
        static::addGlobalScope(new TypeWebsiteScope());
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title->id);  // Sesuaikan dengan field yang diinginkan
    }
}
