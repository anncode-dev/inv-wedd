<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Conventional extends Resource
{   

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/information-categories/'.$request->get('viaResourceId');
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
        return '/resources/information-categories/'.$request->get('viaResourceId');
    }


    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Conventional>
     */
    public static $model = \App\Models\Conventional::class;

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
        'id',
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
            //Select::make('Type')->options(procurement())->rules('required')->displayUsingLabels(),            

            BelongsTo::make('Category', 'category', InformationCategory::class),
            Text::make('Name')
                    ->sortable()
                    ->rules('required', 'max:255')
                    ->translatable(),

            Text::make('Url')
                    ->sortable(),

            File::make('File')
                ->help('Max file size 2mb')   
                ->rules("max:2000")
                ->creationRules('required')
                ->path('conventional')->prunable(),

            Boolean::make('Is active')->default(1),
            Text::make('Document','file', function () {
                    if($this->file){
                        $url = Storage::disk('public')->url($this->file);
                        return '<div>
                            <a href="' . $url . '" target="_blank">
                                <img src="' . asset('img/open-new-tab.png') . '" style="width: 30px;">
                            </a>
                        </div>';
                    }
                })->asHtml()->onlyOnIndex()
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
        return [new \App\Nova\Filters\InformationFilter ];
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
