<?php

namespace App\Nova;

use Alexwenzel\AjaxSelect\AjaxSelect as AjaxSelectAjaxSelect;
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
use Alexwenzel\DependencyContainer\DependencyContainer;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\File;
use Mostafaznv\NovaCkEditor\CkEditor;

class Product extends Resource
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
        return $query->whereRelation('productCategory', 'type', null);
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
                // Only on index
                BelongsTo::make('Product Category', 'productCategory', 'App\Nova\ProductCategory')->onlyOnIndex(),
                BelongsTo::make('Product Type', 'typeProduct', 'App\Nova\ProductType')->onlyOnIndex(),

                AjaxSelectAjaxSelect::make('Product Category', 'product_category_id')
                    ->get('/api/nova/type-website/{type_website_id}')
                    ->parent('type_website_id'),                
                
                AjaxSelectAjaxSelect::make('Product Type', 'product_type_id')
                    ->get('/api/nova/product-category/{product_category_id}')
                    ->parent('product_category_id'),

                Text::make('Name','title')
                    ->sortable()
                    ->rules('required', 'max:255')->translatable(),

                CkEditor::make('Content', 'short_description')
                    ->rules('required')
                    ->resolveUsing(fn ($value) => $value ?? '')
                    ->hideFromIndex()
                    ->translatable(),

                Images::make('Background Image', 'main') // second parameter is the media collection name
                        ->help('Format Webp & Max file size 1mb')   
                        ->rules("required"),
                        
                Boolean::make('Is active')->default(1),
                HasMany::make('Product Details', 'ProductDetail', 'App\Nova\ProductDetail'),
                        
                File::make('Download File','file')
                    ->rules('nullable', 'file', 'mimes:pdf,jpg,png') // Validasi di backend
                    ->acceptedTypes('.pdf,.jpg,.png') // Batasi pilihan di frontend
                    ->help('Hanya file PDF, JPG, atau PNG yang diperbolehkan.')
                    ->path('product')->prunable(),

                Text::make('View in Frontend', function() {
                    $base = $this->type_website_id == 1 ? config("app.convent_url") : config("app.syariah_url"); 
                    $url = $base."/produk/detail/".Str::slug($this->title)."/{$this->id}";
                    return "<a href='{$url}' target='_blank' class='link-default'>Preview</a>";
                })->asHtml()->onlyOnDetail(),
        
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
                    new \App\Nova\Filters\ProductCategoryFilter,
                    new \App\Nova\Filters\ProductTypeFilter,
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
