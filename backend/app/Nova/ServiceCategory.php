<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Boolean;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Http\Requests\NovaRequest;

class ServiceCategory extends Resource
{   
    public static function label() {
        return 'Categories';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductCategory>
     */
    public static $model = \App\Models\ProductCategory::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title'
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('type', 1); //Service
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make('Website', 'typeWebsite', typeWebsite::class)
                ->canSee(fn ($request) => $request->user()->isSuperAdmin())  // Hanya admin yang bisa melihat
                ->readonly(fn ($request) => !$request->user()->isSuperAdmin())  // Admin bisa memilih, user tidak bisa mengedit
                ->default(function ($request) {
                    // Untuk user, set default value berdasarkan type_website_id yang sudah ada
                    if (!$request->user()->isSuperAdmin()) {
                        return $request->user()->type_website_id;
                    }
                    return null; // Admin tidak perlu default
                }),
            Hidden::make('Type')->default(1), //Service
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')->translatable(),
            Markdown::make('Note')->rules('max:255')->translatable(),
            Images::make('Background Image', 'main') // second parameter is the media collection name
                ->help('Format Webp & Max file size 2mb')                
                ->rules('required'), // validation rules
            Boolean::make('Is active')->default(1),

            HasMany::make('Category Details', 'typeProduct', 'App\Nova\ProductType')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
