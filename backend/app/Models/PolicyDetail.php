<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PolicyDetail extends Model
{
    use HasTranslations;

    protected $guarded =[];
    public $translatable = ['title'];
    protected $casts = [        
        'menu' => 'array',        
        'title' => 'array',        
        'description' => 'array'
    ];

    public function header()
    {
        return $this->belongsTo(Policy::class, 'policies_id', 'id');
    }

}
