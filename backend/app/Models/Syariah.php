<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syariah extends Model
{   
    use SoftDeletes;
    
    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];
}
