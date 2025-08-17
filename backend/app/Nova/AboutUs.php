<?php

namespace App\Nova;

use App\Nova\Filters\WebsiteFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Mostafaznv\NovaCkEditor\CkEditor;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class AboutUs extends Resource
{   
    public static function label() {
        return 'AboutUs';
    }


    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AboutUs>
     */
    public static $model = \App\Models\AboutUs::class;

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
            //ID::make()->sortable(),
            //BelongsTo::make('Website', 'typeWebsite', typeWebsite::class),
            
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->translatable(),         

            CkEditor::make('Description','desc')
                ->resolveUsing(fn ($value) => $value ?? '')
                ->translatable(),

            HasMany::make('Detail Information', 'detail', 'App\Nova\AboutUsDetail'),
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
