<?php

namespace App\Nova;

use App\Nova\Actions\DownloadExcel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
//use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ContactUs extends Resource
{   
    public static function label() {
        return 'ContactUs';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ContactUs>
     */
    public static $model = \App\Models\ContactUs::class;

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
        'id','name','email'
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
            Text::make('About')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Email')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Phone')
                ->sortable()
                ->rules('required', 'max:255'),
            Markdown::make('Description','desc'),
            Markdown::make('Description','desc')->onlyOnExport(),
            DateTime::make('Created At')
                ->sortable()
                ->displayUsing(function ($value) {
                    return $value ? $value->format('d M Y H:i:s') : null;
                }),
                
            Select::make('Status')
                ->options([
                    0 => 'Waiting',
                    1 => 'Done',
                ])
                ->displayUsingLabels()
                ->rules('required')->onlyOnForms(),
            
            Badge::make('Status')->map([
                0 => 'warning',
                1 => 'success',
            ])->icons([
                'warning' => 'clock',
                'success' => 'check-circle',
            ])->labels([
                0 => 'Waiting',
                1 => 'Done',
            ])         
                
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
        return [
            new \App\Nova\Actions\ContactUsResolved,
            (new DownloadExcel)->withHeadings('#', 'About', 'Name', 'Email', 'Phone', 'Description', 'Created At', 'Status')->askForWriterType(),
        ];
    }
}
