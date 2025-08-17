<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaCkEditor\CkEditor;

class CorporateGovernanceCategory extends Resource
{   
    public static function label() {
        return 'Tata Kelola Perusahaan';
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
        return $query->whereNull('type'); //Product
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
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')->translatable(),
            
            Select::make('Report type','category')->options(MonthlyReport())->displayUsingLabels(),//->help('<a href="/set-id-and-redirect?id='.$id.'">Add type</a>'), 
            Markdown::make('Short Description')
                ->help('Max character 255')               
                ->rules('max:255')->translatable(),
    
            CkEditor::make('Description')
                    //->rules('required')
                    ->resolveUsing(fn ($value) => $value ?? '')
                    ->hideFromIndex()
                    ->translatable(),

            Image::make('Image')
                ->help('Format Webp & Max file size 1mb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('feature')->prunable(),          

            HasMany::make('Detail Information', 'detail', 'App\Nova\CorporateGovernance')
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
