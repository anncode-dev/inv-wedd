<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ActiveStatus extends Filter
{
    public $name = 'Status Aktif';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('is_active', $value);
    }

    public function options(Request $request)
    {
        return [
            'Aktif' => 1,
            'Tidak Aktif' => 0,
        ];
    }
}
