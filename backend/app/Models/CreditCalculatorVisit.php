<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCalculatorVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_calculator_id',
        'ip_address',
    ];

    public function header()
    {
        return $this->belongsTo(CreditCalculator::class);
    }
}