<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCalculator extends Model
{
    protected $casts = [
        'periods' => 'array'
    ];
}
