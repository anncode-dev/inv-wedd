<?php
namespace App\Nova;

use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\URL; 
use Laravel\Nova\Http\Requests\NovaRequest;

class Aksel extends Resource
{    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Aksel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'short_description', 'playstore_url', 'appstore_url'
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
            ID::make(__('ID'), 'id')->sortable(),
            // Text::make('Name')
            //     ->sortable()
            //     ->translatable()
            //     ->rules('required', 'max:255'),
            Hidden::make('Name')
                ->default('Aksel Apps')
                ->sortable(),
            Markdown::make('Short Description')
                ->help('Max character 255')   
                ->translatable()           
                ->rules('max:255')->translatable(),
            Image::make('Logo')
                ->sortable()
                ->path('aksel')
                ->prunable()
                ->rules('image')
                ->creationRules('required'),

            Image::make('Banner','image')
                ->sortable()
                ->path('aksel')
                ->prunable()
                ->rules('image')
                ->creationRules('required'),

            Url::make('Redirect URL', 'redirect_url')
                ->sortable()
                ->rules('nullable', 'url'),
            Url::make('Playstore URL', 'playstore_url')
                ->sortable()
                ->rules('nullable', 'url'),
            Url::make('Appstore URL', 'appstore_url')
                ->sortable()
                ->rules('nullable', 'url'),
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