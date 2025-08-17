<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use App\Models\Scopes\WebsiteScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sbdk extends Model
{   
    use HasTranslations, HasTranslatableSlug, SoftDeletes;
    
    protected $table = 'news'; // Ambil data dari tabel news
    protected $guarded =[];
    public $translatable = ['title', 'slug'];
    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];

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
        'image' => 'array',
        'description' => 'array',
        'short_description' => 'array',
    ];

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function scopeActiveAndPublished(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($subQuery) {
                $subQuery->whereNull('publish_date') // Tampilkan jika tanggal tidak diset
                    ->orWhere('publish_date', '<=', Carbon::today()); // Atau jika tanggal publikasi di masa lalu
            });
    }

    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    protected static function booted()
    {   
        ##Hanya user yg dibatasi untuk melihat news
        static::addGlobalScope(new WebsiteScope());

        static::creating(function ($model) {
            // Set type_website_id jika belum ada
            if (!$model->type_website_id) {
                $model->type_website_id = auth()->user()->type_website_id;
            }
        });
    }
}
