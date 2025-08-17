<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Policy extends Resource
{   
    public static function label() {
        return 'Kebijakan';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Policy>
     */
    public static $model = \App\Models\Policy::class;

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

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->translatable(),

            Markdown::make('Short Description')
                ->help('Max character 255')               
                ->rules('max:255')->translatable(),
            Image::make('Background Image', 'image') // second parameter is the media collection name
                ->help('Format Webp & Max file size 2mb')  
                ->path('policy')          
                ->maxWidth(400)
                ->prunable()
                ->creationRules('required'),

            HasMany::make('Details Policy', 'detail', 'App\Nova\PolicyDetail')
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
