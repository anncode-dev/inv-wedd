<?php

namespace App\Nova;

use App\Nova\Filters\WebsiteFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Mostafaznv\NovaCkEditor\CkEditor;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class AboutUsDetail extends Resource
{   
    
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AboutUs>
     */
    public static $model = \App\Models\AboutUsDetail::class;

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
        'id','title','name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/about-uses/'.$request->get('viaResourceId');
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/about-uses/'.$request->get('viaResourceId');
    }
    
    public function fields(NovaRequest $request)
    {
        return [
            //ID::make()->sortable(),
            BelongsTo::make('About Us', 'aboutus', AboutUs::class),            
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),            
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->translatable(),

            Image::make('Image')
                ->help('Format Webp & Max file size 3 MB')   
                ->rules("nullable", "image", "max:3000")
                ->creationRules('required')
                ->path('aboutus')->prunable(),

            CkEditor::make('Description','desc')
                ->rules('required')
                ->resolveUsing(fn ($value) => $value ?? '')
                ->translatable(),
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
        return [new WebsiteFilter];
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
