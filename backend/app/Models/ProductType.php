<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;

    // Kolom yang akan digunakan untuk soft delete
    protected $dates = ['deleted_at'];
    
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function Product()
    {
        return $this->hasMany(Product::class);
    }
}
