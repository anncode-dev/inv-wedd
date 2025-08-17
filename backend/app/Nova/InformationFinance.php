<?php

namespace App\Nova;

use App\Nova\Filters\CategoryInformationFilter;
use App\Nova\Filters\YearFilter;
use App\Nova\Filters\YearTataKelolaFilter;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Laravel\Nova\Fields\Hidden;

class InformationFinance extends Resource
{   
    
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\CorporateGovernance>
     */
    public static $model = \App\Models\CorporateGovernance::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','month','filename'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/information-finance-categories/'.$request->get('viaResourceId');
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
        return '/resources/information-finance-categories/'.$request->get('viaResourceId');
    }

    public function fields(NovaRequest $request)
    {   
        $getTahun = getyears();
        $currentDate = new DateTime();
        $year = $currentDate->format('Y');
        $mth = $currentDate->format('m');
        $id = $request->get('viaResourceId') ?? null;
        $c = \App\Models\CorporateGovernanceCategory::where('type',1)->where('id',$id)->first();
        $category   = $c->category ?? null;
        
        return [
            //ID::make()->sortable(),    
            //BelongsTo::make('Category', 'header', CorporateGovernanceCategory::class),                    
            Select::make('Category', 'corporate_governance_category_id')->searchable()
                ->options(\App\Models\CorporateGovernanceCategory::where('type',1)->pluck('title', 'id'))->displayUsingLabels()->default($id)
                ->withMeta(['extraAttributes' => ['readonly' => true]])
                ->rules('required'),

            Select::make('Report type','category')->searchable()
                ->options(\App\Models\TypeProfileCategory::pluck('title', 'id'))->displayUsingLabels()->default($category)
                //->withMeta(['extraAttributes' => ['readonly' => true]])
                ->rules('required')->onlyOnForms(),             
                                    
            // Tambahkan field Month untuk ditampilkan di Index
            Text::make('Quarterly','report_category', function () {
                $merge = Triwulan() + Caturwulan();                
                return $merge[$this->report_category] ?? null;
            })->onlyOnIndex(),
            
            Text::make('Month', function () {
                return ($this->month && strlen($this->month)==2) ? getNamaBulan()[$this->month] : null;
            })->onlyOnIndex(),
        
            DependencyContainer::make([
                Select::make('Type','report_category')
                    ->options(Triwulan()) // fungsi kamu tadi
                    ->displayUsingLabels()                    
                    ->rules('required')
                    //->help('This field is optional. Leave blank if it does not apply.')
                    ->default($mth),
                ])->dependsOn('category', 3),                        
            
            DependencyContainer::make([
                Select::make('Type','report_category')
                    ->options(Caturwulan()) // fungsi kamu tadi
                    ->displayUsingLabels()                    
                    ->rules('required')
                    //->help('This field is optional. Leave blank if it does not apply.')
                    ->default($mth),
                ])->dependsOn('category', 4),                        
            
            DependencyContainer::make([
                Select::make('Month')
                    ->options(getNamaBulan()) // fungsi kamu tadi
                    ->displayUsingLabels()                    
                    ->rules('required')
                    //->help('This field is optional. Leave blank if it does not apply.')
                    ->default($mth),
                ])->dependsOn('category', 1),                        

            Select::make('Year')->options($getTahun)->rules('required')->default($year),
            
            Text::make('Filename')
                ->sortable()
                ->rules('required', 'max:255'),
                
            Image::make('Image')
                ->help('Format Webp & Max file size 1mb')   
                ->rules("nullable", "image", "max:1000")
                ->creationRules('required')
                ->path('finance')->prunable(),
            
            File::make('File')
                ->help('Max file size 100mb')   
                ->rules("max:100000")
                //->creationRules('required')
                ->path('tata-kelola')->prunable(),

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
        return [new YearTataKelolaFilter];
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
