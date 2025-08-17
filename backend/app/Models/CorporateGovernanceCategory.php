<?php

namespace App\Models;

use App\Models\Scopes\TypeWebsiteScope;
use App\Models\Scopes\WebsiteScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateGovernanceCategory extends Model
{   
    use HasTranslations, SoftDeletes;

    protected $guarded =[];
    public $translatable = ['title'];
    protected $casts = [                       
        'title' => 'array',        
        'short_description' => 'array',        
        'description' => 'array',        
    ];

    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];

    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }

    public function detail()
    {
        return $this->hasMany(CorporateGovernance::class)
            ->orderByDesc('year')
            ->orderByRaw("CASE WHEN month IS NULL THEN -1 ELSE month END DESC")
            ->orderByDesc('report_category')
            ->orderByDesc('created_at'); 
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
        
        static::updating(function ($model) {
            // Persiapkan field yang akan diupdate
            $dataToUpdate = [
                'category' => $model->category,
            ];
        
            // Tambahan kondisi tergantung $model->id
            switch ($model->category) {
                case 1:
                    $dataToUpdate['report_category'] = null;
                    break;
                case 2:
                    $dataToUpdate['report_category'] = null;
                    $dataToUpdate['month'] = null;
                    break;
                case 3:
                case 4:
                    $dataToUpdate['month'] = null;
                    break;
            }
        
            // Jalankan update ke semua record terkait
            CorporateGovernance::withoutGlobalScopes()
                ->where('corporate_governance_category_id', $model->id)
                ->update($dataToUpdate);
        });
        
    }
}
