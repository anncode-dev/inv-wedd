<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;
    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];
    // Kolom yang dapat diisi
    protected $fillable = ['about', 'name', 'email', 'phone', 'desc','status'];
}
