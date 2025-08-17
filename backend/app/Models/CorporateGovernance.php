<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateGovernance extends Model
{   
    use HasTranslations, SoftDeletes;

    // Kolom yang akan digunakan untuk soft delete jfdkjfdkfj dkfj df jdlfjdklj kljl adsasas
    protected $dates = ['deleted_at'];
    public $translatable = ['description'];
    
    protected $casts = [        
        'description' => 'array',        
    ];

    public function header()
    {
        return $this->belongsTo(CorporateGovernanceCategory::class,'corporate_governance_category_id');
    }
}
