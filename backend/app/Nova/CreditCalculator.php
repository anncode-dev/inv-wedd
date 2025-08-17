<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreditCalculator extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\CreditCalculator>
     */
    public static $model = \App\Models\CreditCalculator::class;

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
        'id','name'
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
            Text::make('Name')
                ->sortable()                
                ->rules('required', 'max:255'),

            Select::make('Credit Type','type')->options([
                'KBR' => 'KPR SUBSIDI',
                'KBP' => 'KMG PENSIUNAN',
                'KUR' => 'KUR',
                'KMG' => 'KMG UTAMA',
            ])->rules('required')->displayUsingLabels(),
            
            Select::make('Month / Year','month_year')->options([
                'month' => 'Month',
                'year' => 'Year',
            ])->rules('required')->displayUsingLabels(),

            SimpleRepeatable::make('Periods', 'periods', [
                Number::make('Loan term (Month/Year)','loan_term')
                ->sortable()
                ->rules('required', 'max:255'),
                Number::make('Interest')->step('any')->rules('required', 'max:5'), //panjang char max 5
            ])
            ->canAddRows(true) // Optional, true by default
            ->canDeleteRows(true),
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
