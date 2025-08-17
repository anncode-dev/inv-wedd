<?php

namespace App\Nova;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
//use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\AjaxSelect\AjaxSelect as AjaxSelectAjaxSelect;
use Laravel\Nova\Fields\Hidden;

class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

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
        return $query->whereRelation('productCategory', 'type', 1);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        
        $fields = [
            Select::make('Website','type_website_id')->searchable()
                    ->options(\App\Models\TypeWebsite::pluck('name', 'id'))
                    //->canSee(fn ($request) => $request->user()->isSuperAdmin())  // Hanya admin yang bisa melihat
                        ->readonly(fn ($request) => !$request->user()->isSuperAdmin())  // Admin bisa memilih, user tidak bisa mengedit
                        ->default(function ($request) {
                            // Untuk user, set default value berdasarkan type_website_id yang sudah ada
                            if (!$request->user()->isSuperAdmin()) {
                                return $request->user()->type_website_id;
                            }
                            return null; // Admin tidak perlu default
                    })
                    ->displayUsingLabels(),
                Hidden::make('product_category_id')->default(11), //11 = Service
            // Only on index Service
            // BelongsTo::make('Service Category', 'productCategory', 'App\Nova\ProductCategory')->onlyOnIndex(),
            // BelongsTo::make('Service Type', 'typeProduct', 'App\Nova\ProductType')->onlyOnIndex(),

            // AjaxSelectAjaxSelect::make('Service Category', 'product_category_id')
            //     ->get('/api/nova/type-website/{type_website_id}?tag=1')
            //     ->parent('type_website_id'),                
            
            // AjaxSelectAjaxSelect::make('Service Type', 'product_type_id')
            //     ->get('/api/nova/product-category/{product_category_id}')
            //     ->parent('product_category_id'),

            Text::make('Name','title')
                ->sortable()
                ->rules('required', 'max:255')->translatable(),

            Markdown::make('Short Description')
                ->help('Max character 255')               
                ->rules('required', 'max:255')->translatable(),
            Images::make('Background Image', 'main')
                    ->help('Format Webp & Max file size 1mb')                
                    ->rules('required'),
            Boolean::make('Is active')->default(1),
            HasMany::make('Service Details', 'ProductDetail', 'App\Nova\ProductDetail'),
        ];
        
        return $fields;
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
        return [
                    new \App\Nova\Filters\WebsiteFilter,
                    // new \App\Nova\Filters\ProductCategoryFilter,
                    // new \App\Nova\Filters\ProductTypeFilter,
                ];
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
