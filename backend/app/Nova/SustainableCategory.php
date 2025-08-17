<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Http\Requests\NovaRequest;

class SustainableCategory extends Resource
{   
    public static function label() {
        return 'Keberlanjutan';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\CorporateGovernanceCategory>
     */
    public static $model = \App\Models\CorporateGovernanceCategory::class;

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
        return $query->where('type',2); //Keberlanjutan
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
            Hidden::make('Type')->default(2), //Keberlanjutan
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
                ->rules('required', 'max:255')->translatable(),

            Markdown::make('Short Description')
                ->help('Max character 255')               
                ->rules('max:255')->translatable(),
            Image::make('Image')
                ->help('Format Webp & Max file size 1mb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('feature')->prunable(),          

            Image::make('Image Content')
                ->help('Format Webp & Max file size 1mb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('feature')->prunable(), 

            Image::make('Image Content (mobile)','image_mobile')
                ->help('Format Webp & Max file size 1mb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('feature')->prunable(), 

            HasMany::make('Detail Information', 'detail', 'App\Nova\Sustainable')
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

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return true;
    }  

    public function authorizedToReplicate(Request $request)
    {     
        return false;
    } 
}
