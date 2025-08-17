<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
//use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaCkEditor\CkEditor;

class ProductDetail extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductDetail>
     */
    public static $model = \App\Models\ProductDetail::class;

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
            Image::make('Icon Menu', 'image') // second parameter is the media collection name
                ->help('Format Webp & Max file size 2mb')                
                ->creationRules('required'),
                
            Text::make('Menu')
                ->sortable()
                ->rules('required', 'max:20')
                ->translatable(),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->translatable(),

            Markdown::make('Short Description')
                ->help('Max character 255')               
                ->rules('max:255')
                ->translatable(),

            CkEditor::make('Description')
                ->resolveUsing(fn ($value) => $value ?? '')
                ->translatable(),
            
            /* File::make('File', 'url_download')
                ->help('Max file size 100mb')   
                ->rules("max:100000")                
                ->path('product')->prunable(), */
                
            // NovaTinyMCE::make('Description','description')
            //     ->placeholder('Enter Description Here')
            //     ->id('description')
            //     ->withMeta(['mediaLibrary' => true])
            //     ->updateRules('required')
            //     ->creationRules('required'),
        ];
    }

        /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/products/'.$request->get('viaResourceId');
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
        return '/resources/products/'.$request->get('viaResourceId');
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
