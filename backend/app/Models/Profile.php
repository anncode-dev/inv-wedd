<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function typeWebsite()
    {
        return $this->belongsTo(TypeWebsite::class);
    }

    public function profileCategory()
    {
        return $this->belongsTo(profileCategory::class);
    }
}
