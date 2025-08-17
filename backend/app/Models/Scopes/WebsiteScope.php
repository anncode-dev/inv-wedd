<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class WebsiteScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Jika user bukan admin, terapkan filter
            if (!$user->isSuperAdmin()) {  
                $builder->where('type_website_id', $user->type_website_id)
                        ->whereHas('creator', function ($query) use ($user) {
                            $query->where('units', $user->units);
                        });
            }
        }
    }
}
