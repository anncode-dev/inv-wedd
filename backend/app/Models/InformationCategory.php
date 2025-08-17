<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class InformationCategory extends Model
{   
    use HasTranslations;

    protected $guarded =[];
    public $translatable = ['name'];
    protected $casts = [                     
        'name' => 'array',    
    ];

    public function detail()
    {
        return $this->hasMany(Conventional::class)->latest();
    }
}
