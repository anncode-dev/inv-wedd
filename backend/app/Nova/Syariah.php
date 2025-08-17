<?php

namespace App\Nova;

use App\Nova\Filters\CategoryInformationFilter;
use App\Nova\Filters\YearFilter;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
//use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Mostafaznv\NovaCkEditor\CkEditor;
use Laravel\Nova\Http\Requests\NovaRequest;

class Syariah extends Resource
{   
    public static function label() {
        return 'Informasi Syariah';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Syariah>
     */
    public static $model = \App\Models\Syariah::class;

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
        'id','month','year'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {   
        $getTahun = getyears();
        $currentDate = new DateTime();
        $year = $currentDate->format('Y');
        $mth = $currentDate->format('m');

        return [
            //ID::make()->sortable(),
            Select::make('Category')->options(SyariahInformation())->displayUsingLabels()->default(1)
                ->withMeta(['extraAttributes' => ['readonly' => true]]),
            //Select::make('Month')->options($last12Months)->rules('required')->default($mth),
            Select::make('Month')
                    ->options(getNamaBulan()) // fungsi kamu tadi
                    ->displayUsingLabels()                    
                    ->rules('required')
                    //->help('This field is optional. Leave blank if it does not apply.')
                    ->default($mth),

            Select::make('Year')->options($getTahun)->rules('required')->default($year),

            CkEditor::make('Content','description')
                ->placeholder('Enter News Here')
                ->rules([
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        // Deteksi tag script
                        if (preg_match('/<script|javascript:/i', $value)) {
                            $fail('Script tags or JavaScript code are not allowed.');
                        }
                        
                        // Deteksi event attributes
                        if (preg_match('/on\w+\s*=/i', $value)) {
                            $fail('Event attributes are not allowed.');
                        }
                    }
                ])
                ->resolveUsing(fn ($value) => $value ?? '')
                ->hideFromIndex(),
                //->translatable(),

            // NovaTinyMCE::make('Content','description')
            //     ->rules('required')
            //     ->placeholder('Enter News Here')
            //     ->id('description')
            //     ->withMeta(['mediaLibrary' => true]),
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
        return [new YearFilter, new CategoryInformationFilter];
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
