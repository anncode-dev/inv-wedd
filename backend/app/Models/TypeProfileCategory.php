<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeProfileCategory extends Model
{
    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }
}
