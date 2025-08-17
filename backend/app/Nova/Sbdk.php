<?php

namespace App\Nova;

use App\Nova\Filters\NewsFilter;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaCkEditor\CkEditor;

class Sbdk extends Resource
{   
    public static function label() {
        return 'SBDK';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('type', 3); //SBDK
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\News>
     */
    public static $model = \App\Models\Sbdk::class;

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
            //ID::make()->sortable(),
            //BelongsTo::make('Website', 'typeWebsite', typeWebsite::class),
            Hidden::make('created_by')->default(auth()->id()),
            Hidden::make('Type')->default(3),
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->translatable(),
                
            CkEditor::make('Table/Content', 'description')
                ->rules('required')
                ->resolveUsing(fn ($value) => $value ?? '')
                ->translatable(),

            CkEditor::make('Information', 'short_description')
                ->rules('required')
                ->resolveUsing(fn ($value) => $value ?? '')
                ->translatable(),            
            //Markdown::make('Short Description')->rules('max:255'),

            // NovaTinyMCE::make('Content','description')
            //     ->placeholder('Enter News Here')
            //     ->id('description')
            //     ->withMeta(['mediaLibrary' => true]),
            Boolean::make('Is active')->default(1),            
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
        return [new \App\Nova\Filters\WebsiteFilter];
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

    public function authorizedToUpdate(Request $request): bool
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            return true;
        }

        $isAuthorized = $this->type_website_id == $user->type_website_id 
            && optional($this->creator)->units == $user->units;

        if (!$isAuthorized) {
            abort(403, 'Forbidden');
        }

        return $isAuthorized;
    }

    public function authorizedToView(Request $request): bool
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            return true;
        }

        $isAuthorized = $this->type_website_id == $user->type_website_id 
            && optional($this->creator)->units == $user->units;

        if (!$isAuthorized) {
            abort(403, 'Forbidden');
        }

        return $isAuthorized;
    }

    public function authorizedToReplicate(Request $request): bool
    {
        $user = $request->user();

        // Admin bisa mengedit semua berita
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Hanya bisa mengedit jika berita dari unitnya sendiri
        return $this->type_website_id == $user->type_website_id 
            && optional($this->creator)->units == $user->units;
    }
}
